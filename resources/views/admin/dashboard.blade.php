@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen bg-[#f7f9fc]">

    <main class="px-4 py-6 sm:px-6 lg:px-8">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="mb-7 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-[#2874b9]"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8291a8]">
                        Admin Overview
                    </span>
                </div>

                <h1 class="mt-2 text-2xl font-extrabold tracking-tight text-[#111827] sm:text-3xl">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Welcome back,
                    <span class="font-semibold text-[#344054]">
                        {{ auth()->user()->name }}
                    </span>.
                    Here's your library overview for today.
                </p>
            </div>


            {{-- Quick actions --}}
            <div class="flex flex-wrap items-center gap-2">

                <a
                    href="{{ route('admin.student.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#dfe5ec] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] shadow-sm transition hover:border-[#cbd5e1] hover:bg-[#f8fafc] cursor-pointer"
                >
                    <i data-lucide="users" class="h-4 w-4 text-[#2874b9]"></i>
                    Students
                </a>

                <a
                    href="{{ route('admin.all-student-history') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#cfe2f2] bg-[#eef6ff] px-4 py-2.5 text-sm font-semibold text-[#2874b9] shadow-sm transition hover:bg-[#e2f0fc] cursor-pointer"
                >
                    <i data-lucide="history" class="h-4 w-4"></i>
                    Student History
                </a>

                <a
                    href="{{ route('admin.seat.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#205f98] hover:shadow-md cursor-pointer"
                >
                    <i data-lucide="armchair" class="h-4 w-4"></i>
                    Manage Seats
                </a>

            </div>

        </div>



        {{-- =========================================================
             HERO / MAIN OVERVIEW
        ========================================================== --}}
        <div class="mb-5 overflow-hidden rounded-3xl border border-[#dce8f3] bg-white shadow-[0_10px_40px_rgba(16,24,40,0.05)]">

            <div class="relative overflow-hidden bg-gradient-to-br from-[#f5faff] via-white to-[#eef7ff] p-5 sm:p-6 lg:p-7">

                {{-- Decorative shapes --}}
                <div class="pointer-events-none absolute -right-16 -top-20 h-56 w-56 rounded-full bg-[#2874b9]/[0.05]"></div>
                <div class="pointer-events-none absolute -bottom-24 right-28 h-48 w-48 rounded-full bg-[#2874b9]/[0.04]"></div>

                <div class="relative grid grid-cols-1 gap-6 xl:grid-cols-[1fr_auto] xl:items-center">

                    <div>

                        <div class="flex items-center gap-3">

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#2874b9] text-white shadow-[0_8px_20px_rgba(40,116,185,0.22)]">
                                <i data-lucide="layout-dashboard" class="h-6 w-6"></i>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-[#2874b9]">
                                    Library Management
                                </p>

                                <h2 class="mt-0.5 text-xl font-bold text-[#172033]">
                                    Everything at a glance
                                </h2>
                            </div>

                        </div>


                        <p class="mt-4 max-w-2xl text-sm leading-6 text-[#667085]">
                            Monitor students, seats, wallet collections, transaction history
                            and pending fees from one central dashboard.
                        </p>


                        <div class="mt-5 flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.student.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-3.5 py-2 text-xs font-semibold text-[#344054] ring-1 ring-[#dfe7ef] transition hover:bg-[#f8fafc] cursor-pointer"
                            >
                                <i data-lucide="user-plus" class="h-4 w-4 text-[#2874b9]"></i>
                                Students
                            </a>

                            <a
                                href="{{ route('admin.fee-wallet-report') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-3.5 py-2 text-xs font-semibold text-[#344054] ring-1 ring-[#dfe7ef] transition hover:bg-[#f8fafc] cursor-pointer"
                            >
                                <i data-lucide="wallet" class="h-4 w-4 text-[#2874b9]"></i>
                                Wallet Report
                            </a>

                            {{-- NEW --}}
                            <a
                                href="{{ route('admin.all-student-history') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#205f98] cursor-pointer"
                            >
                                <i data-lucide="history" class="h-4 w-4"></i>
                                All Student History
                            </a>

                            <a
                                href="{{ route('admin.library.index') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-3.5 py-2 text-xs font-semibold text-[#344054] ring-1 ring-[#dfe7ef] transition hover:bg-[#f8fafc] cursor-pointer"
                            >
                                <i data-lucide="library" class="h-4 w-4 text-[#2874b9]"></i>
                                Libraries
                            </a>

                        </div>

                    </div>


                    {{-- Hero mini stats --}}
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 xl:grid-cols-2">

                        <div class="min-w-[130px] rounded-2xl border border-white bg-white/90 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                                    Students
                                </span>

                                <i data-lucide="users" class="h-4 w-4 text-[#2874b9]"></i>
                            </div>

                            <p class="mt-2 text-xl font-extrabold text-[#111827]">
                                {{ $studentCount }}
                            </p>

                            <p class="mt-0.5 text-[11px] text-[#667085]">
                                {{ $activeStudentCount }} active
                            </p>
                        </div>


                        <div class="min-w-[130px] rounded-2xl border border-white bg-white/90 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                                    Libraries
                                </span>

                                <i data-lucide="library" class="h-4 w-4 text-emerald-500"></i>
                            </div>

                            <p class="mt-2 text-xl font-extrabold text-[#111827]">
                                {{ $libraryCount }}
                            </p>

                            <p class="mt-0.5 text-[11px] text-[#667085]">
                                Active locations
                            </p>
                        </div>


                        <div class="min-w-[130px] rounded-2xl border border-white bg-white/90 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                                    Seats
                                </span>

                                <i data-lucide="armchair" class="h-4 w-4 text-[#1683df]"></i>
                            </div>

                            <p class="mt-2 text-xl font-extrabold text-[#111827]">
                                {{ $seatCount }}
                            </p>

                            <p class="mt-0.5 text-[11px] text-[#667085]">
                                {{ $availableSeatCount }} available
                            </p>
                        </div>


                        <div class="min-w-[130px] rounded-2xl border border-white bg-white/90 p-4 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                                    Wallet
                                </span>

                                <i data-lucide="wallet" class="h-4 w-4 text-violet-500"></i>
                            </div>

                            <p class="mt-2 text-xl font-extrabold text-[#111827]">
                                ₹{{ number_format($totalWalletBalance, 0) }}
                            </p>

                            <p class="mt-0.5 text-[11px] text-[#667085]">
                                Total balance
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- =========================================================
             FINANCIAL SUMMARY
        ========================================================== --}}
        <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Wallet --}}
            <a
                href="{{ route('admin.fee-wallet-report') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition duration-200 hover:-translate-y-0.5 hover:border-[#cbddea] hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                        <i data-lucide="wallet" class="h-5 w-5"></i>
                    </div>

                    <div class="rounded-lg bg-[#f4f9ff] p-1.5 text-[#2874b9] transition group-hover:translate-x-0.5">
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </div>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                    Wallet Balance
                </p>

                <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#111827]">
                    ₹{{ number_format($totalWalletBalance, 0) }}
                </h2>

                <p class="mt-1 text-xs text-[#8291a8]">
                    All student wallets
                </p>

            </a>


            {{-- Pending --}}
            <a
                href="{{ route('admin.fee-wallet-report') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition duration-200 hover:-translate-y-0.5 hover:border-[#fecdd3] hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fff1f2] text-[#e11d48]">
                        <i data-lucide="circle-alert" class="h-5 w-5"></i>
                    </div>

                    <div class="rounded-lg bg-[#fff5f6] p-1.5 text-[#e11d48]">
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </div>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                    Pending Fees
                </p>

                <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#111827]">
                    ₹{{ number_format($pendingFeeAmount, 0) }}
                </h2>

                <p class="mt-1 text-xs text-[#8291a8]">
                    Amount currently due
                </p>

            </a>


            {{-- Paid --}}
            <a
                href="{{ route('admin.fee-wallet-report') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition duration-200 hover:-translate-y-0.5 hover:border-[#bbf7d0] hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ecfdf3] text-[#0caf55]">
                        <i data-lucide="badge-check" class="h-5 w-5"></i>
                    </div>

                    <div class="rounded-lg bg-[#f0fdf4] p-1.5 text-[#0caf55]">
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </div>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                    Paid This Month
                </p>

                <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#111827]">
                    ₹{{ number_format($paidThisMonth, 0) }}
                </h2>

                <p class="mt-1 text-xs text-[#8291a8]">
                    Fee collections
                </p>

            </a>


            {{-- Fee Plans --}}
            <a
                href="{{ route('admin.fees.index') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition duration-200 hover:-translate-y-0.5 hover:border-[#ddd6fe] hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f3f0ff] text-[#7c3aed]">
                        <i data-lucide="badge-dollar-sign" class="h-5 w-5"></i>
                    </div>

                    <div class="rounded-lg bg-[#f5f3ff] p-1.5 text-[#7c3aed]">
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </div>

                </div>

                <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                    Fee Plans
                </p>

                <h2 class="mt-1 text-2xl font-extrabold tracking-tight text-[#111827]">
                    {{ $feeCount }}
                </h2>

                <p class="mt-1 text-xs text-[#8291a8]">
                    Monthly plans
                </p>

            </a>

        </div>



        {{-- =========================================================
             MAIN STATS
        ========================================================== --}}
        <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Students --}}
            <a
                href="{{ route('admin.student.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#eef6ff]"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eef6ff] text-[#2874b9]">
                            <i data-lucide="users" class="h-6 w-6"></i>
                        </div>

                        <i
                            data-lucide="arrow-up-right"
                            class="h-5 w-5 text-[#b6c0cd] transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </div>

                    <p class="mt-5 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                        Total Students
                    </p>

                    <p class="mt-1 text-3xl font-extrabold tracking-tight text-[#111827]">
                        {{ $studentCount }}
                    </p>

                    <div class="mt-3 flex items-center gap-2 text-xs">

                        <span class="rounded-full bg-[#ecfdf3] px-2 py-1 font-semibold text-[#0caf55]">
                            {{ $activeStudentCount }} active
                        </span>

                        <span class="text-[#98a2b3]">
                            students
                        </span>

                    </div>

                </div>

            </a>


            {{-- Libraries --}}
            <a
                href="{{ route('admin.library.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#ecfdf3]"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#ecfdf3] text-[#0caf55]">
                            <i data-lucide="library" class="h-6 w-6"></i>
                        </div>

                        <i
                            data-lucide="arrow-up-right"
                            class="h-5 w-5 text-[#b6c0cd] transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-[#0caf55]"
                        ></i>

                    </div>

                    <p class="mt-5 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                        Libraries
                    </p>

                    <p class="mt-1 text-3xl font-extrabold tracking-tight text-[#111827]">
                        {{ $libraryCount }}
                    </p>

                    <div class="mt-3 flex items-center gap-2 text-xs text-[#8291a8]">
                        <i data-lucide="map-pin" class="h-3.5 w-3.5"></i>
                        Total library locations
                    </div>

                </div>

            </a>


            {{-- Seats --}}
            <a
                href="{{ route('admin.seat.index') }}"
                class="group relative overflow-hidden rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(16,24,40,0.07)] cursor-pointer"
            >

                <div class="absolute right-0 top-0 h-24 w-24 rounded-bl-full bg-[#eff8ff]"></div>

                <div class="relative">

                    <div class="flex items-center justify-between">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eff8ff] text-[#1683df]">
                            <i data-lucide="armchair" class="h-6 w-6"></i>
                        </div>

                        <i
                            data-lucide="arrow-up-right"
                            class="h-5 w-5 text-[#b6c0cd] transition group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-[#1683df]"
                        ></i>

                    </div>

                    <p class="mt-5 text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                        Total Seats
                    </p>

                    <p class="mt-1 text-3xl font-extrabold tracking-tight text-[#111827]">
                        {{ $seatCount }}
                    </p>

                    <div class="mt-3 flex items-center gap-2 text-xs">

                        <span class="rounded-full bg-[#ecfdf3] px-2 py-1 font-semibold text-[#0caf55]">
                            {{ $availableSeatCount }} available
                        </span>

                        <span class="rounded-full bg-[#fff1f2] px-2 py-1 font-semibold text-[#e11d48]">
                            {{ $occupiedSeatCount }} occupied
                        </span>

                    </div>

                </div>

            </a>

        </div>



        {{-- =========================================================
             OCCUPANCY + QUICK ACTIONS
        ========================================================== --}}
        <div class="mb-5 grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1.4fr)_minmax(320px,0.6fr)]">


            {{-- Occupancy --}}
            <div class="rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] sm:p-6">

                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                            <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#27364b]">
                                Seat Occupancy
                            </h3>

                            <p class="mt-0.5 text-xs text-[#91a0b3]">
                                Current seat utilization
                            </p>
                        </div>

                    </div>

                    <a
                        href="{{ route('admin.seat.index') }}"
                        class="text-xs font-semibold text-[#2874b9] hover:text-[#205f98] cursor-pointer"
                    >
                        View seats
                    </a>

                </div>


                @php
                    $occupancyPercent = $seatCount > 0
                        ? round(($occupiedSeatCount / $seatCount) * 100)
                        : 0;

                    $occupancyPercent = min(100, max(0, $occupancyPercent));
                @endphp


                <div class="mt-7">

                    <div class="flex items-end justify-between gap-4">

                        <div>
                            <p class="text-4xl font-extrabold tracking-tight text-[#111827]">
                                {{ $occupancyPercent }}%
                            </p>

                            <p class="mt-1 text-xs text-[#8291a8]">
                                Overall occupancy
                            </p>
                        </div>

                        <div class="text-right">

                            <p class="text-sm font-bold text-[#344054]">
                                {{ $occupiedSeatCount }} / {{ $seatCount }}
                            </p>

                            <p class="text-[11px] text-[#98a2b3]">
                                seats occupied
                            </p>

                        </div>

                    </div>


                    <div class="mt-5 h-3 overflow-hidden rounded-full bg-[#edf1f5]">

                        <div
                            class="h-full rounded-full bg-gradient-to-r from-[#2874b9] to-[#4b91d1] transition-all"
                            style="width: {{ $occupancyPercent }}%"
                        ></div>

                    </div>


                    <div class="mt-4 grid grid-cols-2 gap-3">

                        <a
                            href="{{ route('admin.seat.index', ['status' => 'occupied']) }}"
                            class="flex items-center justify-between rounded-xl bg-[#fff5f6] px-4 py-3 transition hover:bg-[#fff0f2] cursor-pointer"
                        >

                            <div class="flex items-center gap-2">

                                <span class="h-2.5 w-2.5 rounded-full bg-[#f43f5e]"></span>

                                <span class="text-xs font-semibold text-[#667085]">
                                    Occupied
                                </span>

                            </div>

                            <span class="text-sm font-bold text-[#111827]">
                                {{ $occupiedSeatCount }}
                            </span>

                        </a>


                        <a
                            href="{{ route('admin.seat.index', ['status' => 'available']) }}"
                            class="flex items-center justify-between rounded-xl bg-[#f0fdf4] px-4 py-3 transition hover:bg-[#eafbf0] cursor-pointer"
                        >

                            <div class="flex items-center gap-2">

                                <span class="h-2.5 w-2.5 rounded-full bg-[#16a34a]"></span>

                                <span class="text-xs font-semibold text-[#667085]">
                                    Available
                                </span>

                            </div>

                            <span class="text-sm font-bold text-[#111827]">
                                {{ $availableSeatCount }}
                            </span>

                        </a>

                    </div>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] sm:p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                        <i data-lucide="zap" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-[#27364b]">
                            Quick Actions
                        </h3>

                        <p class="mt-0.5 text-xs text-[#91a0b3]">
                            Common management tasks
                        </p>
                    </div>

                </div>


                <div class="mt-5 space-y-2.5">

                    {{-- Students --}}
                    <a
                        href="{{ route('admin.student.index') }}"
                        class="group flex items-center justify-between rounded-xl border border-[#edf0f4] px-3.5 py-3 transition hover:border-[#d8e7f4] hover:bg-[#f8fbfe] cursor-pointer"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                                <i data-lucide="users" class="h-4 w-4"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#344054]">
                                Manage Students
                            </span>

                        </div>

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </a>


                    {{-- Seats --}}
                    <a
                        href="{{ route('admin.seat.index') }}"
                        class="group flex items-center justify-between rounded-xl border border-[#edf0f4] px-3.5 py-3 transition hover:border-[#d8e7f4] hover:bg-[#f8fbfe] cursor-pointer"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eff8ff] text-[#1683df]">
                                <i data-lucide="armchair" class="h-4 w-4"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#344054]">
                                Manage Seats
                            </span>

                        </div>

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </a>


                    {{-- Existing Wallet & Fees Report --}}
                    <a
                        href="{{ route('admin.fee-wallet-report') }}"
                        class="group flex items-center justify-between rounded-xl border border-[#edf0f4] px-3.5 py-3 transition hover:border-[#d8e7f4] hover:bg-[#f8fbfe] cursor-pointer"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f3f0ff] text-[#7c3aed]">
                                <i data-lucide="wallet" class="h-4 w-4"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#344054]">
                                Wallet & Fees Report
                            </span>

                        </div>

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </a>


                    {{-- NEW All Student History --}}
                    <a
                        href="{{ route('admin.all-student-history') }}"
                        class="group flex items-center justify-between rounded-xl border border-[#cfe2f2] bg-[#f5faff] px-3.5 py-3 transition hover:border-[#b9d6eb] hover:bg-[#eef7ff] cursor-pointer"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#2874b9] text-white shadow-sm">
                                <i data-lucide="history" class="h-4 w-4"></i>
                            </div>

                            <div>
                                <span class="block text-sm font-semibold text-[#344054]">
                                    All Student History
                                </span>

                                <span class="block text-[11px] text-[#8291a8]">
                                    Wallet & fee transactions
                                </span>
                            </div>

                        </div>

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </a>


                    {{-- Libraries --}}
                    <a
                        href="{{ route('admin.library.index') }}"
                        class="group flex items-center justify-between rounded-xl border border-[#edf0f4] px-3.5 py-3 transition hover:border-[#d8e7f4] hover:bg-[#f8fbfe] cursor-pointer"
                    >

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#ecfdf3] text-[#0caf55]">
                                <i data-lucide="library" class="h-4 w-4"></i>
                            </div>

                            <span class="text-sm font-semibold text-[#344054]">
                                Manage Libraries
                            </span>

                        </div>

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:translate-x-0.5 group-hover:text-[#2874b9]"
                        ></i>

                    </a>

                </div>

            </div>

        </div>



        {{-- =========================================================
             7 DAY FEE COLLECTION
        ========================================================== --}}
        <div class="mb-5 rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] sm:p-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                        <i data-lucide="chart-line" class="h-5 w-5"></i>
                    </div>

                    <div>

                        <h3 class="text-base font-bold text-[#27364b]">
                            7-Day Fees Collection
                        </h3>

                        <p class="mt-0.5 text-xs text-[#91a0b3]">
                            Daily fee collection overview
                        </p>

                    </div>

                </div>


                <div class="flex items-center gap-3">

                    <div class="text-right">

                        <p class="text-lg font-extrabold text-[#111827]">
                            ₹{{ number_format($feeChart->sum('amount'), 2) }}
                        </p>

                        <p class="text-[11px] text-[#98a2b3]">
                            Last 7 days
                        </p>

                    </div>

                    <div class="hidden h-10 w-px bg-[#edf0f4] sm:block"></div>

                    <div class="hidden rounded-xl bg-[#f4f9ff] px-3 py-2 sm:block">

                        <p class="text-[10px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                            Average
                        </p>

                        <p class="text-xs font-bold text-[#2874b9]">
                            ₹{{ number_format($feeChart->count() ? $feeChart->sum('amount') / $feeChart->count() : 0, 2) }}
                        </p>

                    </div>

                </div>

            </div>


            @php

                $maxAmount = max(
                    1,
                    $feeChart->max('amount')
                );

                $chartCount = $feeChart->count();

                $step = $chartCount > 1
                    ? 700 / ($chartCount - 1)
                    : 0;

            @endphp


            <div class="relative mt-8 h-[260px]">

                {{-- Grid --}}
                <div class="absolute inset-x-0 top-0 border-t border-dashed border-[#e7ebf0]"></div>
                <div class="absolute inset-x-0 top-1/4 border-t border-dashed border-[#e7ebf0]"></div>
                <div class="absolute inset-x-0 top-1/2 border-t border-dashed border-[#e7ebf0]"></div>
                <div class="absolute inset-x-0 top-3/4 border-t border-dashed border-[#e7ebf0]"></div>
                <div class="absolute inset-x-0 bottom-0 border-t border-dashed border-[#e7ebf0]"></div>


                {{-- Y Axis --}}
                <div class="absolute left-0 top-0 text-[10px] font-medium text-[#98a2b3]">
                    ₹{{ number_format($maxAmount, 0) }}
                </div>

                <div class="absolute left-0 top-1/4 -translate-y-1/2 text-[10px] text-[#98a2b3]">
                    ₹{{ number_format($maxAmount * 0.75, 0) }}
                </div>

                <div class="absolute left-0 top-1/2 -translate-y-1/2 text-[10px] text-[#98a2b3]">
                    ₹{{ number_format($maxAmount * 0.50, 0) }}
                </div>

                <div class="absolute left-0 top-3/4 -translate-y-1/2 text-[10px] text-[#98a2b3]">
                    ₹{{ number_format($maxAmount * 0.25, 0) }}
                </div>

                <div class="absolute bottom-0 left-0 text-[10px] font-medium text-[#98a2b3]">
                    ₹0
                </div>


                {{-- SVG --}}
                <div class="absolute bottom-0 left-12 right-0 top-0">

                    <svg
                        viewBox="0 0 700 240"
                        preserveAspectRatio="none"
                        class="h-full w-full"
                    >

                        @php

                            $points = [];

                            foreach ($feeChart as $index => $item) {

                                $x = $index * $step;

                                $amount = (float) $item['amount'];

                                $y = 220 - (
                                    ($amount / $maxAmount) * 200
                                );

                                $points[] =
                                    round($x, 2) .
                                    ',' .
                                    round($y, 2);
                            }

                        @endphp


                        {{-- Area --}}
                        @if(count($points) > 1)

                            @php
                                $areaPoints = '0,240 ' .
                                    implode(' ', $points) .
                                    ' 700,240';
                            @endphp

                            <polygon
                                points="{{ $areaPoints }}"
                                fill="#2874b9"
                                opacity="0.06"
                            />

                        @endif


                        {{-- Line --}}
                        @if(count($points) > 1)

                            <polyline
                                points="{{ implode(' ', $points) }}"
                                fill="none"
                                stroke="#2874b9"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                        @endif


                        {{-- Points --}}
                        @foreach($feeChart as $index => $item)

                            @php

                                $x = $index * $step;

                                $amount = (float) $item['amount'];

                                $y = 220 - (
                                    ($amount / $maxAmount) * 200
                                );

                            @endphp

                            <circle
                                cx="{{ $x }}"
                                cy="{{ $y }}"
                                r="5"
                                fill="white"
                                stroke="#2874b9"
                                stroke-width="3"
                            />

                        @endforeach

                    </svg>

                </div>


                {{-- X Axis --}}
                <div class="absolute bottom-[-32px] left-12 right-0 flex justify-between">

                    @foreach($feeChart as $item)

                        <div class="text-center">

                            <div class="text-[10px] font-semibold text-[#667085]">
                                {{ $item['date']->format('D') }}
                            </div>

                            <div class="mt-0.5 text-[9px] text-[#a4adba]">
                                {{ $item['date']->format('d M') }}
                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>



        {{-- =========================================================
             QUICK OVERVIEW
        ========================================================== --}}
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">


            {{-- Pending Fees --}}
            <a
                href="{{ route('admin.fee-wallet-report') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                            Pending Fees
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            ₹{{ number_format($pendingFeeAmount, 0) }}
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff7e8] text-[#f59e0b]">
                        <i data-lucide="clock-3" class="h-5 w-5"></i>
                    </div>

                </div>

                <div class="mt-4 flex items-center justify-between border-t border-[#edf0f4] pt-4">

                    <span class="text-xs text-[#8291a8]">
                        Amount currently due
                    </span>

                    <span class="flex items-center gap-1 text-xs font-semibold text-[#2874b9] group-hover:underline">
                        View report
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </span>

                </div>

            </a>


            {{-- Active Students --}}
            <a
                href="{{ route('admin.student.index') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                            Active Students
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            {{ $activeStudentCount }}
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3f0ff] text-[#7c3aed]">
                        <i data-lucide="user-round-check" class="h-5 w-5"></i>
                    </div>

                </div>

                <div class="mt-4 flex items-center justify-between border-t border-[#edf0f4] pt-4">

                    <span class="text-xs text-[#8291a8]">
                        Currently assigned
                    </span>

                    <span class="flex items-center gap-1 text-xs font-semibold text-[#2874b9] group-hover:underline">
                        View students
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </span>

                </div>

            </a>


            {{-- Total Wallet --}}
            <a
                href="{{ route('admin.fee-wallet-report') }}"
                class="group rounded-2xl border border-[#e3e8ef] bg-white p-5 shadow-[0_2px_8px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md cursor-pointer"
            >

                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                            Total Wallet
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            ₹{{ number_format($totalWalletBalance, 0) }}
                        </p>
                    </div>

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                        <i data-lucide="wallet-cards" class="h-5 w-5"></i>
                    </div>

                </div>

                <div class="mt-4 flex items-center justify-between border-t border-[#edf0f4] pt-4">

                    <span class="text-xs text-[#8291a8]">
                        Across all students
                    </span>

                    <span class="flex items-center gap-1 text-xs font-semibold text-[#2874b9] group-hover:underline">
                        Open wallet report
                        <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                    </span>

                </div>

            </a>


        </div>


    </main>

</div>


{{-- =========================================================
     ICON INITIALIZATION
========================================================= --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endpush

@endsection
