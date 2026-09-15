@extends('admin.layouts.app')

@section('title', 'Library Fee Plans')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <h1 class="text-2xl font-bold text-[#111827]">
            Library Fee Plans
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Manage different fee plans for each library
        </p>
    </div>

    <button
        type="button"
        onclick="openPlanModal()"
        class="rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white hover:bg-[#2167a7]">

        Add Fee Plan

    </button>

</div>


{{-- Success --}}
@if(session('success'))

    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>

@endif


{{-- Error --}}
@if(session('error'))

    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>

@endif


{{-- Validation Errors --}}
@if($errors->any())

    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

        <ul class="list-disc pl-5">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


{{-- Plans --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

    @forelse($plans as $plan)

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            {{-- Header --}}
            <div class="flex items-start justify-between">

                <div>

                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                        Library
                    </p>

                    <h3 class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $plan->library->name }}
                    </h3>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#2874b9]">

                    <i data-lucide="badge-indian-rupee" class="h-5 w-5"></i>

                </div>

            </div>


            {{-- Plan --}}
            <div class="mt-5">

                <p class="text-sm text-gray-500">
                    {{ $plan->fees->fees }}
                </p>

                <div class="mt-1 flex items-baseline gap-1">

                    <span class="text-2xl font-bold text-gray-900">
                        ₹{{ number_format($plan->amount, 2) }}
                    </span>

                    <span class="text-xs text-gray-400">
                        / {{ $plan->duration }}
                        {{ $plan->duration_type }}{{ $plan->duration > 1 ? 's' : '' }}
                    </span>

                </div>

            </div>


            {{-- Status --}}
            <div class="mt-4">

                @if($plan->status)

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">

                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                        Active

                    </span>

                @else

                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500">

                        <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>

                        Inactive

                    </span>

                @endif

            </div>


            {{-- Delete --}}
            <div class="mt-5 border-t border-gray-100 pt-4">

                <form
                    method="POST"
                    action="{{ route('admin.library-fee-plans.destroy', $plan->id) }}"
                    onsubmit="return confirm('Are you sure you want to delete this fee plan?');">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 text-sm font-medium text-red-600 hover:text-red-700">

                        <i data-lucide="trash-2" class="h-4 w-4"></i>

                        Delete Plan

                    </button>

                </form>

            </div>

        </div>

    @empty

        <div class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">

            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

                <i data-lucide="badge-indian-rupee" class="h-6 w-6"></i>

            </div>

            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                No fee plans found
            </h3>

            <p class="mt-1 text-sm text-gray-500">
                Add a fee plan for a library to get started.
            </p>

        </div>

    @endforelse

</div>


{{-- Add Fee Plan Modal --}}
<div
    id="planModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white p-6 shadow-xl">

        {{-- Header --}}
        <div class="flex items-start justify-between">

            <div>

                <h2 class="text-xl font-semibold text-gray-900">
                    Add Fee Plan
                </h2>

                <p class="mt-0.5 text-xs text-gray-500">
                    Create a library-specific fee plan
                </p>

            </div>

            <button
                type="button"
                onclick="closePlanModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600">

                <i data-lucide="x" class="h-4 w-4"></i>

            </button>

        </div>


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('admin.library-fee-plans.store') }}"
            class="mt-6 space-y-4">

            @csrf


            {{-- Library --}}
            <div class="space-y-1.5">

                <label class="block text-sm font-medium text-gray-700">
                    Library
                    <span class="text-red-500">*</span>
                </label>

                <select
                    name="library_id"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">
                        Select Library
                    </option>

                    @foreach($libraries as $library)

                        <option value="{{ $library->id }}">
                            {{ $library->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Base Fee Plan --}}
            <div class="space-y-1.5">

                <label class="block text-sm font-medium text-gray-700">
                    Base Fee Plan
                    <span class="text-red-500">*</span>
                </label>

                <select
                    name="fees_id"
                    id="baseFeePlan"
                    required
                    onchange="setDuration(this)"
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">
                        Select Base Fee Plan
                    </option>

                    @foreach($fees as $fee)
    <option
        value="{{ $fee->id }}"
        data-duration="{{ $fee->duration }}"
        data-duration-type="{{ $fee->duration_type }}"
        data-amount="{{ $fee->amount }}">

        {{ $fee->fees }}
        — ₹{{ number_format($fee->amount, 2) }}
        — {{ $fee->duration }}
        {{ ucfirst($fee->duration_type) }}

    </option>
@endforeach
                </select>

            </div>


            {{-- Duration --}}
            <div class="grid grid-cols-2 gap-3">

                <div class="space-y-1.5">

                    <label class="block text-sm font-medium text-gray-700">
                        Duration
                    </label>

                    <input
                        type="number"
                        name="duration"
                        id="duration"
                        min="1"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>


                <div class="space-y-1.5">

                    <label class="block text-sm font-medium text-gray-700">
                        Type
                    </label>

                    <select
                        name="duration_type"
                        id="durationType"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="day">
                            Day
                        </option>

                        <option value="month" selected>
                            Month
                        </option>

                        <option value="year">
                            Year
                        </option>

                    </select>

                </div>

            </div>


            {{-- Amount --}}
            <div class="space-y-1.5">

                <label class="block text-sm font-medium text-gray-700">
                    Library Amount
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="number"
                    name="amount"
                    step="0.01"
                    min="0"
                    placeholder="e.g. 900"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <p class="text-[11px] text-gray-400">
                    This amount will be used for this library.
                </p>

            </div>


            {{-- Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4">

                <button
                    type="button"
                    onclick="closePlanModal()"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="rounded-lg bg-[#2874b9] px-5 py-2 text-sm font-medium text-white hover:bg-[#2167a7]">

                    Save Plan

                </button>

            </div>

        </form>

    </div>

</div>


<script>

function openPlanModal()
{
    const modal = document.getElementById('planModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closePlanModal()
{
    const modal = document.getElementById('planModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


function setDuration(select)
{
    const option = select.options[select.selectedIndex];

    const duration = option.dataset.duration;
    const durationType = option.dataset.durationType;

    if (duration) {
        document.getElementById('duration').value = duration;
    }

    if (durationType) {
        document.getElementById('durationType').value = durationType;
    }
}


document.getElementById('planModal').addEventListener('click', function(event)
{
    if (event.target === this) {
        closePlanModal();
    }
});


document.addEventListener('DOMContentLoaded', function()
{
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});

</script>

@endsection