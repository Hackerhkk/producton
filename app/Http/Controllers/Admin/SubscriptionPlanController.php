<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::withCount('subscriptions')
            ->latest()
            ->get();

        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'tests_access' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['tests_access'] = $request->boolean('tests_access');
        $data['is_active'] = $request->boolean('is_active');

        SubscriptionPlan::create($data);

        return back()->with(
            'success',
            'Subscription plan created successfully.'
        );
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'tests_access' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['tests_access'] = $request->boolean('tests_access');
        $data['is_active'] = $request->boolean('is_active');

        $subscriptionPlan->update($data);

        return back()->with(
            'success',
            'Subscription plan updated successfully.'
        );
    }

    public function toggleStatus(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->update([
            'is_active' => !$subscriptionPlan->is_active,
        ]);

        $message = $subscriptionPlan->is_active
            ? 'Subscription plan activated successfully.'
            : 'Subscription plan deactivated successfully.';

        return back()->with('success', $message);
    }
}
