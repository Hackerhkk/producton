<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

    <title>
        Dashboard - {{ config('app.name', 'Library Management') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

@php

$user = auth()->user();

$subscription = $user
    ->latestSubscription()
    ->with('plan')
    ->first();

$subscriptionActive =
    $subscription &&
    $subscription->status === 'active' &&
    $subscription->expires_at &&
    $subscription->expires_at->isFuture() &&
    $subscription->plan &&
    $subscription->plan->tests_access;

$daysRemaining = $subscriptionActive
    ? max(0, now()->diffInDays($subscription->expires_at))
    : 0;

@endphp


<body class="min-h-screen bg-[#f7f9fc] text-[#1f2937]">


{{-- ================= DESKTOP / TABLET NAVBAR ================= --}}
{{-- 640px and above --}}
<nav class="hidden sm:block px-4 pt-4 sm:px-6 lg:px-8">

    <div class="mx-auto flex h-[68px] max-w-7xl items-center justify-between rounded-2xl border border-[#e4e8ef] bg-white/95 px-4 shadow-[0_8px_30px_rgba(16,24,40,0.06)] backdrop-blur-md sm:px-5">

        {{-- ================= LOGO ================= --}}
        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 cursor-pointer"
        >
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff]">
                <i
                    data-lucide="layout-dashboard"
                    class="h-5 w-5 text-[#2874b9]"
                ></i>
            </div>

            <div>
                <p class="text-sm font-bold text-[#111827]">
                    {{ config('app.name', 'Library Management') }}
                </p>

                <p class="text-[11px] text-[#98a2b3]">
                    User Dashboard
                </p>
            </div>
        </a>


        {{-- ================= NAVIGATION ================= --}}
        <div class="flex items-center gap-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#2874b9] transition hover:bg-[#eef6ff] cursor-pointer"
            >
                <i data-lucide="home" class="h-4 w-4"></i>
                Dashboard
            </a>


            {{-- Tests --}}
            <a
                href="{{ route('student.tests.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="file-question" class="h-4 w-4"></i>
                Tests
            </a>


            {{-- Plans --}}
            <a
                href="{{ route('subscription.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="credit-card" class="h-4 w-4"></i>
                Plans
            </a>


            {{-- Short URL --}}
            <a
                href="{{ route('short-url.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="link-2" class="h-4 w-4"></i>
                Short URL
            </a>


            {{-- Profile --}}
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="user-round" class="h-4 w-4"></i>
                Profile
            </a>


            {{-- Logout --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="ml-1 flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                >
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                    
                </button>
            </form>

        </div>

    </div>

</nav>

<!-- =========================================================
     MAIN
========================================================= -->

<main
    class="mx-auto max-w-7xl px-4 py-6 pb-28 sm:px-6 sm:py-8 sm:pb-8 lg:px-8"
>


    <!-- =====================================================
         HERO
    ====================================================== -->

    <section
        class="relative mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm sm:mb-8"
    >

        <div
            class="absolute -right-20 -top-24 h-64 w-64 rounded-full bg-[#eef6ff]"
        ></div>

        <div
            class="absolute -bottom-32 -left-20 h-64 w-64 rounded-full bg-[#f5f9ff]"
        ></div>


        <div
            class="relative grid gap-8 px-5 py-7 sm:px-8 sm:py-8 lg:grid-cols-[1fr_auto] lg:items-center lg:px-10 lg:py-10"
        >

            <div>


                <div
                    class="mb-4 inline-flex items-center gap-2 rounded-full border border-[#dbeafe] bg-[#f4f9ff] px-3 py-1.5 text-[10px] font-bold uppercase tracking-wide text-[#2874b9] sm:text-[11px]"
                >

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-[#2874b9]"
                    ></span>

                    User Dashboard

                </div>


                <h1
                    class="max-w-2xl text-2xl font-bold tracking-tight text-[#111827] sm:text-4xl"
                >

                    Welcome back,

                    <span class="text-[#2874b9]">
                        {{ $user->name }}
                    </span>

                </h1>


                <p
                    class="mt-3 max-w-xl text-sm leading-6 text-[#667085] sm:text-base"
                >

                    Manage your library services, tests, subscription
                    and account from one simple dashboard.

                </p>


                <div class="mt-5 flex flex-wrap gap-3">


                    <a
                        href="{{ route('student.tests.index') }}"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#22669f]"
                    >

                        @if($subscriptionActive)

                            <i
                                data-lucide="play-circle"
                                class="h-4 w-4"
                            ></i>

                            Start Tests

                        @else

                            <i
                                data-lucide="clipboard-check"
                                class="h-4 w-4"
                            ></i>

                            All Test Series

                        @endif

                    </a>


                    <a
                        href="{{ route('short-url.index') }}"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#dfe4ea] bg-white px-4 py-2.5 text-sm font-semibold text-[#475467] transition hover:border-[#2874b9]/30 hover:bg-[#f8fbff] hover:text-[#2874b9]"
                    >

                        <i
                            data-lucide="link-2"
                            class="h-4 w-4"
                        ></i>

                        Short URLs

                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         SERVICES
    ====================================================== -->

    <section class="mb-6 sm:mb-8">

        <div class="mb-4">

            <h2 class="text-lg font-bold text-[#111827]">
                Services
            </h2>

            <p class="mt-1 text-sm text-[#667085]">
                Quick access to your services.
            </p>

        </div>


        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


            <!-- TESTS -->

            <a
                href="{{ route('student.tests.index') }}"
                class="group cursor-pointer rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#2874b9]/30 hover:shadow-md"
            >

                <div class="flex items-center justify-between">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                    >

                        <i
                            data-lucide="clipboard-check"
                            class="h-5 w-5"
                        ></i>

                    </div>

                    <i
                        data-lucide="arrow-up-right"
                        class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                    ></i>

                </div>


                <h3 class="mt-5 text-base font-bold text-[#111827]">
                    Tests
                </h3>

                <p class="mt-1.5 text-sm leading-5 text-[#667085]">
                    View and start your available tests.
                </p>

            </a>


            <!-- SUBSCRIPTION -->

            <a
                href="{{ route('subscription.index') }}"
                class="group cursor-pointer rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#2874b9]/30 hover:shadow-md"
            >

                <div class="flex items-center justify-between">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fff7ed] text-orange-600"
                    >

                        <i
                            data-lucide="crown"
                            class="h-5 w-5"
                        ></i>

                    </div>

                    <i
                        data-lucide="arrow-up-right"
                        class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                    ></i>

                </div>


                <h3 class="mt-5 text-base font-bold text-[#111827]">
                    Subscription
                </h3>

                <p class="mt-1.5 text-sm leading-5 text-[#667085]">
                    View plans and manage test access.
                </p>

            </a>


            <!-- SHORT URL -->

            <a
                href="{{ route('short-url.index') }}"
                class="group cursor-pointer rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#2874b9]/30 hover:shadow-md"
            >

                <div class="flex items-center justify-between">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f0fdf4] text-green-600"
                    >

                        <i
                            data-lucide="link-2"
                            class="h-5 w-5"
                        ></i>

                    </div>

                    <i
                        data-lucide="arrow-up-right"
                        class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                    ></i>

                </div>


                <h3 class="mt-5 text-base font-bold text-[#111827]">
                    Short URL
                </h3>

                <p class="mt-1.5 text-sm leading-5 text-[#667085]">
                    Create and manage your short links.
                </p>

            </a>


            <!-- PROFILE -->

            <a
                href="{{ route('profile.edit') }}"
                class="group cursor-pointer rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-[#2874b9]/30 hover:shadow-md"
            >

                <div class="flex items-center justify-between">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f5f3ff] text-purple-600"
                    >

                        <i
                            data-lucide="user-round"
                            class="h-5 w-5"
                        ></i>

                    </div>

                    <i
                        data-lucide="arrow-up-right"
                        class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                    ></i>

                </div>


                <h3 class="mt-5 text-base font-bold text-[#111827]">
                    My Profile
                </h3>

                <p class="mt-1.5 text-sm leading-5 text-[#667085]">
                    Update your account information.
                </p>

            </a>

        </div>

    </section>


    <!-- =====================================================
         SHORT URL STATISTICS
    ====================================================== -->

    <section class="mb-6 sm:mb-8">

        <div class="mb-4">

            <h2 class="text-lg font-bold text-[#111827]">
                Short URL Overview
            </h2>

            <p class="mt-1 text-sm text-[#667085]">
                Your short link activity at a glance.
            </p>

        </div>


        <div class="grid gap-4 sm:grid-cols-3">


            <!-- TOTAL URLS -->

            <div
                class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
            >

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                    >

                        <i
                            data-lucide="link-2"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <div>

                        <p class="text-xs font-semibold text-[#667085]">
                            Total Short URLs
                        </p>

                        <p class="mt-0.5 text-2xl font-bold text-[#111827]">
                            {{ number_format($shortUrlCount) }}
                        </p>

                    </div>

                </div>

            </div>


            <!-- TOTAL CLICKS -->

            <div
                class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
            >

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f0fdf4] text-green-600"
                    >

                        <i
                            data-lucide="mouse-pointer-click"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <div>

                        <p class="text-xs font-semibold text-[#667085]">
                            Total Clicks
                        </p>

                        <p class="mt-0.5 text-2xl font-bold text-[#111827]">
                            {{ number_format($shortUrlClicks) }}
                        </p>

                    </div>

                </div>

            </div>


            <!-- TODAY -->

            <div
                class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
            >

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff7ed] text-orange-600"
                    >

                        <i
                            data-lucide="calendar-check"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <div>

                        <p class="text-xs font-semibold text-[#667085]">
                            Today's Clicks
                        </p>

                        <p class="mt-0.5 text-2xl font-bold text-[#111827]">
                            {{ number_format($todayShortUrlClicks) }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =====================================================
         ACCOUNT
    ====================================================== -->

    <section
        class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm"
    >

        <div
            class="flex items-center justify-between border-b border-[#edf0f4] px-5 py-4 sm:px-6"
        >

            <div class="flex items-center gap-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                >

                    <i
                        data-lucide="circle-user-round"
                        class="h-5 w-5"
                    ></i>

                </div>


                <div>

                    <h2 class="text-sm font-bold text-[#111827]">
                        Account Information
                    </h2>

                    <p class="mt-0.5 text-xs text-[#667085]">
                        Your registered account details.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('profile.edit') }}"
                class="cursor-pointer text-xs font-bold text-[#2874b9] hover:underline"
            >
                Edit Profile
            </a>

        </div>


        <div class="grid gap-4 p-5 sm:grid-cols-3 sm:p-6">


            <!-- NAME -->

            <div
                class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4"
            >

                <div
                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wide text-[#98a2b3]"
                >

                    <i
                        data-lucide="user"
                        class="h-3.5 w-3.5"
                    ></i>

                    Name

                </div>


                <p
                    class="mt-2 truncate text-sm font-bold text-[#111827]"
                >
                    {{ $user->name }}
                </p>

            </div>


            <!-- EMAIL -->

            <div
                class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4"
            >

                <div
                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wide text-[#98a2b3]"
                >

                    <i
                        data-lucide="mail"
                        class="h-3.5 w-3.5"
                    ></i>

                    Email

                </div>


                <p
                    class="mt-2 truncate text-sm font-bold text-[#111827]"
                >
                    {{ $user->email }}
                </p>

            </div>


            <!-- STATUS -->

            <div
                class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4"
            >

                <div
                    class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-wide text-[#98a2b3]"
                >

                    <i
                        data-lucide="shield-check"
                        class="h-3.5 w-3.5"
                    ></i>

                    Account Status

                </div>


                <div class="mt-2 flex items-center gap-2">

                    <span
                        class="h-2.5 w-2.5 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-red-500' }}"
                    ></span>

                    <span
                        class="text-sm font-bold {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}"
                    >
                        {{ $user->is_active ? 'Active' : 'Disabled' }}
                    </span>

                </div>

            </div>

        </div>

    </section>


</main>


<!-- =========================================================
     MOBILE BOTTOM NAVIGATION
========================================================= -->

<nav
    class="fixed inset-x-0 bottom-0 z-50 border-t border-[#e4e8ef] bg-white/95 px-2 pb-[env(safe-area-inset-bottom)] pt-2 shadow-[0_-10px_30px_rgba(16,24,40,0.08)] backdrop-blur-md sm:hidden"
>

    <div class="mx-auto grid max-w-md grid-cols-5">


        <!-- HOME -->

        <a
            href="{{ route('dashboard') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#2874b9] transition active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#eef6ff]"
            >

                <i
                    data-lucide="home"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-bold">
                Home
            </span>

        </a>


        <!-- TESTS -->

        <a
            href="{{ route('student.tests.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="clipboard-check"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Tests
            </span>

        </a>


        <!-- SUBSCRIPTION -->

        <a
            href="{{ route('subscription.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="crown"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Plans
            </span>

        </a>


        <!-- SHORT URL -->

        <a
            href="{{ route('short-url.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="link-2"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Links
            </span>

        </a>


        <!-- PROFILE -->

        <a
            href="{{ route('profile.edit') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="user-round"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Profile
            </span>

        </a>

    </div>

</nav>


<!-- =========================================================
     LUCIDE
========================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});

</script>


</body>

</html>
