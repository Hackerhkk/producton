<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->with([
                'latestSubscription.plan',
                'subscriptions' => function ($query) {
                    $query->where('amount', 0)
                        ->where('status', 'active')
                        ->whereNotNull('expires_at')
                        ->where('expires_at', '>', now())
                        ->latest('expires_at');
                },
            ])
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            }

            if ($request->status === 'disabled') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('tests')) {
            if ($request->tests === 'enabled') {
                $query->where('tests_enabled', true);
            }

            if ($request->tests === 'disabled') {
                $query->where('tests_enabled', false);
            }
        }

        $users = $query
            ->paginate(15)
            ->withQueryString();

        $plans = SubscriptionPlan::query()
            ->where('is_active', true)
            ->where('tests_access', true)
            ->orderBy('price')
            ->get();

        return view(
            'admin.users.index',
            compact('users', 'plans')
        );
    }

    public function toggleStatus(User $user)
    {
        if ((int) $user->id === (int) auth()->id()) {
            return back()->with(
                'error',
                'You cannot disable your own account.'
            );
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active
            ? 'User account activated successfully.'
            : 'User account disabled successfully.';

        return back()->with('success', $message);
    }

    public function toggleTests(User $user)
    {
        $user->update([
            'tests_enabled' => !$user->tests_enabled,
        ]);

        $message = $user->tests_enabled
            ? 'Tests access enabled successfully.'
            : 'Tests access disabled successfully.';

        return back()->with('success', $message);
    }

    public function grantFreeSubscription(
        Request $request,
        User $user
    ) {
        $data = $request->validate([
            'plan_id' => [
                'required',
                'integer',
                'exists:subscription_plans,id',
            ],
        ]);

        $plan = SubscriptionPlan::query()
            ->whereKey($data['plan_id'])
            ->where('is_active', true)
            ->where('tests_access', true)
            ->first();

        if (!$plan) {
            return back()->with(
                'error',
                'Selected subscription plan is not available.'
            );
        }

        $activeSubscription = UserSubscription::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();

        $startsAt = $activeSubscription
            ? $activeSubscription->expires_at->copy()
            : now();

        $expiresAt = $startsAt->copy()->addDays(
            (int) $plan->duration_days
        );

        UserSubscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'razorpay_order_id' => null,
            'razorpay_payment_id' => null,
            'amount' => 0,
            'status' => 'active',
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
        ]);

        if (!$user->tests_enabled) {
            $user->update([
                'tests_enabled' => true,
            ]);
        }

        return back()->with(
            'success',
            "Free subscription granted to {$user->name} until {$expiresAt->format('d M Y, h:i A')}."
        );
    }

    public function revokeFreeSubscription(User $user)
    {
        $freeSubscription = $user->subscriptions()
            ->where('amount', 0)
            ->where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();

        if (!$freeSubscription) {
            return back()->with(
                'error',
                'No active free subscription found for this user.'
            );
        }

        $freeSubscription->update([
            'status' => 'cancelled',
            'expires_at' => now(),
        ]);

        return back()->with(
            'success',
            'Free subscription stopped successfully.'
        );
    }
}

