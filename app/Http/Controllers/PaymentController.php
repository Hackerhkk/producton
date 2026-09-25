<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Throwable;

class PaymentController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::query()
            ->where('is_active', true)
            ->where('tests_access', true)
            ->orderBy('price')
            ->get();

        $latestSubscription = Auth::user()
            ->latestSubscription()
            ->with('plan')
            ->first();

        return view('subscription.index', [
            'plans' => $plans,
            'latestSubscription' => $latestSubscription,
            'razorpayKey' => config('services.razorpay.key'),
        ]);
    }

    public function createOrder(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
        ]);

        $user = Auth::user();

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is disabled.',
            ], 403);
        }

        if (!$user->tests_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Tests access is disabled for your account.',
            ], 403);
        }

        $plan = SubscriptionPlan::query()
            ->whereKey($request->integer('plan_id'))
            ->where('is_active', true)
            ->where('tests_access', true)
            ->first();

        if (!$plan) {
            return response()->json([
                'success' => false,
                'message' => 'This subscription plan is not available.',
            ], 422);
        }

        if ((float) $plan->price <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'This plan has an invalid price.',
            ], 422);
        }

        $amountInPaise = (int) round((float) $plan->price * 100);

        try {
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $receipt = 'sub_' . $user->id . '_' . Str::lower(
                Str::random(20)
            );

            $order = $api->order->create([
                'receipt' => $receipt,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'payment_capture' => 1,
            ]);

            $subscription = UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'razorpay_order_id' => $order['id'],
                'amount' => $plan->price,
                'status' => 'pending',
            ]);

            Payment::create([
                'user_id' => $user->id,
                'user_subscription_id' => $subscription->id,
                'razorpay_order_id' => $order['id'],
                'amount' => $plan->price,
                'currency' => 'INR',
                'status' => 'created',
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'key' => config('services.razorpay.key'),
                'plan_name' => $plan->name,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create payment order. Please try again.',
            ], 500);
        }
    }

    public function verifyPayment(Request $request): JsonResponse
    {
        $data = $request->validate([
            'razorpay_payment_id' => ['required', 'string', 'max:255'],
            'razorpay_order_id' => ['required', 'string', 'max:255'],
            'razorpay_signature' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();

        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is disabled.',
            ], 403);
        }

        if (!$user->tests_enabled) {
            return response()->json([
                'success' => false,
                'message' => 'Tests access is disabled for your account.',
            ], 403);
        }

        $subscription = UserSubscription::query()
            ->with('plan')
            ->where('user_id', $user->id)
            ->where('razorpay_order_id', $data['razorpay_order_id'])
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Payment order was not found.',
            ], 404);
        }

        if ($subscription->status === 'active') {
            return response()->json([
                'success' => true,
                'message' => 'This payment has already been processed.',
            ]);
        }

        if (!$subscription->plan || !$subscription->plan->tests_access) {
            return response()->json([
                'success' => false,
                'message' => 'This subscription plan is no longer valid.',
            ], 422);
        }

        try {
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            /*
             * Important:
             * Razorpay recommends using the order ID stored on your
             * server when generating/verifying the signature.
             */
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $subscription->razorpay_order_id,
                'razorpay_payment_id' => $data['razorpay_payment_id'],
                'razorpay_signature' => $data['razorpay_signature'],
            ]);

            $payment = $api->payment
                ->fetch($data['razorpay_payment_id']);

            $expectedAmount = (int) round(
                (float) $subscription->amount * 100
            );

            $paidAmount = (int) $payment['amount'];

            if ((string) $payment['order_id'] !== (string) $subscription->razorpay_order_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment order verification failed.',
                ], 422);
            }

            if ($paidAmount !== $expectedAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount verification failed.',
                ], 422);
            }

            if (strtolower((string) $payment['currency']) !== 'inr') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment currency verification failed.',
                ], 422);
            }

            if ((string) $payment['status'] !== 'captured') {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has not been captured yet.',
                ], 422);
            }

            DB::transaction(function () use (
                $subscription,
                $data,
                $payment
            ) {
                $lockedSubscription = UserSubscription::query()
                    ->lockForUpdate()
                    ->findOrFail($subscription->id);

                if ($lockedSubscription->status === 'active') {
                    return;
                }

                $existingActiveSubscription = UserSubscription::query()
                    ->where('user_id', $lockedSubscription->user_id)
                    ->where('id', '!=', $lockedSubscription->id)
                    ->where('status', 'active')
                    ->whereNotNull('expires_at')
                    ->where('expires_at', '>', now())
                    ->latest('expires_at')
                    ->lockForUpdate()
                    ->first();

                $startsAt = $existingActiveSubscription
                    ? $existingActiveSubscription->expires_at->copy()
                    : now();

                $expiresAt = $startsAt->copy()->addDays(
                    (int) $lockedSubscription->plan->duration_days
                );

                $lockedSubscription->update([
                    'razorpay_payment_id' => $data['razorpay_payment_id'],
                    'status' => 'active',
                    'starts_at' => $startsAt,
                    'expires_at' => $expiresAt,
                ]);

                Payment::query()
                    ->where('razorpay_order_id', $lockedSubscription->razorpay_order_id)
                    ->where('user_id', $lockedSubscription->user_id)
                    ->update([
                        'user_subscription_id' => $lockedSubscription->id,
                        'razorpay_payment_id' => $data['razorpay_payment_id'],
                        'status' => 'paid',
                        'paid_at' => now(),
                        'gateway_response' => $payment->toArray(),
                    ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Payment successful. Your test access is now active.',
            ]);
        } catch (SignatureVerificationError $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 422);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Payment could not be verified. Please contact support if money was deducted.',
            ], 500);
        }
    }
}
