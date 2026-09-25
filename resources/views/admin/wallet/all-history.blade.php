@extends('admin.layouts.app')

@section('title', 'All Student History')

@section('content')

<div class="min-h-screen bg-[#f7f9fc]">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff]">
                    <i data-lucide="history" class="h-5 w-5 text-[#2874b9]"></i>
                </div>

                <div>
                    <h1 class="text-xl font-bold text-[#111827] sm:text-2xl">
                        All Student History
                    </h1>

                    <p class="mt-0.5 text-sm text-[#667085]">
                        View wallet deposits and fee deductions
                    </p>
                </div>
            </div>
        </div>

        <a
            href="{{ route('admin.student.index') }}"
            class="inline-flex w-fit items-center gap-2 rounded-xl border border-[#dbe3ec] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] shadow-sm transition hover:border-[#2874b9] hover:text-[#2874b9] cursor-pointer"
        >
            <i data-lucide="users" class="h-4 w-4"></i>
            Students
        </a>

    </div>


    {{-- =========================================================
        SUMMARY CARDS
    ========================================================== --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Wallet Added --}}
        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-[0_4px_20px_rgba(16,24,40,0.04)]">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-[#667085]">
                        Wallet Added
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        ₹{{ number_format($totalCredit, 2) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#ecfdf3]">
                    <i data-lucide="wallet" class="h-5 w-5 text-[#12b76a]"></i>
                </div>

            </div>

            <p class="mt-3 text-xs text-[#98a2b3]">
                Total wallet deposits
            </p>

        </div>


        {{-- Fees Deducted --}}
        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-[0_4px_20px_rgba(16,24,40,0.04)]">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-[#667085]">
                        Fees Deducted
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        ₹{{ number_format($totalDebit, 2) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff4ed]">
                    <i data-lucide="receipt" class="h-5 w-5 text-[#f79009]"></i>
                </div>

            </div>

            <p class="mt-3 text-xs text-[#98a2b3]">
                Fees paid from wallet
            </p>

        </div>


        {{-- Net Movement --}}
        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-[0_4px_20px_rgba(16,24,40,0.04)]">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-[#667085]">
                        Net Movement
                    </p>

                    <p class="mt-2 text-2xl font-bold {{ $netMovement >= 0 ? 'text-[#2874b9]' : 'text-[#d92d20]' }}">
                        ₹{{ number_format($netMovement, 2) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff]">
                    <i data-lucide="arrow-left-right" class="h-5 w-5 text-[#2874b9]"></i>
                </div>

            </div>

            <p class="mt-3 text-xs text-[#98a2b3]">
                Credits minus debits
            </p>

        </div>


        {{-- Transactions --}}
        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-[0_4px_20px_rgba(16,24,40,0.04)]">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-[#667085]">
                        Transactions
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        {{ number_format($totalTransactions) }}
                    </p>
                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f4f3ff]">
                    <i data-lucide="list-checks" class="h-5 w-5 text-[#7f56d9]"></i>
                </div>

            </div>

            <p class="mt-3 text-xs text-[#98a2b3]">
                Matching transactions
            </p>

        </div>

    </div>


    {{-- =========================================================
        FILTER CARD
    ========================================================== --}}
    <div class="mb-6 rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-[0_4px_20px_rgba(16,24,40,0.04)] sm:p-5">

        <div class="mb-4 flex items-center gap-2">

            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff]">
                <i data-lucide="sliders-horizontal" class="h-4 w-4 text-[#2874b9]"></i>
            </div>

            <div>
                <h2 class="text-sm font-bold text-[#111827]">
                    Filter History
                </h2>

                <p class="text-xs text-[#98a2b3]">
                    Select date range and transaction type
                </p>
            </div>

        </div>


        <form
            method="GET"
            action="{{ route('admin.all-student-history') }}"
            id="historyFilterForm"
        >

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">

                {{-- Date Filter --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-[#344054]">
                        Date Range
                    </label>

                    <select
                        name="filter"
                        id="dateFilter"
                        class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10 cursor-pointer"
                    >
                        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>
                            All History
                        </option>

                        <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>
                            Today
                        </option>

                        <option value="this_month" {{ $filter === 'this_month' ? 'selected' : '' }}>
                            This Month
                        </option>

                        <option value="last_month" {{ $filter === 'last_month' ? 'selected' : '' }}>
                            Last Month
                        </option>

                        <option value="custom" {{ $filter === 'custom' ? 'selected' : '' }}>
                            Custom Date
                        </option>
                    </select>
                </div>


                {{-- Student Search --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-[#344054]">
                        Student
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="search"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                        ></i>

                        <input
                            type="text"
                            name="student"
                            value="{{ $studentSearch }}"
                            placeholder="Search name or mobile..."
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-3.5 text-sm text-[#344054] outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>
                </div>


                {{-- Transaction Type --}}
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-[#344054]">
                        Transaction Type
                    </label>

                    <select
                        name="type"
                        class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10 cursor-pointer"
                    >
                        <option value="all" {{ $type === 'all' ? 'selected' : '' }}>
                            All Transactions
                        </option>

                        <option value="credit" {{ $type === 'credit' ? 'selected' : '' }}>
                            Wallet Added
                        </option>

                        <option value="debit" {{ $type === 'debit' ? 'selected' : '' }}>
                            Fee Deducted
                        </option>
                    </select>
                </div>


                {{-- Filter Button --}}
                <div class="flex items-end">

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205f98] hover:shadow-md cursor-pointer"
                    >
                        <i data-lucide="filter" class="h-4 w-4"></i>
                        Apply Filter
                    </button>

                </div>

            </div>


            {{-- =================================================
                CUSTOM DATE
            ================================================== --}}
            <div
                id="customDateFields"
                class="{{ $filter === 'custom' ? '' : 'hidden' }} mt-4 rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-4"
            >

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#344054]">
                            From Date
                        </label>

                        <input
                            type="date"
                            name="from_date"
                            value="{{ $filter === 'custom' ? request('from_date') : '' }}"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10 cursor-pointer"
                        >
                    </div>


                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#344054]">
                            To Date
                        </label>

                        <input
                            type="date"
                            name="to_date"
                            value="{{ $filter === 'custom' ? request('to_date') : '' }}"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10 cursor-pointer"
                        >
                    </div>

                </div>

            </div>

        </form>


        {{-- Active Filter --}}
        @if(
            $filter !== 'all' ||
            $studentSearch !== '' ||
            $type !== 'all'
        )

            <div class="mt-4 flex flex-wrap items-center gap-2">

                <span class="text-xs font-medium text-[#667085]">
                    Active filters:
                </span>

                @if($filter !== 'all')
                    <span class="inline-flex items-center gap-1 rounded-full bg-[#eef6ff] px-2.5 py-1 text-xs font-semibold text-[#2874b9]">
                        <i data-lucide="calendar" class="h-3 w-3"></i>
                        {{ ucfirst(str_replace('_', ' ', $filter)) }}
                    </span>
                @endif

                @if($studentSearch !== '')
                    <span class="inline-flex items-center gap-1 rounded-full bg-[#f2f4f7] px-2.5 py-1 text-xs font-semibold text-[#344054]">
                        <i data-lucide="user" class="h-3 w-3"></i>
                        {{ $studentSearch }}
                    </span>
                @endif

                @if($type !== 'all')
                    <span class="inline-flex items-center gap-1 rounded-full bg-[#f2f4f7] px-2.5 py-1 text-xs font-semibold text-[#344054]">
                        <i data-lucide="arrow-down-up" class="h-3 w-3"></i>
                        {{ $type === 'credit' ? 'Wallet Added' : 'Fee Deducted' }}
                    </span>
                @endif

                <a
                    href="{{ route('admin.all-student-history') }}"
                    class="ml-1 inline-flex items-center gap-1 rounded-lg px-2 py-1 text-xs font-semibold text-[#d92d20] transition hover:bg-[#fef3f2] cursor-pointer"
                >
                    <i data-lucide="x" class="h-3.5 w-3.5"></i>
                    Clear
                </a>

            </div>

        @endif

    </div>


    {{-- =========================================================
        CURRENT DUE
    ========================================================== --}}
    <div class="mb-6 rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-[0_4px_20px_rgba(16,24,40,0.04)] sm:p-5">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff4ed]">
                    <i data-lucide="clock-3" class="h-5 w-5 text-[#f79009]"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold text-[#344054]">
                        Current Pending Fees
                    </p>

                    <p class="text-xs text-[#98a2b3]">
                        Pending amount for matching students
                    </p>
                </div>

            </div>

            <div class="text-left sm:text-right">
                <p class="text-xl font-bold text-[#d92d20]">
                    ₹{{ number_format($pendingDue, 2) }}
                </p>
            </div>

        </div>

    </div>


    {{-- =========================================================
        TRANSACTION TABLE
    ========================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-[0_4px_20px_rgba(16,24,40,0.04)]">

        {{-- Table Header --}}
        <div class="border-b border-[#e4e8ef] px-4 py-4 sm:px-5">

            <div class="flex items-center justify-between gap-3">

                <div>
                    <h2 class="text-sm font-bold text-[#111827]">
                        Transaction History
                    </h2>

                    <p class="mt-0.5 text-xs text-[#98a2b3]">
                        {{ $transactions->total() }} transaction{{ $transactions->total() == 1 ? '' : 's' }} found
                    </p>
                </div>

                <div class="hidden items-center gap-2 rounded-lg bg-[#f8fafc] px-3 py-2 text-xs font-medium text-[#667085] sm:flex">
                    <i data-lucide="database" class="h-3.5 w-3.5"></i>
                    Live Records
                </div>

            </div>

        </div>


        @if($transactions->count())

            {{-- =================================================
                DESKTOP TABLE
            ================================================== --}}
            <div class="hidden overflow-x-auto lg:block">

                <table class="w-full min-w-[1000px]">

                    <thead class="bg-[#f8fafc]">

                        <tr class="border-b border-[#e4e8ef]">

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Date
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Student
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Transaction
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Description
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Amount
                            </th>

                            

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Due
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-[#eef1f5]">

                        @foreach($transactions as $transaction)

                            @php
                                $student = $transaction->student;

                                $walletBalance = $student?->wallet?->balance ?? 0;

                                $studentDue = \App\Models\FeeCycle::query()
                                    ->where('student_id', $student?->id)
                                    ->whereColumn('amount', '>', 'paid_amount')
                                    ->sum(\Illuminate\Support\Facades\DB::raw('amount - paid_amount'));

                                $isCredit = $transaction->type === 'credit';
                            @endphp

                            <tr class="transition hover:bg-[#fbfcfe]">

                                {{-- Date --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="flex items-center gap-2">

                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f8fafc]">
                                            <i data-lucide="calendar-days" class="h-4 w-4 text-[#667085]"></i>
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-[#344054]">
                                                {{ $transaction->transaction_date?->format('d M Y') }}
                                            </p>

                                            <p class="text-[11px] text-[#98a2b3]">
                                                #{{ $transaction->id }}
                                            </p>
                                        </div>

                                    </div>

                                </td>


                                {{-- Student --}}
                                <td class="px-5 py-4">

                                    @if($student)

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-xs font-bold text-[#2874b9]">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate text-sm font-semibold text-[#111827]">
                                                    {{ $student->name }}
                                                </p>

                                                <p class="text-xs text-[#667085]">
                                                    {{ $student->mobile }}
                                                </p>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-sm text-[#98a2b3]">
                                            Student deleted
                                        </span>

                                    @endif

                                </td>


                                {{-- Transaction --}}
                                <td class="px-5 py-4">

                                    @if($isCredit)

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ecfdf3] px-2.5 py-1 text-xs font-semibold text-[#027a48]">
                                            <i data-lucide="arrow-down-left" class="h-3.5 w-3.5"></i>
                                            Wallet Added
                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#fff4ed] px-2.5 py-1 text-xs font-semibold text-[#c4320a]">
                                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5"></i>
                                            Fee Deducted
                                        </span>

                                    @endif

                                </td>


                                {{-- Description --}}
                                <td class="max-w-[280px] px-5 py-4">

                                    <p class="truncate text-sm text-[#344054]">
                                        {{ $transaction->description ?: '—' }}
                                    </p>

                                </td>


                                {{-- Amount --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <p class="text-sm font-bold {{ $isCredit ? 'text-[#12b76a]' : 'text-[#d92d20]' }}">

                                        {{ $isCredit ? '+' : '-' }}
                                        ₹{{ number_format((float) $transaction->amount, 2) }}

                                    </p>

                                </td>


                                


                                {{-- Due --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <p class="text-sm font-semibold {{ $studentDue > 0 ? 'text-[#d92d20]' : 'text-[#12b76a]' }}">
                                        ₹{{ number_format((float) $studentDue, 2) }}
                                    </p>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                MOBILE / TABLET CARDS
            ================================================== --}}
            <div class="divide-y divide-[#eef1f5] lg:hidden">

                @foreach($transactions as $transaction)

                    @php
                        $student = $transaction->student;

                        $walletBalance = $student?->wallet?->balance ?? 0;

                        $studentDue = \App\Models\FeeCycle::query()
                            ->where('student_id', $student?->id)
                            ->whereColumn('amount', '>', 'paid_amount')
                            ->sum(\Illuminate\Support\Facades\DB::raw('amount - paid_amount'));

                        $isCredit = $transaction->type === 'credit';
                    @endphp

                    <div class="p-4 sm:p-5">

                        <div class="rounded-xl border border-[#e8edf3] bg-[#fbfcfe] p-4">

                            {{-- Top --}}
                            <div class="flex items-start justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-sm font-bold text-[#2874b9]">
                                        {{ $student ? strtoupper(substr($student->name, 0, 1)) : '?' }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-[#111827]">
                                            {{ $student?->name ?? 'Student deleted' }}
                                        </p>

                                        @if($student)
                                            <p class="text-xs text-[#667085]">
                                                {{ $student->mobile }}
                                            </p>
                                        @endif

                                    </div>

                                </div>


                                @if($isCredit)

                                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-[#ecfdf3] px-2 py-1 text-[11px] font-semibold text-[#027a48]">
                                        <i data-lucide="plus" class="h-3 w-3"></i>
                                        Credit
                                    </span>

                                @else

                                    <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-[#fff4ed] px-2 py-1 text-[11px] font-semibold text-[#c4320a]">
                                        <i data-lucide="minus" class="h-3 w-3"></i>
                                        Debit
                                    </span>

                                @endif

                            </div>


                            {{-- Date --}}
                            <div class="mt-4 flex items-center gap-2 text-xs text-[#667085]">

                                <i data-lucide="calendar-days" class="h-3.5 w-3.5"></i>

                                {{ $transaction->transaction_date?->format('d M Y') }}

                                <span class="text-[#d0d5dd]">
                                    •
                                </span>

                                #{{ $transaction->id }}

                            </div>


                            {{-- Description --}}
                            <div class="mt-3">

                                <p class="text-xs font-medium uppercase tracking-wide text-[#98a2b3]">
                                    Description
                                </p>

                                <p class="mt-1 text-sm text-[#344054]">
                                    {{ $transaction->description ?: '—' }}
                                </p>

                            </div>


                            {{-- Bottom Stats --}}
                            <div class="mt-4 grid grid-cols-3 gap-2">

                                <div class="rounded-lg bg-white p-2.5">

                                    <p class="text-[10px] font-medium text-[#98a2b3]">
                                        Amount
                                    </p>

                                    <p class="mt-1 text-sm font-bold {{ $isCredit ? 'text-[#12b76a]' : 'text-[#d92d20]' }}">
                                        {{ $isCredit ? '+' : '-' }}₹{{ number_format((float) $transaction->amount, 2) }}
                                    </p>

                                </div>


                                <div class="rounded-lg bg-white p-2.5">

                                    <p class="text-[10px] font-medium text-[#98a2b3]">
                                        Wallet
                                    </p>

                                    <p class="mt-1 text-sm font-bold text-[#344054]">
                                        ₹{{ number_format((float) $walletBalance, 2) }}
                                    </p>

                                </div>


                                <div class="rounded-lg bg-white p-2.5">

                                    <p class="text-[10px] font-medium text-[#98a2b3]">
                                        Due
                                    </p>

                                    <p class="mt-1 text-sm font-bold {{ $studentDue > 0 ? 'text-[#d92d20]' : 'text-[#12b76a]' }}">
                                        ₹{{ number_format((float) $studentDue, 2) }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}
            @if($transactions->hasPages())

                <div class="border-t border-[#e4e8ef] px-4 py-4 sm:px-5">
                    {{ $transactions->onEachSide(1)->links() }}
                </div>

            @endif


        @else

            {{-- =================================================
                EMPTY STATE
            ================================================== --}}
            <div class="px-5 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef6ff]">
                    <i data-lucide="history" class="h-7 w-7 text-[#2874b9]"></i>
                </div>

                <h3 class="mt-4 text-base font-bold text-[#111827]">
                    No transactions found
                </h3>

                <p class="mx-auto mt-1 max-w-sm text-sm text-[#667085]">
                    No wallet or fee transactions match the selected filters.
                </p>

                <a
                    href="{{ route('admin.all-student-history') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                >
                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                    Reset Filters
                </a>

            </div>

        @endif

    </div>

</div>


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const dateFilter =
        document.getElementById('dateFilter');

    const customDateFields =
        document.getElementById('customDateFields');


    /*
    |--------------------------------------------------------------------------
    | Custom Date Toggle
    |--------------------------------------------------------------------------
    */

    function toggleCustomDates() {

        if (!dateFilter || !customDateFields) {
            return;
        }

        if (dateFilter.value === 'custom') {

            customDateFields.classList.remove('hidden');

        } else {

            customDateFields.classList.add('hidden');

        }
    }


    if (dateFilter) {

        dateFilter.addEventListener(
            'change',
            toggleCustomDates
        );

        toggleCustomDates();
    }


    /*
    |--------------------------------------------------------------------------
    | Lucide Icons
    |--------------------------------------------------------------------------
    */

    if (
        typeof lucide !== 'undefined'
        &&
        typeof lucide.createIcons === 'function'
    ) {

        lucide.createIcons();

    }

});

</script>

@endsection
