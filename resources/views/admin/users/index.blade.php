@extends('admin.layouts.app')

@section('title', 'User Accounts')

@section('content')

<div class="space-y-4">

{{-- Header --}}
<div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <div class="flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#edf5fd] text-[#2874b9]">
                <i data-lucide="users" class="h-4.5 w-4.5"></i>
            </div>

            <div>
                <h1 class="text-xl font-bold leading-tight text-[#111827]">
                    User Accounts
                </h1>

                <p class="mt-0.5 text-xs text-gray-500">
                    Manage users, test access & subscriptions.
                </p>
            </div>
        </div>
    </div>

    <div class="inline-flex h-9 w-fit items-center gap-2 rounded-lg border border-[#e4e8ef] bg-white px-3 shadow-sm">

        <i data-lucide="users-round" class="h-4 w-4 text-[#2874b9]"></i>

        <span class="text-xs font-medium text-gray-500">
            Total
        </span>

        <span class="text-sm font-bold text-[#111827]">
            {{ $users->total() }}
        </span>

    </div>

</div>


{{-- Messages --}}
@if(session('success'))

    <div class="flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-3 py-2.5">

        <i data-lucide="circle-check" class="h-4 w-4 shrink-0 text-green-600"></i>

        <p class="text-xs font-medium text-green-700">
            {{ session('success') }}
        </p>

    </div>

@endif


@if(session('error'))

    <div class="flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2.5">

        <i data-lucide="circle-alert" class="h-4 w-4 shrink-0 text-red-600"></i>

        <p class="text-xs font-medium text-red-700">
            {{ session('error') }}
        </p>

    </div>

@endif


@if($errors->any())

    <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2.5">

        <div class="flex items-start gap-2">

            <i data-lucide="circle-alert" class="mt-0.5 h-4 w-4 shrink-0 text-red-600"></i>

            <div>

                <p class="text-xs font-semibold text-red-700">
                    Please check the following:
                </p>

                <ul class="mt-1 list-inside list-disc text-[11px] text-red-600">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        </div>

    </div>

@endif


{{-- Filters --}}
<div class="rounded-xl border border-[#e4e8ef] bg-white p-3 shadow-sm">

    <form
        method="GET"
        action="{{ route('admin.users.index') }}"
        class="grid grid-cols-1 gap-2.5 md:grid-cols-2 xl:grid-cols-4"
    >

        {{-- Search --}}
        <div class="relative">

            <i
                data-lucide="search"
                class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-gray-400"
            ></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search name or email..."
                class="h-9 w-full rounded-lg border border-[#d0d5dd] bg-white pl-8 pr-3 text-xs text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
            >

        </div>


        {{-- Account Status --}}
        <select
            name="status"
            class="h-9 w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-3 text-xs text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

            <option value="">
                All Account Status
            </option>

            <option value="active" @selected(request('status') === 'active')>
                Active
            </option>

            <option value="disabled" @selected(request('status') === 'disabled')>
                Disabled
            </option>

        </select>


        {{-- Test Access --}}
        <select
            name="tests"
            class="h-9 w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-3 text-xs text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

            <option value="">
                All Test Access
            </option>

            <option value="enabled" @selected(request('tests') === 'enabled')>
                Tests Enabled
            </option>

            <option value="disabled" @selected(request('tests') === 'disabled')>
                Tests Disabled
            </option>

        </select>


        {{-- Filter --}}
        <div class="flex gap-2">

            <button
                type="submit"
                class="inline-flex h-9 flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-[#2874b9] px-3 text-xs font-semibold text-white transition hover:bg-[#2168ae]"
            >

                <i data-lucide="filter" class="h-3.5 w-3.5"></i>

                Filter

            </button>


            <a
                href="{{ route('admin.users.index') }}"
                class="inline-flex h-9 cursor-pointer items-center justify-center rounded-lg border border-[#d0d5dd] bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >
                Reset
            </a>

        </div>

    </form>

</div>


