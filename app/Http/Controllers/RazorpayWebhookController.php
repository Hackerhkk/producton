<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentWebhookEvent;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RazorpayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $rawBody = $request->getContent();
        $signature = (string) $request->header('X-Razorpay-Signature');
        $eventId = (string) $request->header('x-razorpay-event-id');

        if ($rawBody === '' || $signature === '') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid webhook request.',
            ], 400);
        }

        $webhookSecret = (string) config('services.razorpay.webhook_secret');

        if ($webhookSecret === '') {
            Log::error('Razorpay webhook secret is not configured.');

            return response()->json([
                'success' => false,
                'message' => 'Webhook configuration error.',
            ], 500);
        }

        $expectedSignature = hash_hmac(
            'sha256',
            $rawBody,
            $webhookSecret
        );

        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid Razorpay webhook signature.');

            return response()->json([
                'success' => false,
                'message' => 'Invalid signature.',
            ], 400);
        }

        if ($eventId === '') {
            return response()->json([
                'success' => false,
                'message' => 'Missing event ID.',
            ], 400);
        }

        try {
            $payload = json_decode($rawBody, true, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            Log::warning('Invalid Razorpay webhook JSON.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON.',
            ], 400);
        }

        $eventType = (string) ($payload['event'] ?? '');

        if ($eventType === '') {
            return response()->json([
                'success' => false,
                'message' => 'Missing event type.',
            ], 400);
        }

        /*
        |--------------------------------------------------------------------------
        | Duplicate protection
        |--------------------------------------------------------------------------
        */

        $existingEvent = PaymentWebhookEvent::query()
            ->where('event_id', $eventId)
            ->first();

        if ($existingEvent) {
            return response()->json([
                'success' => true,
                'message' => 'Webhook already processed.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Store webhook event
        |--------------------------------------------------------------------------
        */

        PaymentWebhookEvent::create([
            'event_id' => $eventId,
            'event_type' => $eventType,
            'payload' => $payload,
            'processed_at' => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Handle payment captured / order paid
        |--------------------------------------------------------------------------
        */

        if (in_array($eventType, [
            'payment.captured',
            'order.paid',
        ], true)) {
            $this->processSuccessfulPayment($payload);
        }

        /*
        |--------------------------------------------------------------------------
        | Handle failed payment
        |--------------------------------------------------------------------------
        */

        if ($eventType === 'payment.failed') {
            $this->processFailedPayment($payload);
        }

        PaymentWebhookEvent::query()
            ->where('event_id', $eventId)
            ->update([
                'processed_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    private function processSuccessfulPayment(array $payload): void
    {
        $paymentEntity = data_get(
            $payload,
            'payload.payment.entity',
            []
        );

        $orderEntity = data_get(
            $payload,
            'payload.order.entity',
            []
        );

        $paymentId = $paymentEntity['id'] ?? null;

        $orderId = $paymentEntity['order_id']
            ?? $orderEntity['id']
            ?? null;

        if (!$paymentId || !$orderId) {
            Log::warning('Razorpay webhook missing payment/order ID.', [
                'event' => $payload['event'] ?? null,
            ]);

            return;
        }

        DB::transaction(function () use (
            $paymentId,
            $orderId,
            $paymentEntity
        ) {
            $paymentRecord = Payment::query()
                ->where('razorpay_order_id', $orderId)
                ->lockForUpdate()
                ->first();

            if (!$paymentRecord) {
                Log::warning('Payment record not found for Razorpay webhook.', [
                    'order_id' => $orderId,
                    'payment_id' => $paymentId,
                ]);

                return;
            }

            $subscription = UserSubscription::query()
                ->with('plan')
                ->where('id', $paymentRecord->user_subscription_id)
                ->lockForUpdate()
                ->first();

            if (!$subscription) {
                Log::warning('Subscription not found for Razorpay webhook.', [
                    'order_id' => $orderId,
                    'payment_id' => $paymentId,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Payment record
            |--------------------------------------------------------------------------
            */

            $paymentRecord->update([
                'razorpay_payment_id' => $paymentId,
                'status' => 'paid',
                'paid_at' => $paymentRecord->paid_at ?? now(),
                'gateway_response' => $paymentEntity ?: null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Subscription
            |--------------------------------------------------------------------------
            */

            if ($subscription->status === 'active') {
                return;
            }

            if (!$subscription->plan || !$subscription->plan->tests_access) {
                Log::warning('Subscription plan does not allow test access.', [
                    'subscription_id' => $subscription->id,
                    'plan_id' => $subscription->subscription_plan_id,
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Extend from existing active subscription if present
            |--------------------------------------------------------------------------
            */

            $existingActiveSubscription = UserSubscription::query()
                ->where('user_id', $subscription->user_id)
                ->where('id', '!=', $subscription->id)
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
                (int) $subscription->plan->duration_days
            );

            $subscription->update([
                'razorpay_payment_id' => $paymentId,
                'status' => 'active',
                'starts_at' => $startsAt,
                'expires_at' => $expiresAt,
            ]);
        });
    }

    private function processFailedPayment(array $payload): void
    {
        $paymentEntity = data_get(
            $payload,
            'payload.payment.entity',
            []
        );

        $paymentId = $paymentEntity['id'] ?? null;
        $orderId = $paymentEntity['order_id'] ?? null;

        if (!$orderId) {
            return;
        }

        $payment = Payment::query()
            ->where('razorpay_order_id', $orderId)
            ->first();

        if (!$payment) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Never deactivate an already successful subscription.
        |--------------------------------------------------------------------------
        */

        if ($payment->status === 'paid') {
            return;
        }

        $payment->update([
            'razorpay_payment_id' => $paymentId,
            'status' => 'failed',
            'gateway_response' => $paymentEntity ?: null,
        ]);

        UserSubscription::query()
            ->where('id', $payment->user_subscription_id)
            ->where('status', 'pending')
            ->update([
                'status' => 'failed',
            ]);
    }
}
