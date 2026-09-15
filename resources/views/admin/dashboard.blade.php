@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="min-h-screen lg:pl-[10px]">

    <main class="px-4 py-6 sm:px-6 lg:px-7">

        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-[28px] font-extrabold tracking-tight text-[#111827] sm:text-[30px]">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-[#8291a8]">
                    Welcome back,
                    <span class="font-semibold text-[#65758c]">
                        {{ auth()->user()->name }}
                    </span>
                    Here's what's happening with your library today.
                </p>

            </div>

        </div>


        <!-- =================================================
             TOP STAT CARDS
        ================================================== -->

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">


            <!-- Students -->
            <a href="{{ route('admin.student.index') }}"
               class="stat-card block">

                <div class="icon-box bg-[#e7f1fb] text-[#347ec0]">
                    <i data-lucide="users"></i>
                </div>

                <p class="stat-title">
                    Students
                </p>

                <h2 class="stat-number">
                    {{ $studentCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        {{ $activeStudentCount }} active
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Libraries -->
            <a href="{{ route('admin.library.index') }}"
               class="stat-card block">

                <div class="icon-box bg-[#dcfce7] text-[#0caf55]">
                    <i data-lucide="library"></i>
                </div>

                <p class="stat-title">
                    Libraries
                </p>

                <h2 class="stat-number">
                    {{ $libraryCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Total libraries
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Total Seats -->
            <a href="{{ route('admin.seat.index') }}"
               class="stat-card block">

                <div class="icon-box bg-[#e0f2fe] text-[#1683df]">
                    <i data-lucide="armchair"></i>
                </div>

                <p class="stat-title">
                    Total Seats
                </p>

                <h2 class="stat-number">
                    {{ $seatCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        {{ $occupiedSeatCount }} occupied
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Occupied Seats -->
            <a href="{{ route('admin.seat.index', ['status' => 'occupied']) }}" class="stat-card block">

                <div class="icon-box bg-[#ffe4e6] text-[#f43f5e]">
                    <i data-lucide="user-check"></i>
                </div>

                <p class="stat-title">
                    Occupied Seats
                </p>

                <h2 class="stat-number">
                    {{ $occupiedSeatCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Currently occupied
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Available Seats -->
           <a href="{{ route('admin.seat.index', ['status' => 'available']) }}"
   class="stat-card block">

                <div class="icon-box bg-[#fef3c7] text-[#f59e0b]">
                    <i data-lucide="armchair"></i>
                </div>

                <p class="stat-title">
                    Available Seats
                </p>

                <h2 class="stat-number">
                    {{ $availableSeatCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Ready for assignment
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Fee Plans -->
            <a href="{{ route('admin.fees.index') }}"
               class="stat-card block">

                <div class="icon-box bg-[#ede9fe] text-[#7c3aed]">
                    <i data-lucide="badge-dollar-sign"></i>
                </div>

                <p class="stat-title">
                    Fee Plans
                </p>

                <h2 class="stat-number">
                    {{ $feeCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Monthly plans
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>

        </div>


        <!-- =================================================
             SECOND ROW
        ================================================== -->

        <div class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-4">


            <!-- Wallet Balance -->
            <a href="{{ route('admin.fee-wallet-report') }}"
               class="large-stat-card block">

                <div class="icon-box bg-[#e7f1fb] text-[#347ec0]">
                    <i data-lucide="wallet"></i>
                </div>

                <p class="stat-title">
                    WALLET BALANCE
                </p>

                <h2 class="stat-number">
                    ₹{{ number_format($totalWalletBalance, 0) }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        All student wallets
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Pending Fees -->
            <a href="{{ route('admin.fee-wallet-report') }}"
               class="large-stat-card block">

                <div class="icon-box bg-[#ffe4e6] text-[#f43f5e]">
                    <i data-lucide="circle-alert"></i>
                </div>

                <p class="stat-title">
                    PENDING FEES
                </p>

                <h2 class="stat-number">
                    ₹{{ number_format($pendingFeeAmount, 0) }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Amount currently due
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Paid This Month -->
            <a href="{{ route('admin.fee-wallet-report') }}"
               class="large-stat-card block">

                <div class="icon-box bg-[#dcfce7] text-[#0caf55]">
                    <i data-lucide="badge-check"></i>
                </div>

                <p class="stat-title">
                    PAID THIS MONTH
                </p>

                <h2 class="stat-number">
                    ₹{{ number_format($paidThisMonth, 0) }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Fee collections
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>


            <!-- Active Students -->
            <a href="{{ route('admin.student.index') }}"
               class="large-stat-card block">

                <div class="icon-box bg-[#ede9fe] text-[#7c3aed]">
                    <i data-lucide="user-round-check"></i>
                </div>

                <p class="stat-title">
                    ACTIVE STUDENTS
                </p>

                <h2 class="stat-number">
                    {{ $activeStudentCount }}
                </h2>

                <div class="stat-bottom">
                    <span>
                        Currently assigned
                    </span>

                    <i data-lucide="chevron-right"></i>
                </div>

            </a>

        </div>


        <!-- =================================================
             CHART + QUICK STATS
        ================================================== -->

        <div class="mt-6 grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1.7fr)_minmax(340px,0.7fr)]">


            <!-- =================================================
                 7 DAY FEE COLLECTION CHART
            ================================================== -->

            <div class="rounded-2xl border border-[#e5eaf0] bg-white p-5 shadow-[0_1px_3px_rgba(16,24,40,0.03)] sm:p-6">

                <!-- Chart Header -->

                <div class="flex items-start justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#3d8bd1]">

                            <i data-lucide="wallet" class="h-5 w-5"></i>

                        </div>

                        <div>

                            <h3 class="text-base font-bold text-[#27364b]">
                                7-Day Fees Collection
                            </h3>

                            <p class="mt-0.5 text-xs text-[#91a0b3]">
                                Daily fee collection
                            </p>

                        </div>

                    </div>


                    <!-- Total -->

                    <div class="text-right">

                        <div class="text-sm font-bold text-[#27364b]">
                            ₹{{ number_format($feeChart->sum('amount'), 2) }}
                        </div>

                        <div class="mt-0.5 text-[11px] text-[#91a0b3]">
                            Last 7 days
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


                <!-- Chart Area -->

                <div class="relative mt-8 h-[250px]">


                    <!-- Grid Lines -->

                    <div class="absolute inset-x-0 top-0 border-t border-dashed border-[#e7ebf0]"></div>

                    <div class="absolute inset-x-0 top-1/4 border-t border-dashed border-[#e7ebf0]"></div>

                    <div class="absolute inset-x-0 top-1/2 border-t border-dashed border-[#e7ebf0]"></div>

                    <div class="absolute inset-x-0 top-3/4 border-t border-dashed border-[#e7ebf0]"></div>

                    <div class="absolute inset-x-0 bottom-0 border-t border-dashed border-[#e7ebf0]"></div>


                    <!-- Y Axis -->

                    <div class="absolute left-0 top-0 text-[11px] text-[#91a0b3]">
                        ₹{{ number_format($maxAmount, 0) }}
                    </div>

                    <div class="absolute left-0 top-1/4 -translate-y-1/2 text-[11px] text-[#91a0b3]">
                        ₹{{ number_format($maxAmount * 0.75, 0) }}
                    </div>

                    <div class="absolute left-0 top-1/2 -translate-y-1/2 text-[11px] text-[#91a0b3]">
                        ₹{{ number_format($maxAmount * 0.50, 0) }}
                    </div>

                    <div class="absolute left-0 top-3/4 -translate-y-1/2 text-[11px] text-[#91a0b3]">
                        ₹{{ number_format($maxAmount * 0.25, 0) }}
                    </div>

                    <div class="absolute bottom-0 left-0 text-[11px] text-[#91a0b3]">
                        ₹0
                    </div>


                    <!-- SVG Chart -->

                    <div class="absolute bottom-0 left-12 right-0 top-0">

                        <svg
                            viewBox="0 0 700 240"
                            preserveAspectRatio="none"
                            class="h-full w-full">

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


                            <!-- Chart Line -->

                            @if(count($points) > 1)

                                <polyline
                                    points="{{ implode(' ', $points) }}"
                                    fill="none"
                                    stroke="#4b91d1"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />

                            @endif


                            <!-- Chart Points -->

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
                                    stroke="#4b91d1"
                                    stroke-width="3"
                                />

                            @endforeach

                        </svg>

                    </div>


                    <!-- X Axis -->

                    <div class="absolute bottom-[-30px] left-12 right-0 flex justify-between">

                        @foreach($feeChart as $item)

                            <div class="text-center">

                                <div class="text-[10px] font-medium text-[#8291a8]">
                                    {{ $item['date']->format('D') }}
                                </div>

                                <div class="mt-0.5 text-[10px] text-[#b0bac7]">
                                    {{ $item['date']->format('d M') }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            <!-- =================================================
                 QUICK STATS
            ================================================== -->

            <div class="rounded-2xl border border-[#e5eaf0] bg-white p-5 shadow-[0_1px_3px_rgba(16,24,40,0.03)] sm:p-6">


                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#3d8bd1]">

                        <i data-lucide="activity" class="h-5 w-5"></i>

                    </div>

                    <div>

                        <h3 class="text-base font-bold text-[#27364b]">
                            Quick Stats
                        </h3>

                        <p class="text-xs text-[#91a0b3]">
                            Current library overview
                        </p>

                    </div>

                </div>


                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-1 2xl:grid-cols-2">


                    <!-- Occupied -->

                    <a href="{{ route('admin.seat.index', ['status' => 'occupied']) }}" 
                       class="rounded-xl bg-[#fff1f2] p-5 transition hover:shadow-sm">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ffe4e6] text-[#f43f5e]">

                            <i data-lucide="user-check" class="h-5 w-5"></i>

                        </div>

                        <p class="mt-4 text-3xl font-extrabold text-[#111827]">
                            {{ $occupiedSeatCount }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-[#8291a8]">
                            Occupied Seats
                        </p>

                    </a>


                    <!-- Available -->

<a href="{{ route('admin.seat.index', ['status' => 'available']) }}"
                           class="rounded-xl bg-[#effcf5] p-5 transition hover:shadow-sm">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#dcfce7] text-[#0caf55]">

                            <i data-lucide="armchair" class="h-5 w-5"></i>

                        </div>

                        <p class="mt-4 text-3xl font-extrabold text-[#111827]">
                            {{ $availableSeatCount }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-[#8291a8]">
                            Available Seats
                        </p>

                    </a>


                    <!-- Pending Fees -->

                    <a href="{{ route('admin.fee-wallet-report') }}"
                       class="rounded-xl bg-[#fff9e8] p-5 transition hover:shadow-sm">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fef3c7] text-[#f59e0b]">

                            <i data-lucide="clock-3" class="h-5 w-5"></i>

                        </div>

                        <p class="mt-4 text-3xl font-extrabold text-[#111827]">
                            ₹{{ number_format($pendingFeeAmount, 0) }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-[#8291a8]">
                            Pending Fees
                        </p>

                    </a>


                    <!-- Active Students -->

                    <a href="{{ route('admin.student.index') }}"
                       class="rounded-xl bg-[#f3f0ff] p-5 transition hover:shadow-sm">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ede9fe] text-[#7c3aed]">

                            <i data-lucide="users" class="h-5 w-5"></i>

                        </div>

                        <p class="mt-4 text-3xl font-extrabold text-[#111827]">
                            {{ $activeStudentCount }}
                        </p>

                        <p class="mt-1 text-xs font-medium text-[#8291a8]">
                            Active Students
                        </p>

                    </a>

                </div>

            </div>

        </div>


        <!-- =================================================
             RECENT SUMMARY
        ================================================== -->

        <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">


            <!-- Students -->

            <a href="{{ route('admin.student.index') }}"
               class="rounded-2xl border border-[#e5eaf0] bg-white p-5 shadow-[0_1px_3px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                            Students
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            {{ $studentCount }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#347ec0]">

                        <i data-lucide="users" class="h-5 w-5"></i>

                    </div>

                </div>

            </a>


            <!-- Libraries -->

            <a href="{{ route('admin.library.index') }}"
               class="rounded-2xl border border-[#e5eaf0] bg-white p-5 shadow-[0_1px_3px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                            Libraries
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            {{ $libraryCount }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#dcfce7] text-[#0caf55]">

                        <i data-lucide="library" class="h-5 w-5"></i>

                    </div>

                </div>

            </a>


            <!-- Wallet -->

            <a href="{{ route('admin.fee-wallet-report') }}"
               class="rounded-2xl border border-[#e5eaf0] bg-white p-5 shadow-[0_1px_3px_rgba(16,24,40,0.03)] transition hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-[#91a0b3]">
                            Total Wallet
                        </p>

                        <p class="mt-2 text-2xl font-extrabold text-[#111827]">
                            ₹{{ number_format($totalWalletBalance, 0) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#ede9fe] text-[#7c3aed]">

                        <i data-lucide="wallet" class="h-5 w-5"></i>

                    </div>

                </div>

            </a>

        </div>


    </main>

</div>


<!-- =================================================
     FLOATING CHAT BUTTON
================================================== -->

<button
    type="button"
    class="fixed bottom-5 right-5 z-30 flex h-14 w-14 items-center justify-center rounded-full bg-[#3e4766] text-white shadow-lg transition hover:scale-105">

    <i data-lucide="message-circle" class="h-7 w-7"></i>

</button>


@endsection