{{-- Table --}}
<div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">

    <div class="overflow-x-auto">

        <table class="min-w-[1180px] w-full text-left">

            <thead class="border-b border-[#e4e8ef] bg-[#f8fafc]">

                <tr>

                    <th class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        User
                    </th>

                    <th class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        Account
                    </th>

                    <th class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        Subscription
                    </th>

                    <th class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        Tests
                    </th>

                    <th class="px-4 py-2.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        Registered
                    </th>

                    <th class="px-4 py-2.5 text-right text-[10px] font-bold uppercase tracking-wider text-gray-500">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-[#eef1f5]">

                @forelse($users as $user)

                    @php

                        $subscription = $user->latestSubscription;

                        $isSubscriptionActive =
                            $subscription?->isActive() ?? false;

                        $daysLeft = 0;

                        if (
                            $isSubscriptionActive &&
                            $subscription?->expires_at
                        ) {
                            $daysLeft = max(
                                0,
                                (int) now()->diffInDays(
                                    $subscription->expires_at,
                                    false
                                )
                            );
                        }

                        $freeSubscription = $user->subscriptions
                            ->filter(function ($free) {
                                return
                                    (float) $free->amount === 0.0 &&
                                    $free->status === 'active' &&
                                    $free->expires_at &&
                                    $free->expires_at->isFuture();
                            })
                            ->sortByDesc('expires_at')
                            ->first();

                        $hasActiveFreeSubscription =
                            (bool) $freeSubscription;

                    @endphp


                    <tr class="transition hover:bg-[#fafcff]">


                        {{-- User --}}
                        <td class="px-4 py-3">

                            <div class="flex items-center gap-2.5">

                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#edf5fd] text-xs font-bold text-[#2874b9]">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="max-w-[230px] truncate text-xs font-semibold text-[#111827]">
                                        {{ $user->name }}
                                    </p>

                                    <p class="mt-0.5 max-w-[230px] truncate text-[10px] text-gray-400">
                                        {{ $user->email }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Account --}}
                        <td class="px-4 py-3">

                            @if($user->is_active)

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2 py-1 text-[10px] font-semibold text-green-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                    Active

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2 py-1 text-[10px] font-semibold text-red-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                    Disabled

                                </span>

                            @endif

                        </td>


                        {{-- Subscription --}}
                        <td class="px-4 py-3">

                            @if($subscription)

                                <div>

                                    <div class="flex items-center gap-1.5">

                                        <span class="max-w-[150px] truncate text-xs font-semibold text-[#111827]">
                                            {{ $subscription->plan?->name ?? 'Plan' }}
                                        </span>


                                        @if((float) $subscription->amount === 0.0)

                                            <span class="rounded-full bg-purple-50 px-1.5 py-0.5 text-[9px] font-bold text-purple-700">
                                                FREE
                                            </span>

                                        @else

                                            <span class="text-[10px] font-medium text-gray-400">
                                                ₹{{ number_format((float) $subscription->amount, 2) }}
                                            </span>

                                        @endif

                                    </div>


                                    @if($isSubscriptionActive)

                                        <p class="mt-0.5 text-[10px] text-green-600">

                                            Active

                                            @if($daysLeft > 0)
                                                · {{ $daysLeft }}d left
                                            @endif

                                        </p>

                                    @else

                                        <p class="mt-0.5 text-[10px] text-red-500">
                                            Expired / Inactive
                                        </p>

                                    @endif

                                </div>

                            @else

                                <span class="text-xs text-gray-400">
                                    No subscription
                                </span>

                            @endif

                        </td>


                        {{-- Tests --}}
                        <td class="px-4 py-3">

                            @if($user->tests_enabled)

                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-1 text-[10px] font-semibold text-[#2168ae]">

                                    <i data-lucide="check" class="h-3 w-3"></i>

                                    Enabled

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-500">

                                    <i data-lucide="x" class="h-3 w-3"></i>

                                    Disabled

                                </span>

                            @endif

                        </td>


                        {{-- Registered --}}
                        <td class="px-4 py-3">

                            <p class="text-xs font-medium text-gray-600">
                                {{ $user->created_at?->format('d M Y') }}
                            </p>

                            <p class="mt-0.5 text-[10px] text-gray-400">
                                {{ $user->created_at?->format('h:i A') }}
                            </p>

                        </td>


                        {{-- Actions --}}
                        <td class="px-4 py-3">

                            <div class="flex items-center justify-end gap-1.5">


                                {{-- Free Plan --}}
                                @if($hasActiveFreeSubscription)

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.revoke-free-subscription', $user) }}"
                                        class="inline"
                                        onsubmit="return openFreeStopConfirm(this, @js($user->name))"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="Stop Free Subscription"
                                            class="inline-flex h-7 cursor-pointer items-center gap-1 rounded-md border border-orange-200 bg-orange-50 px-2 text-[9px] font-semibold text-orange-600 transition hover:bg-orange-100"
                                        >

                                            <i data-lucide="ban" class="h-3 w-3"></i>

                                            Stop

                                        </button>

                                    </form>

                                @elseif($plans->count())

                                    <button
                                        type="button"
                                        title="Give Free Subscription"
                                        onclick="openFreeSubscriptionModal(
                                            {{ $user->id }},
                                            @js($user->name)
                                        )"
                                        class="inline-flex h-7 cursor-pointer items-center gap-1 rounded-md border border-purple-200 bg-purple-50 px-2 text-[9px] font-semibold text-purple-700 transition hover:bg-purple-100"
                                    >

                                        <i data-lucide="gift" class="h-3 w-3"></i>

                                        Free

                                    </button>

                                @endif


                                {{-- Tests --}}
                                <form
                                    method="POST"
                                    action="{{ route('admin.users.toggle-tests', $user) }}"
                                    class="inline"
                                    onsubmit="return openTestsConfirm(
                                        this,
                                        @js($user->name),
                                        {{ $user->tests_enabled ? 'true' : 'false' }}
                                    )"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        title="Change Test Access"
                                        class="inline-flex h-7 cursor-pointer items-center gap-1 rounded-md border border-blue-200 bg-blue-50 px-2 text-[9px] font-semibold text-[#2168ae] transition hover:bg-blue-100"
                                    >

                                        <i data-lucide="test-tube" class="h-3 w-3"></i>

                                        {{ $user->tests_enabled ? 'ON' : 'OFF' }}

                                    </button>

                                </form>


                                {{-- Account --}}
                                @if((int) $user->id !== (int) auth()->id())

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.toggle-status', $user) }}"
                                        class="inline"
                                        onsubmit="return openStatusConfirm(
                                            this,
                                            @js($user->name),
                                            {{ $user->is_active ? 'true' : 'false' }}
                                        )"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="{{ $user->is_active ? 'Disable Account' : 'Activate Account' }}"
                                            class="inline-flex h-7 cursor-pointer items-center gap-1 rounded-md border px-2 text-[9px] font-semibold transition
                                            {{ $user->is_active
                                                ? 'border-red-200 bg-red-50 text-red-600 hover:bg-red-100'
                                                : 'border-green-200 bg-green-50 text-green-600 hover:bg-green-100'
                                            }}"
                                        >

                                            @if($user->is_active)

                                                <i data-lucide="user-x" class="h-3 w-3"></i>

                                                Disable

                                            @else

                                                <i data-lucide="user-check" class="h-3 w-3"></i>

                                                Activate

                                            @endif

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td colspan="6" class="px-4 py-14 text-center">

                            <div class="flex flex-col items-center">

                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">

                                    <i data-lucide="users-round" class="h-6 w-6"></i>

                                </div>

                                <p class="mt-3 text-sm font-semibold text-gray-700">
                                    No users found
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Try changing your search or filters.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    @if($users->hasPages())

        <div class="border-t border-[#e4e8ef] px-4 py-3">

            {{ $users->links() }}

        </div>

    @endif

