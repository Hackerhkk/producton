@extends('admin.layouts.app')

@section('title', 'Subscription Plans')

@section('content')

<div class="space-y-5">

{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-[#111827]">
            Subscription Plans
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Manage plans and test access subscriptions.
        </p>
    </div>

    <button
        type="button"
        onclick="openAddPlanModal()"
        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21639e]"
    >
        <i data-lucide="plus" class="h-4 w-4"></i>
        Add Plan
    </button>
</div>

{{-- Alerts --}}
@if(session('success'))
    <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        <i data-lucide="circle-check" class="h-5 w-5 shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <i data-lucide="circle-alert" class="h-5 w-5 shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Plans Table --}}
<div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">

    {{-- Desktop --}}
    <div class="hidden overflow-x-auto md:block">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-[#e4e8ef] bg-gray-50">
                <tr>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Plan
                    </th>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Price
                    </th>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Duration
                    </th>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Test Access
                    </th>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Subscribers
                    </th>
                    <th class="px-5 py-3.5 font-semibold text-[#374151]">
                        Status
                    </th>
                    <th class="px-5 py-3.5 text-right font-semibold text-[#374151]">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#e4e8ef]">

                @forelse($plans as $plan)

                    <tr class="transition hover:bg-gray-50/70">

                        {{-- Plan --}}
                        <td class="px-5 py-4">
                            <div class="font-semibold text-[#1f2937]">
                                {{ $plan->name }}
                            </div>
                        </td>

                        {{-- Price --}}
                        <td class="px-5 py-4">
                            <span class="font-semibold text-[#1f2937]">
                                ₹{{ number_format((float) $plan->price, 2) }}
                            </span>
                        </td>

                        {{-- Duration --}}
                        <td class="px-5 py-4 text-gray-600">
                            {{ $plan->duration_days }} days
                        </td>

                        {{-- Test Access --}}
                        <td class="px-5 py-4">
                            @if($plan->tests_access)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                    <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                    All Tests
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                    <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                    No Access
                                </span>
                            @endif
                        </td>

                        {{-- Subscribers --}}
                        <td class="px-5 py-4 text-gray-600">
                            {{ $plan->subscriptions_count }}
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            @if($plan->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">

                                <button
                                    type="button"
                                    onclick='openEditPlanModal(@json($plan))'
                                    class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50"
                                >
                                    <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                    Edit
                                </button>

                                <form
                                    action="{{ route('admin.subscription-plans.toggle-status', $plan) }}"
                                    method="POST"
                                    onsubmit="return openStatusConfirm(this, '{{ $plan->is_active ? 'Deactivate Plan' : 'Activate Plan' }}', '{{ $plan->is_active ? 'Are you sure you want to deactivate this plan?' : 'Are you sure you want to activate this plan?' }}')"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $plan->is_active ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
                                    >
                                        <i data-lucide="{{ $plan->is_active ? 'power-off' : 'power' }}" class="h-3.5 w-3.5"></i>
                                        {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                                    <i data-lucide="credit-card" class="h-6 w-6 text-gray-400"></i>
                                </div>

                                <h3 class="text-sm font-semibold text-gray-700">
                                    No subscription plans
                                </h3>

                                <p class="mt-1 text-xs text-gray-500">
                                    Create your first subscription plan.
                                </p>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Mobile --}}
    <div class="divide-y divide-[#e4e8ef] md:hidden">

        @forelse($plans as $plan)

            <div class="p-4">

                <div class="flex items-start justify-between gap-3">

                    <div>
                        <h3 class="font-semibold text-[#1f2937]">
                            {{ $plan->name }}
                        </h3>

                        <div class="mt-1 text-lg font-bold text-[#2874b9]">
                            ₹{{ number_format((float) $plan->price, 2) }}
                        </div>
                    </div>

                    @if($plan->is_active)
                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            Inactive
                        </span>
                    @endif

                </div>

                <div class="mt-4 grid grid-cols-2 gap-3">

                    <div class="rounded-lg bg-gray-50 p-3">
                        <div class="text-xs text-gray-500">
                            Duration
                        </div>
                        <div class="mt-1 text-sm font-semibold text-gray-700">
                            {{ $plan->duration_days }} days
                        </div>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-3">
                        <div class="text-xs text-gray-500">
                            Subscribers
                        </div>
                        <div class="mt-1 text-sm font-semibold text-gray-700">
                            {{ $plan->subscriptions_count }}
                        </div>
                    </div>

                </div>

                <div class="mt-3">
                    @if($plan->tests_access)
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                            <i data-lucide="check" class="h-3.5 w-3.5"></i>
                            All Tests Access
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                            <i data-lucide="x" class="h-3.5 w-3.5"></i>
                            No Test Access
                        </span>
                    @endif
                </div>

                <div class="mt-4 flex gap-2">

                    <button
                        type="button"
                        onclick='openEditPlanModal(@json($plan))'
                        class="inline-flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50"
                    >
                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                        Edit
                    </button>

                    <form
                        action="{{ route('admin.subscription-plans.toggle-status', $plan) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return openStatusConfirm(this, '{{ $plan->is_active ? 'Deactivate Plan' : 'Activate Plan' }}', '{{ $plan->is_active ? 'Are you sure you want to deactivate this plan?' : 'Are you sure you want to activate this plan?' }}')"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg px-3 py-2 text-xs font-semibold transition {{ $plan->is_active ? 'bg-red-50 text-red-700 hover:bg-red-100' : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
                        >
                            <i data-lucide="{{ $plan->is_active ? 'power-off' : 'power' }}" class="h-3.5 w-3.5"></i>
                            {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="px-5 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                        <i data-lucide="credit-card" class="h-6 w-6 text-gray-400"></i>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-700">
                        No subscription plans
                    </h3>

                    <p class="mt-1 text-xs text-gray-500">
                        Create your first subscription plan.
                    </p>
                </div>
            </div>

        @endforelse

    </div>

</div>

</div>

{{-- Add Plan Modal --}}

<div
    id="addPlanModal"
    class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 px-4 py-6"
>
    <div class="flex min-h-full items-center justify-center">

    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">

        <div class="flex items-center justify-between border-b border-[#e4e8ef] px-5 py-4">
            <div>
                <h2 class="text-lg font-bold text-[#1f2937]">
                    Add Subscription Plan
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Create a plan for all test access.
                </p>
            </div>

            <button
                type="button"
                onclick="closeAddPlanModal()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form
            action="{{ route('admin.subscription-plans.store') }}"
            method="POST"
            class="p-5"
        >
            @csrf

            <div class="space-y-4">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Plan Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        placeholder="30 Days Test Access"
                        class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >
                </div>

                <div class="grid grid-cols-2 gap-3">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Price (₹)
                        </label>

                        <input
                            type="number"
                            name="price"
                            min="0"
                            step="0.01"
                            required
                            placeholder="49"
                            class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Duration
                        </label>

                        <input
                            type="number"
                            name="duration_days"
                            min="1"
                            required
                            placeholder="30"
                            class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                </div>

                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-[#e4e8ef] bg-gray-50 px-3 py-3">
                    <input
                        type="checkbox"
                        name="tests_access"
                        value="1"
                        checked
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <div>
                        <div class="text-sm font-semibold text-gray-700">
                            All Tests Access
                        </div>
                        <div class="text-xs text-gray-500">
                            Allow access to all available tests.
                        </div>
                    </div>
                </label>

                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-[#e4e8ef] bg-gray-50 px-3 py-3">
                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        checked
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <div>
                        <div class="text-sm font-semibold text-gray-700">
                            Active Plan
                        </div>
                        <div class="text-xs text-gray-500">
                            Users can purchase this plan.
                        </div>
                    </div>
                </label>

            </div>

            <div class="mt-5 flex justify-end gap-2 border-t border-[#e4e8ef] pt-4">

                <button
                    type="button"
                    onclick="closeAddPlanModal()"
                    class="cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639e]"
                >
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Create Plan
                </button>

            </div>

        </form>

    </div>

</div>

</div>

{{-- Edit Plan Modal --}}

<div
    id="editPlanModal"
    class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 px-4 py-6"
>
    <div class="flex min-h-full items-center justify-center">

    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">

        <div class="flex items-center justify-between border-b border-[#e4e8ef] px-5 py-4">
            <div>
                <h2 class="text-lg font-bold text-[#1f2937]">
                    Edit Subscription Plan
                </h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Update plan details.
                </p>
            </div>

            <button
                type="button"
                onclick="closeEditPlanModal()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form
            id="editPlanForm"
            method="POST"
            class="p-5"
        >
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Plan Name
                    </label>

                    <input
                        type="text"
                        id="edit_name"
                        name="name"
                        required
                        class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >
                </div>

                <div class="grid grid-cols-2 gap-3">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Price (₹)
                        </label>

                        <input
                            type="number"
                            id="edit_price"
                            name="price"
                            min="0"
                            step="0.01"
                            required
                            class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Duration
                        </label>

                        <input
                            type="number"
                            id="edit_duration_days"
                            name="duration_days"
                            min="1"
                            required
                            class="w-full rounded-lg border border-[#d0d5dd] px-3 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                </div>

                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-[#e4e8ef] bg-gray-50 px-3 py-3">
                    <input
                        type="checkbox"
                        id="edit_tests_access"
                        name="tests_access"
                        value="1"
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <div>
                        <div class="text-sm font-semibold text-gray-700">
                            All Tests Access
                        </div>
                        <div class="text-xs text-gray-500">
                            Allow access to all available tests.
                        </div>
                    </div>
                </label>

                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-[#e4e8ef] bg-gray-50 px-3 py-3">
                    <input
                        type="checkbox"
                        id="edit_is_active"
                        name="is_active"
                        value="1"
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <div>
                        <div class="text-sm font-semibold text-gray-700">
                            Active Plan
                        </div>
                        <div class="text-xs text-gray-500">
                            Users can purchase this plan.
                        </div>
                    </div>
                </label>

            </div>

            <div class="mt-5 flex justify-end gap-2 border-t border-[#e4e8ef] pt-4">

                <button
                    type="button"
                    onclick="closeEditPlanModal()"
                    class="cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639e]"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Update Plan
                </button>

            </div>

        </form>

    </div>

</div>

</div>

{{-- Status Confirmation Modal --}}

<div
    id="statusConfirmModal"
    class="fixed inset-0 z-[60] hidden overflow-y-auto bg-black/40 px-4 py-6"
>
    <div class="flex min-h-full items-center justify-center">

    <div class="w-full max-w-sm rounded-xl bg-white shadow-xl">

        <div class="p-5">

            <div class="flex items-start gap-3">

                <div
                    id="statusConfirmIcon"
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600"
                >
                    <i data-lucide="power-off" class="h-5 w-5"></i>
                </div>

                <div>
                    <h3
                        id="statusConfirmTitle"
                        class="text-base font-bold text-[#1f2937]"
                    >
                        Deactivate Plan
                    </h3>

                    <p
                        id="statusConfirmMessage"
                        class="mt-1 text-sm leading-5 text-gray-500"
                    >
                        Are you sure you want to deactivate this plan?
                    </p>
                </div>

            </div>

            <div class="mt-5 flex justify-end gap-2">

                <button
                    type="button"
                    onclick="closeStatusConfirm()"
                    class="cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="statusConfirmButton"
                    onclick="submitStatusForm()"
                    class="cursor-pointer rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                >
                    Confirm
                </button>

            </div>

        </div>

    </div>

</div>

</div>

<script>
    let pendingStatusForm = null;

    function openAddPlanModal() {
        document.getElementById('addPlanModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddPlanModal() {
        document.getElementById('addPlanModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditPlanModal(plan) {
        document.getElementById('edit_name').value = plan.name ?? '';
        document.getElementById('edit_price').value = plan.price ?? '';
        document.getElementById('edit_duration_days').value = plan.duration_days ?? '';
        document.getElementById('edit_tests_access').checked = !!plan.tests_access;
        document.getElementById('edit_is_active').checked = !!plan.is_active;

        document.getElementById('editPlanForm').action =
            "{{ url('/admin/subscription-plans') }}/" + plan.id;

        document.getElementById('editPlanModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditPlanModal() {
        document.getElementById('editPlanModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openStatusConfirm(form, title, message) {
        pendingStatusForm = form;

        document.getElementById('statusConfirmTitle').textContent = title;
        document.getElementById('statusConfirmMessage').textContent = message;

        const isDeactivate = title.toLowerCase().includes('deactivate');

        const iconBox = document.getElementById('statusConfirmIcon');
        const button = document.getElementById('statusConfirmButton');

        iconBox.innerHTML = isDeactivate
            ? '<i data-lucide="power-off" class="h-5 w-5"></i>'
            : '<i data-lucide="power" class="h-5 w-5"></i>';

        iconBox.className = isDeactivate
            ? 'flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600'
            : 'flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-600';

        button.className = isDeactivate
            ? 'cursor-pointer rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700'
            : 'cursor-pointer rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700';

        document.getElementById('statusConfirmModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        if (window.lucide) {
            lucide.createIcons();
        }

        return false;
    }

    function closeStatusConfirm() {
        pendingStatusForm = null;

        document.getElementById('statusConfirmModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function submitStatusForm() {
        if (pendingStatusForm) {
            const form = pendingStatusForm;
            pendingStatusForm = null;
            form.submit();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddPlanModal();
            closeEditPlanModal();
            closeStatusConfirm();
        }
    });

    document.getElementById('addPlanModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeAddPlanModal();
        }
    });

    document.getElementById('editPlanModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeEditPlanModal();
        }
    });

    document.getElementById('statusConfirmModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeStatusConfirm();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>

@endsection
