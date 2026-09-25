@extends('admin.layouts.app')

@section('title', 'Fee & Wallet Report')

@section('content')

@php
    /*
     * Only students having pending/partial due fees.
     */
    $dueStudents = $studentReports->filter(function ($report) {
        return (float) $report['due_amount'] > 0;
    })->values();
@endphp

<div>

    {{-- PAGE HEADER --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between print:hidden">

        <div>

            <h1 class="text-2xl font-bold text-[#111827]">
                Due Fee Report
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Students with pending or partial fees
            </p>

            {{-- Library Filter --}}
            <form
                method="GET"
                action="{{ route('admin.fee-wallet-report') }}"
                class="mt-4">

                <select
                    name="library_id"
                    onchange="this.form.submit()"
                    class="cursor-pointer rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                    <option value="">
                        All Libraries
                    </option>

                    @foreach($libraries as $library)

                        <option
                            value="{{ $library->id }}"
                            {{ request('library_id') == $library->id ? 'selected' : '' }}>

                            {{ $library->name }}

                        </option>

                    @endforeach

                </select>

            </form>

        </div>


        {{-- PRINT BUTTON --}}
        <button
            type="button"
            onclick="window.print()"
            class="inline-flex w-fit cursor-pointer items-center gap-2 rounded-lg bg-[#111827] px-4 py-2 text-sm font-medium text-white transition hover:bg-black">

            <i data-lucide="printer" class="h-4 w-4"></i>

            Print Report

        </button>

    </div>


    {{-- ========================================================= --}}
    {{-- COMPACT STAT CARDS --}}
    {{-- ========================================================= --}}

    <div class="mb-5 grid grid-cols-1 gap-3 sm:grid-cols-3 print:hidden">


        {{-- DUE STUDENTS --}}
        <div
            class="rounded-xl border border-[#e5eaf0] bg-white px-4 py-3 shadow-[0_1px_3px_rgba(16,24,40,0.03)]">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                        Due Students
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold leading-none text-[#111827]">
                        {{ $dueStudents->count() }}
                    </h2>

                    <p class="mt-1 text-[11px] text-[#8291a8]">
                        Students with pending fees
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">

                    <i data-lucide="users" class="h-5 w-5"></i>

                </div>

            </div>

        </div>


        {{-- TOTAL WALLET BALANCE --}}
        <div
            class="rounded-xl border border-[#e5eaf0] bg-white px-4 py-3 shadow-[0_1px_3px_rgba(16,24,40,0.03)]">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                        Wallet Balance
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold leading-none text-[#111827]">
                        ₹{{ number_format($dueStudents->sum('wallet_balance'), 2) }}
                    </h2>

                    <p class="mt-1 text-[11px] text-[#8291a8]">
                        Wallet of due students
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">

                    <i data-lucide="wallet" class="h-5 w-5"></i>

                </div>

            </div>

        </div>


        {{-- TOTAL DUE FEES --}}
        <div
            class="rounded-xl border border-[#e5eaf0] bg-white px-4 py-3 shadow-[0_1px_3px_rgba(16,24,40,0.03)]">

            <div class="flex items-center justify-between gap-3">

                <div class="min-w-0">

                    <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                        Total Due
                    </p>

                    <h2 class="mt-1 text-2xl font-extrabold leading-none text-[#111827]">
                        ₹{{ number_format($dueStudents->sum('due_amount'), 2) }}
                    </h2>

                    <p class="mt-1 text-[11px] text-[#8291a8]">
                        Total pending fees
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">

                    <i data-lucide="receipt" class="h-5 w-5"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PRINTABLE REPORT --}}
    {{-- ========================================================= --}}

    <div
        class="rounded-xl bg-white p-6 shadow-sm print:rounded-none print:p-0 print:shadow-none">


        {{-- PRINT TITLE --}}
        <div class="mb-6 hidden text-center print:block">

            <h2 class="text-xl font-bold text-gray-900">
                STUDENT DUE FEE REPORT
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Date: {{ now()->format('d M Y') }}
            </p>

            @if(request('library_id'))

                @php
                    $selectedLibrary = $libraries->firstWhere(
                        'id',
                        request('library_id')
                    );
                @endphp

                @if($selectedLibrary)

                    <p class="mt-1 text-sm font-medium text-gray-700">
                        Library: {{ $selectedLibrary->name }}
                    </p>

                @endif

            @else

                <p class="mt-1 text-sm font-medium text-gray-700">
                    All Libraries
                </p>

            @endif

        </div>


        {{-- REPORT TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full border-collapse text-sm">

                <thead>

                    <tr class="border border-gray-300 bg-gray-100">

                        <th
                            class="border border-gray-300 px-3 py-3 text-left font-semibold text-gray-800">
                            S.No.
                        </th>

                        <th
                            class="border border-gray-300 px-3 py-3 text-left font-semibold text-gray-800">
                            Student Name
                        </th>

                        <th
                            class="border border-gray-300 px-3 py-3 text-left font-semibold text-gray-800">
                            Library
                        </th>

                        <th
                            class="border border-gray-300 px-3 py-3 text-right font-semibold text-gray-800">
                            Wallet Balance
                        </th>

                        <th
                            class="border border-gray-300 px-3 py-3 text-right font-semibold text-gray-800">
                            Due Fee
                        </th>

                        <th
                            class="border border-gray-300 px-3 py-3 text-center font-semibold text-gray-800">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($dueStudents as $index => $report)

                        <tr class="border border-gray-300">


                            {{-- S.NO --}}
                            <td class="border border-gray-300 px-3 py-3">
                                {{ $index + 1 }}
                            </td>


                            {{-- STUDENT --}}
                            <td
                                class="border border-gray-300 px-3 py-3 font-medium text-gray-900">

                                {{ $report['student']->name }}

                            </td>


                            {{-- LIBRARY --}}
                            <td
                                class="border border-gray-300 px-3 py-3 text-gray-700">

                                @if(isset($report['student']->seatAssignments) && $report['student']->seatAssignments->count())

                                    @php
                                        $activeAssignment = $report['student']->seatAssignments
                                            ->where('status', 'active')
                                            ->first();
                                    @endphp

                                    @if($activeAssignment && $activeAssignment->seat && $activeAssignment->seat->library)

                                        {{ $activeAssignment->seat->library->name }}

                                    @else

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @endif

                                @else

                                    <span class="text-gray-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- WALLET --}}
                            <td
                                class="border border-gray-300 px-3 py-3 text-right">

                                ₹{{ number_format($report['wallet_balance'], 2) }}

                            </td>


                            {{-- DUE --}}
                            <td
                                class="border border-gray-300 px-3 py-3 text-right font-semibold text-red-600">

                                ₹{{ number_format($report['due_amount'], 2) }}

                            </td>


                            {{-- STATUS --}}
                            <td
                                class="border border-gray-300 px-3 py-3 text-center">

                                <span class="font-semibold text-red-600">
                                    Due
                                </span>

                            </td>


                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="border border-gray-300 px-4 py-8 text-center text-green-600">

                                No students have pending fees.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ========================================================= --}}
        {{-- REPORT FOOTER --}}
        {{-- ========================================================= --}}

        <div
            class="mt-6 flex flex-col gap-2 border-t border-gray-300 pt-3 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">

            <span>
                Due Students: {{ $dueStudents->count() }}
            </span>

            <span>
                Total Wallet:
                ₹{{ number_format($dueStudents->sum('wallet_balance'), 2) }}
            </span>

            <span>
                Total Due:
                ₹{{ number_format($dueStudents->sum('due_amount'), 2) }}
            </span>

            <span>
                Generated:
                {{ now()->format('d M Y h:i A') }}
            </span>

        </div>


    </div>

</div>


{{-- ============================================================= --}}
{{-- PRINT CSS --}}
{{-- ============================================================= --}}

<style>

@media print {

    @page {
        size: A4 portrait;
        margin: 12mm;
    }

    html,
    body {
        background: white !important;
    }

    nav,
    aside,
    header {
        display: none !important;
    }

    .print\:hidden {
        display: none !important;
    }

    .print\:block {
        display: block !important;
    }

    .print\:shadow-none {
        box-shadow: none !important;
    }

    .print\:rounded-none {
        border-radius: 0 !important;
    }

    .print\:p-0 {
        padding: 0 !important;
    }

    table {
        width: 100%;
        page-break-inside: auto;
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }

    thead {
        display: table-header-group;
    }

    th,
    td {
        border: 1px solid #d1d5db !important;
        color: #111827 !important;
    }

}

</style>

@endsection