</div>

</div>

{{-- ========================================================= --}}
{{-- GIVE FREE PLAN MODAL --}}
{{-- ========================================================= --}}

<div
    id="freeSubscriptionModal"
    class="fixed inset-0 z-[1000] hidden items-center justify-center bg-black/40 px-4"
>

<div class="w-full max-w-sm overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-2xl">

    <div class="flex items-center justify-between border-b border-[#e4e8ef] px-4 py-3">

        <div class="flex items-center gap-2.5">

            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                <i data-lucide="gift" class="h-4 w-4"></i>
            </div>

            <div>

                <h2 class="text-sm font-semibold text-[#111827]">
                    Give Free Plan
                </h2>

                <p class="text-[10px] text-gray-400">
                    Give test access without payment.
                </p>

            </div>

        </div>


        <button
            type="button"
            onclick="closeFreeSubscriptionModal()"
            class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-md text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
        >
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>

    </div>


    <form
        id="freeSubscriptionForm"
        method="POST"
        action=""
    >

        @csrf

        <div class="space-y-4 p-4">

            <div class="rounded-lg border border-[#e4e8ef] bg-[#f8fafc] px-3 py-2.5">

                <p class="text-[10px] font-medium text-gray-400">
                    User
                </p>

                <p
                    id="freeSubscriptionUserName"
                    class="mt-0.5 text-xs font-semibold text-[#111827]"
                ></p>

            </div>


            <div>

                <label
                    for="free_plan_id"
                    class="mb-1.5 block text-xs font-semibold text-gray-700"
                >
                    Select Plan
                </label>

                <select
                    id="free_plan_id"
                    name="plan_id"
                    required
                    onchange="updateFreePlanPreview()"
                    class="h-10 w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-3 text-xs text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                >

                    <option value="">
                        Select subscription plan
                    </option>

                    @foreach($plans as $plan)

                        <option
                            value="{{ $plan->id }}"
                            data-name="{{ $plan->name }}"
                            data-days="{{ $plan->duration_days }}"
                        >
                            {{ $plan->name }} — {{ $plan->duration_days }} days
                        </option>

                    @endforeach

                </select>

            </div>


            <div
                id="freePlanPreview"
                class="hidden rounded-lg border border-purple-200 bg-purple-50 px-3 py-2.5"
            >

                <div class="flex items-start gap-2">

                    <i data-lucide="circle-check" class="mt-0.5 h-4 w-4 shrink-0 text-purple-600"></i>

                    <div>

                        <p class="text-xs font-semibold text-purple-800">
                            Free Access
                        </p>

                        <p
                            id="freePlanPreviewText"
                            class="mt-0.5 text-[10px] leading-4 text-purple-700"
                        ></p>

                    </div>

                </div>

            </div>

        </div>


        <div class="flex items-center justify-end gap-2 border-t border-[#e4e8ef] px-4 py-3">

            <button
                type="button"
                onclick="closeFreeSubscriptionModal()"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >
                Cancel
            </button>

            <button
                type="submit"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >

                <i data-lucide="gift" class="h-3.5 w-3.5"></i>

                Give Free

            </button>

        </div>

    </form>

