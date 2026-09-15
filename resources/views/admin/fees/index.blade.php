@extends('admin.layouts.app')

@section('title', 'Fees')

@section('content')

<div>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-6 flex items-center justify-between">

        <div>

            <h1 class="text-2xl font-bold text-[#111827]">
                Fees
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage monthly fee plans
            </p>

        </div>


        <button
            type="button"
            onclick="openFeeModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2167a7]">

            <i data-lucide="plus" class="h-4 w-4"></i>

            Add Fees

        </button>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="mb-5 flex items-center gap-2 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

            <i data-lucide="circle-check" class="h-4 w-4"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('error'))

        <div class="mb-5 flex items-center gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <i data-lucide="circle-alert" class="h-4 w-4"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <div class="flex items-center gap-2 font-medium">

                <i data-lucide="circle-alert" class="h-4 w-4"></i>

                Please fix the following errors:
                
            </div>

            <ul class="mt-2 list-disc pl-6">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FEE CARDS --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

        @forelse($fees as $fee)

            <div
                class="group rounded-xl border border-[#e5eaf0] bg-white p-4 shadow-[0_1px_3px_rgba(16,24,40,0.04)] transition duration-200 hover:-translate-y-0.5 hover:border-[#d5e2ef] hover:shadow-md">


                {{-- ================================================= --}}
                {{-- TOP --}}
                {{-- ================================================= --}}

                <div class="flex items-center justify-between">

                    {{-- Icon + Plan --}}
                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#2874b9]">

                            <i
                                data-lucide="wallet-cards"
                                class="h-5 w-5">
                            </i>

                        </div>

                        <div>

                            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                Fee Plan
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#111827]">
                                {{ $fee->fees }}
                            </p>

                        </div>

                    </div>


                    {{-- Delete --}}
                    <form
                        action="{{ route('admin.fees.destroy', $fee->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this fee?');">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            title="Delete fee plan"
                            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-red-50 hover:text-red-600">

                            <i
                                data-lucide="trash-2"
                                class="h-4 w-4">
                            </i>

                        </button>

                    </form>

                </div>


                {{-- ================================================= --}}
                {{-- LIBRARY --}}
                {{-- ================================================= --}}

                <div class="mt-4 rounded-lg bg-[#f8fafc] px-3 py-2.5">

                    <div class="flex items-center gap-2">

                        <i
                            data-lucide="library"
                            class="h-4 w-4 shrink-0 text-[#2874b9]">
                        </i>

                        <div class="min-w-0">

                            <p class="text-[10px] font-medium uppercase tracking-wide text-gray-400">
                                Library
                            </p>

                            <p
                                class="mt-0.5 truncate text-sm font-semibold text-[#27364b]"
                                title="{{ $fee->library?->name ?? 'No Library' }}">

                                {{ $fee->library?->name ?? 'No Library' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- AMOUNT --}}
                {{-- ================================================= --}}

                <div class="mt-3 flex items-end justify-between">

                    <div>

                        <p class="text-[11px] font-medium text-gray-400">
                            Monthly Amount
                        </p>

                        <p class="mt-0.5 text-2xl font-extrabold leading-none text-[#2874b9]">

                            ₹{{ number_format((float) $fee->amount, 2) }}

                        </p>

                    </div>


                    {{-- Monthly Badge --}}
                    <div
                        class="mb-0.5 flex items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-600">

                        <i
                            data-lucide="calendar-days"
                            class="h-3 w-3">
                        </i>

                        Monthly

                    </div>

                </div>


            </div>

        @empty


            {{-- ================================================= --}}
            {{-- EMPTY STATE --}}
            {{-- ================================================= --}}

            <div
                class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

                    <i
                        data-lucide="wallet-cards"
                        class="h-6 w-6">
                    </i>

                </div>

                <h3 class="mt-4 text-base font-semibold text-gray-900">
                    No fee plans found
                </h3>

                <p class="mt-1 text-sm text-gray-500">
                    Add your first monthly fee plan to get started.
                </p>

                <button
                    type="button"
                    onclick="openFeeModal()"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2 text-sm font-medium text-white transition hover:bg-[#2167a7]">

                    <i data-lucide="plus" class="h-4 w-4"></i>

                    Add Fee Plan

                </button>

            </div>

        @endforelse

    </div>


</div>


{{-- ============================================================= --}}
{{-- ADD FEE MODAL --}}
{{-- ============================================================= --}}

<div
    id="studentModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

    <div
        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">


        {{-- MODAL HEADER --}}
        <div class="flex items-start justify-between">

            <div>

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#e7f1fb] text-[#2874b9]">

                        <i data-lucide="wallet-cards" class="h-4 w-4"></i>

                    </div>

                    <h2 class="text-xl font-semibold text-gray-900">
                        Add Fee Plan
                    </h2>

                </div>

                <p class="mt-2 text-xs text-gray-500">
                    Create a monthly fee plan for a library
                </p>

            </div>


            {{-- CLOSE --}}
            <button
                type="button"
                onclick="closeFeeModal()"
                class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">

                <i
                    data-lucide="x"
                    class="h-4 w-4">
                </i>

            </button>

        </div>


        {{-- FORM --}}
        <form
            method="POST"
            action="{{ route('admin.fees.store') }}"
            class="mt-6 space-y-4">

            @csrf


            {{-- LIBRARY --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">

                    Library

                    <span class="text-red-500">*</span>

                </label>

                <div class="relative">

                    <i
                        data-lucide="library"
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                    </i>

                    <select
                        name="library_id"
                        required
                        class="w-full appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-9 text-sm text-gray-800 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                        <option value="">
                            Select Library
                        </option>

                        @foreach($libraries as $library)

                            <option value="{{ $library->id }}">
                                {{ $library->name }}
                            </option>

                        @endforeach

                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                    </i>

                </div>

            </div>


            {{-- FEE PLAN --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">

                    Fee Plan

                    <span class="text-red-500">*</span>

                </label>

                <div class="relative">

                    <i
                        data-lucide="calendar-days"
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                    </i>

                    <input
                        type="text"
                        value="Monthly"
                        readonly
                        class="w-full rounded-lg border border-gray-300 bg-gray-100 py-2.5 pl-10 pr-3.5 text-sm font-medium text-gray-700 outline-none">

                </div>

                <input
                    type="hidden"
                    name="fees"
                    value="Monthly">

            </div>


            {{-- AMOUNT --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-gray-700">

                    Monthly Amount

                    <span class="text-red-500">*</span>

                </label>

                <div class="relative">

                    <span
                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-500">

                        ₹

                    </span>

                    <input
                        type="number"
                        name="amount"
                        min="0"
                        step="0.01"
                        placeholder="1000"
                        required
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-8 pr-3.5 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                </div>

            </div>


            {{-- BUTTONS --}}
            <div class="flex items-center justify-end gap-3 pt-3">

                <button
                    type="button"
                    onclick="closeFeeModal()"
                    class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#2167a7]">

                    <i data-lucide="save" class="h-4 w-4"></i>

                    Save

                </button>

            </div>

        </form>

    </div>

</div>


{{-- ============================================================= --}}
{{-- MODAL JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

    function openFeeModal()
    {
        const modal = document.getElementById('studentModal');

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


    function closeFeeModal()
    {
        const modal = document.getElementById('studentModal');

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    document.addEventListener('DOMContentLoaded', function ()
    {

        const modal = document.getElementById('studentModal');


        if (modal) {

            modal.addEventListener('click', function (event)
            {

                if (event.target === modal) {

                    closeFeeModal();

                }

            });

        }


        document.addEventListener('keydown', function (event)
        {

            if (event.key === 'Escape') {

                closeFeeModal();

            }

        });


        if (typeof lucide !== 'undefined') {

            lucide.createIcons();

        }

    });

</script>

@endsection