</div>


</div>

{{-- ========================================================= --}}
{{-- STOP FREE MODAL --}}
{{-- ========================================================= --}}

<div
    id="freeStopConfirmModal"
    class="fixed inset-0 z-[1100] hidden items-center justify-center bg-black/40 px-4"
>


<div class="w-full max-w-sm overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-2xl">

    <div class="p-4">

        <div class="flex items-start gap-3">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                <i data-lucide="ban" class="h-4 w-4"></i>
            </div>

            <div>

                <h2 class="text-sm font-semibold text-[#111827]">
                    Stop Free Subscription?
                </h2>

                <p class="mt-1 text-xs leading-5 text-gray-500">

                    Stop free access for

                    <span
                        id="freeStopUserName"
                        class="font-semibold text-gray-700"
                    ></span>?

                </p>

                <p class="mt-1.5 text-[10px] leading-4 text-gray-400">
                    Any paid subscription will remain unaffected.
                </p>

            </div>

        </div>


        <div class="mt-5 flex items-center justify-end gap-2">

            <button
                type="button"
                onclick="closeFreeStopConfirm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >
                Cancel
            </button>


            <button
                type="button"
                onclick="submitFreeStopForm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >

                <i data-lucide="ban" class="h-3.5 w-3.5"></i>

                Stop Free

            </button>

        </div>

    </div>

</div>


</div>

{{-- ========================================================= --}}
{{-- ACCOUNT STATUS MODAL --}}
{{-- ========================================================= --}}

<div
    id="statusConfirmModal"
    class="fixed inset-0 z-[1200] hidden items-center justify-center bg-black/40 px-4"
>


<div class="w-full max-w-sm overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-2xl">

    <div class="p-4">

        <div class="flex items-start gap-3">

            <div
                id="statusConfirmIcon"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600"
            >

                <i data-lucide="user-x" class="h-4 w-4"></i>

            </div>


            <div>

                <h2
                    id="statusConfirmTitle"
                    class="text-sm font-semibold text-[#111827]"
                >
                    Disable Account?
                </h2>

                <p
                    id="statusConfirmText"
                    class="mt-1 text-xs leading-5 text-gray-500"
                >
                    Are you sure?
                </p>

            </div>

        </div>


        <div class="mt-5 flex items-center justify-end gap-2">

            <button
                type="button"
                onclick="closeStatusConfirm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >
                Cancel
            </button>


            <button
                id="statusConfirmButton"
                type="button"
                onclick="submitStatusForm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-red-600 px-3.5 text-xs font-semibold text-white transition hover:bg-red-700"
            >

                <i data-lucide="user-x" class="h-3.5 w-3.5"></i>

                Disable

            </button>

        </div>

    </div>

</div>


</div>

{{-- ========================================================= --}}
{{-- TEST ACCESS MODAL --}}
{{-- ========================================================= --}}

<div
    id="testsConfirmModal"
    class="fixed inset-0 z-[1200] hidden items-center justify-center bg-black/40 px-4"
>


<div class="w-full max-w-sm overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-2xl">

    <div class="p-4">

        <div class="flex items-start gap-3">

            <div
                id="testsConfirmIcon"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-[#2874b9]"
            >

                <i data-lucide="test-tube" class="h-4 w-4"></i>

            </div>


            <div>

                <h2
                    id="testsConfirmTitle"
                    class="text-sm font-semibold text-[#111827]"
                >
                    Change Test Access?
                </h2>

                <p
                    id="testsConfirmText"
                    class="mt-1 text-xs leading-5 text-gray-500"
                >
                    Are you sure?
                </p>

            </div>

        </div>


        <div class="mt-5 flex items-center justify-end gap-2">

            <button
                type="button"
                onclick="closeTestsConfirm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-xs font-medium text-gray-600 transition hover:bg-gray-50"
            >
                Cancel
            </button>


            <button
                id="testsConfirmButton"
                type="button"
                onclick="submitTestsForm()"
                class="inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-[#2874b9] px-3.5 text-xs font-semibold text-white transition hover:bg-[#2168ae]"
            >

                <i data-lucide="test-tube" class="h-3.5 w-3.5"></i>

                Change Access

            </button>

        </div>

    </div>

</div>


</div>

<script>

    let pendingFreeStopForm = null;
    let pendingStatusForm = null;
    let pendingTestsForm = null;


    function showModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    }


    function hideModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    /*
     * FREE SUBSCRIPTION
     */

    function openFreeSubscriptionModal(userId, userName) {

        const modal =
            document.getElementById('freeSubscriptionModal');

        const form =
            document.getElementById('freeSubscriptionForm');

        const name =
            document.getElementById('freeSubscriptionUserName');

        const select =
            document.getElementById('free_plan_id');


        if (!modal || !form || !name || !select) {
            return;
        }


        form.action =
            "{{ url('/admin/users') }}/" +
            userId +
            "/grant-free-subscription";


        name.textContent = userName;

        select.value = '';


        updateFreePlanPreview();

        showModal(modal);

    }


    function closeFreeSubscriptionModal() {

        hideModal(
            document.getElementById('freeSubscriptionModal')
        );

    }


    function updateFreePlanPreview() {

        const select =
            document.getElementById('free_plan_id');

        const preview =
            document.getElementById('freePlanPreview');

        const previewText =
            document.getElementById('freePlanPreviewText');


        if (!select || !preview || !previewText) {
            return;
        }


        const option =
            select.options[select.selectedIndex];


        if (!select.value) {

            preview.classList.add('hidden');

            previewText.textContent = '';

            return;

        }


        const planName =
            option.dataset.name || 'Selected plan';

        const days =
            option.dataset.days || '0';


        previewText.textContent =
            planName +
            ' will be given free for ' +
            days +
            ' days.';


        preview.classList.remove('hidden');


        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    }


    /*
     * STOP FREE
     */

    function openFreeStopConfirm(form, userName) {

        pendingFreeStopForm = form;


        const modal =
            document.getElementById('freeStopConfirmModal');

        const name =
            document.getElementById('freeStopUserName');


        if (!modal || !name) {
            return true;
        }


        name.textContent = userName;

        showModal(modal);


        return false;

    }


    function closeFreeStopConfirm() {

        hideModal(
            document.getElementById('freeStopConfirmModal')
        );

        pendingFreeStopForm = null;

    }


    function submitFreeStopForm() {

        if (!pendingFreeStopForm) {

            closeFreeStopConfirm();

            return;

        }


        const form =
            pendingFreeStopForm;

        pendingFreeStopForm = null;

        form.submit();

    }


    /*
     * ACCOUNT STATUS
     */

    function openStatusConfirm(
        form,
        userName,
        isActive
    ) {

        pendingStatusForm = form;


        const modal =
            document.getElementById('statusConfirmModal');

        const title =
            document.getElementById('statusConfirmTitle');

        const text =
            document.getElementById('statusConfirmText');

        const button =
            document.getElementById('statusConfirmButton');

        const icon =
            document.getElementById('statusConfirmIcon');


        if (!modal) {
            return true;
        }


        if (isActive) {

            title.textContent =
                'Disable Account?';

            text.textContent =
                'Are you sure you want to disable ' +
                userName +
                '\'s account?';

            button.className =
                'inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-red-600 px-3.5 text-xs font-semibold text-white transition hover:bg-red-700';

            button.innerHTML =
                '<i data-lucide="user-x" class="h-3.5 w-3.5"></i>' +
                '<span>Disable</span>';

            icon.className =
                'flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600';

        } else {

            title.textContent =
                'Activate Account?';

            text.textContent =
                'Are you sure you want to activate ' +
                userName +
                '\'s account?';

            button.className =
                'inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-green-600 px-3.5 text-xs font-semibold text-white transition hover:bg-green-700';

            button.innerHTML =
                '<i data-lucide="user-check" class="h-3.5 w-3.5"></i>' +
                '<span>Activate</span>';

            icon.className =
                'flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600';

        }


        showModal(modal);

        return false;

    }


    function closeStatusConfirm() {

        hideModal(
            document.getElementById('statusConfirmModal')
        );

        pendingStatusForm = null;

    }


    function submitStatusForm() {

        if (!pendingStatusForm) {

            closeStatusConfirm();

            return;

        }


        const form =
            pendingStatusForm;

        pendingStatusForm = null;

        form.submit();

    }


    /*
     * TEST ACCESS
     */

    function openTestsConfirm(
        form,
        userName,
        testsEnabled
    ) {

        pendingTestsForm = form;


        const modal =
            document.getElementById('testsConfirmModal');

        const title =
            document.getElementById('testsConfirmTitle');

        const text =
            document.getElementById('testsConfirmText');

        const button =
            document.getElementById('testsConfirmButton');


        if (!modal) {
            return true;
        }


        if (testsEnabled) {

            title.textContent =
                'Disable Test Access?';

            text.textContent =
                'Are you sure you want to disable tests for ' +
                userName +
                '?';

            button.innerHTML =
                '<i data-lucide="test-tube" class="h-3.5 w-3.5"></i>' +
                '<span>Disable Tests</span>';

            button.className =
                'inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-red-600 px-3.5 text-xs font-semibold text-white transition hover:bg-red-700';

        } else {

            title.textContent =
                'Enable Test Access?';

            text.textContent =
                'Are you sure you want to enable tests for ' +
                userName +
                '?';

            button.innerHTML =
                '<i data-lucide="test-tube" class="h-3.5 w-3.5"></i>' +
                '<span>Enable Tests</span>';

            button.className =
                'inline-flex h-8 cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-[#2874b9] px-3.5 text-xs font-semibold text-white transition hover:bg-[#2168ae]';

        }


        showModal(modal);

        return false;

    }


    function closeTestsConfirm() {

        hideModal(
            document.getElementById('testsConfirmModal')
        );

        pendingTestsForm = null;

    }


    function submitTestsForm() {

        if (!pendingTestsForm) {

            closeTestsConfirm();

            return;

        }


        const form =
            pendingTestsForm;

        pendingTestsForm = null;

        form.submit();

    }


    /*
     * ESC
     */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }

            closeFreeSubscriptionModal();
            closeFreeStopConfirm();
            closeStatusConfirm();
            closeTestsConfirm();

        }
    );


    /*
     * LUCIDE
     */

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        }
    );

</script>

@endsection
