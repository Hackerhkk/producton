<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<title>Library Management System</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://unpkg.com/lucide@latest"></script>


</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">


{{-- ================= HEADER ================= --}}
<header class="sticky top-0 z-50 border-b border-[#e5eaf0] bg-white/95 backdrop-blur">

    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">
                <i data-lucide="library-big" class="h-5 w-5"></i>
            </div>

            <div class="hidden sm:block">
                <div class="text-[15px] font-bold tracking-tight text-[#172033]">
                    Library Management
                </div>

                <div class="text-[11px] text-[#667085]">
                    Smart Library System
                </div>
            </div>

        </a>


        {{-- Navigation --}}
        <nav class="flex items-center gap-2">

            @auth

                <a
                    href="{{ url('/dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f]"
                >
                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                    Dashboard
                </a>

            @else

                @if (Route::has('login'))

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-sm font-semibold text-[#344054] transition hover:bg-[#f2f6fa] hover:text-[#2874b9]"
                    >
                        <i data-lucide="log-in" class="h-4 w-4"></i>
                        Login
                    </a>

                @endif


                @if (Route::has('register'))

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f]"
                    >
                        <i data-lucide="user-plus" class="h-4 w-4"></i>
                        Register
                    </a>

                @endif

            @endauth

        </nav>

    </div>

</header>


{{-- ================= HERO ================= --}}
<main>

    <section class="relative overflow-hidden">

        {{-- Background decoration --}}
        <div class="pointer-events-none absolute -left-32 -top-32 h-80 w-80 rounded-full bg-[#2874b9]/10 blur-3xl"></div>

        <div class="pointer-events-none absolute -right-32 top-20 h-96 w-96 rounded-full bg-[#2874b9]/10 blur-3xl"></div>


        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 sm:px-6 sm:py-20 lg:grid-cols-2 lg:px-8 lg:py-24">

            {{-- Hero Content --}}
            <div>

                <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-semibold text-[#2874b9]">

                    <span class="h-1.5 w-1.5 rounded-full bg-[#2874b9]"></span>

                    Smart Library Management System

                </div>


                <h1 class="max-w-2xl text-4xl font-bold leading-[1.12] tracking-tight text-[#101828] sm:text-5xl lg:text-[56px]">

                    Manage Your Library

                    <span class="text-[#2874b9]">
                        Smarter.
                    </span>

                </h1>


                <p class="mt-6 max-w-xl text-base leading-7 text-[#667085] sm:text-lg">

                    Manage students, seats, monthly fees and wallets from one simple
                    and powerful library management system.

                </p>


                {{-- Buttons --}}
                <div class="mt-8 flex flex-wrap items-center gap-3">

                    @auth

                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#21659f]"
                        >
                            <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                            Open Dashboard
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>

                    @else

                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#21659f]"
                            >
                                Get Started
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </a>

                        @endif


                        @if (Route::has('login'))

                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-5 py-3 text-sm font-semibold text-[#344054] shadow-sm transition hover:border-[#2874b9] hover:text-[#2874b9]"
                            >
                                <i data-lucide="log-in" class="h-4 w-4"></i>
                                Login
                            </a>

                        @endif

                    @endauth

                </div>


                {{-- Trust --}}
                <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs text-[#667085]">

                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-green-600"></i>
                        Easy to use
                    </div>

                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="h-4 w-4 text-green-600"></i>
                        Secure
                    </div>

                    <div class="flex items-center gap-2">
                        <i data-lucide="smartphone" class="h-4 w-4 text-green-600"></i>
                        Mobile friendly
                    </div>

                </div>

            </div>


            {{-- Dashboard Preview --}}
            <div class="relative">

                <div class="absolute -inset-4 rounded-[2rem] bg-[#2874b9]/5 blur-2xl"></div>

                <div class="relative overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-[0_20px_60px_rgba(16,24,40,0.10)]">

                    {{-- Fake browser bar --}}
                    <div class="flex items-center justify-between border-b border-[#edf0f4] px-5 py-4">

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>
                            <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>

                        </div>

                        <div class="rounded-md bg-[#f5f7fa] px-3 py-1 text-[10px] text-[#98a2b3]">
                            library-admin
                        </div>

                        <i data-lucide="more-horizontal" class="h-4 w-4 text-[#98a2b3]"></i>

                    </div>


                    {{-- Dashboard preview --}}
                    <div class="p-5 sm:p-6">

                        <div class="mb-5 flex items-center justify-between">

                            <div>

                                <p class="text-xs text-[#667085]">
                                    Welcome back
                                </p>

                                <h3 class="mt-1 text-lg font-bold text-[#101828]">
                                    Library Dashboard
                                </h3>

                            </div>

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                                <i data-lucide="library" class="h-4 w-4"></i>
                            </div>

                        </div>


                        {{-- Stats --}}
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                            <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                                    <i data-lucide="users" class="h-4 w-4"></i>
                                </div>

                                <p class="mt-3 text-[10px] text-[#667085]">
                                    Students
                                </p>

                                <p class="mt-0.5 text-lg font-bold text-[#101828]">
                                    248
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                                    <i data-lucide="armchair" class="h-4 w-4"></i>
                                </div>

                                <p class="mt-3 text-[10px] text-[#667085]">
                                    Seats
                                </p>

                                <p class="mt-0.5 text-lg font-bold text-[#101828]">
                                    120
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 text-green-600">
                                    <i data-lucide="circle-check" class="h-4 w-4"></i>
                                </div>

                                <p class="mt-3 text-[10px] text-[#667085]">
                                    Available
                                </p>

                                <p class="mt-0.5 text-lg font-bold text-[#101828]">
                                    36
                                </p>

                            </div>


                            <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                    <i data-lucide="wallet" class="h-4 w-4"></i>
                                </div>

                                <p class="mt-3 text-[10px] text-[#667085]">
                                    Wallet
                                </p>

                                <p class="mt-0.5 text-lg font-bold text-[#101828]">
                                    ₹52K
                                </p>

                            </div>

                        </div>


                        {{-- Activity --}}
                        <div class="mt-5 rounded-xl border border-[#edf0f4] p-4">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-xs font-semibold text-[#344054]">
                                        Fee Collection
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-[#98a2b3]">
                                        Monthly overview
                                    </p>

                                </div>

                                <span class="rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-semibold text-green-600">
                                    +18.4%
                                </span>

                            </div>


                            {{-- Simple chart --}}
                            <div class="mt-5 flex h-24 items-end gap-2">

                                <div class="h-[35%] flex-1 rounded-t-md bg-[#dcecf8]"></div>
                                <div class="h-[48%] flex-1 rounded-t-md bg-[#c5e0f2]"></div>
                                <div class="h-[42%] flex-1 rounded-t-md bg-[#c5e0f2]"></div>
                                <div class="h-[65%] flex-1 rounded-t-md bg-[#8fc2e4]"></div>
                                <div class="h-[55%] flex-1 rounded-t-md bg-[#8fc2e4]"></div>
                                <div class="h-[78%] flex-1 rounded-t-md bg-[#2874b9]"></div>
                                <div class="h-[90%] flex-1 rounded-t-md bg-[#2874b9]"></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ================= FEATURES ================= --}}
    <section class="border-y border-[#e8edf2] bg-white">

        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-2xl text-center">

                <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#2874b9]">
                    Everything in one place
                </span>

                <h2 class="mt-3 text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
                    Everything your library needs
                </h2>

                <p class="mt-4 text-sm leading-6 text-[#667085] sm:text-base">
                    Keep your daily library operations simple, organized and under control.
                </p>

            </div>


            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Feature --}}
                <div class="group rounded-2xl border border-[#e4e8ef] bg-white p-6 transition hover:-translate-y-1 hover:border-[#b9d6eb] hover:shadow-lg">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] transition group-hover:bg-[#2874b9] group-hover:text-white">

                        <i data-lucide="users" class="h-5 w-5"></i>

                    </div>

                    <h3 class="mt-5 font-semibold text-[#1f2937]">
                        Student Management
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        Manage student profiles, documents, contact details and active assignments.
                    </p>

                </div>


                {{-- Feature --}}
                <div class="group rounded-2xl border border-[#e4e8ef] bg-white p-6 transition hover:-translate-y-1 hover:border-[#b9d6eb] hover:shadow-lg">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] transition group-hover:bg-[#2874b9] group-hover:text-white">

                        <i data-lucide="armchair" class="h-5 w-5"></i>

                    </div>

                    <h3 class="mt-5 font-semibold text-[#1f2937]">
                        Seat Management
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        Track available and occupied seats and assign students to the right library.
                    </p>

                </div>


                {{-- Feature --}}
                <div class="group rounded-2xl border border-[#e4e8ef] bg-white p-6 transition hover:-translate-y-1 hover:border-[#b9d6eb] hover:shadow-lg">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] transition group-hover:bg-[#2874b9] group-hover:text-white">

                        <i data-lucide="receipt" class="h-5 w-5"></i>

                    </div>

                    <h3 class="mt-5 font-semibold text-[#1f2937]">
                        Fee Management
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        Manage monthly plans, fee cycles, payments and student fee history easily.
                    </p>

                </div>


                {{-- Feature --}}
                <div class="group rounded-2xl border border-[#e4e8ef] bg-white p-6 transition hover:-translate-y-1 hover:border-[#b9d6eb] hover:shadow-lg">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] transition group-hover:bg-[#2874b9] group-hover:text-white">

                        <i data-lucide="wallet" class="h-5 w-5"></i>

                    </div>

                    <h3 class="mt-5 font-semibold text-[#1f2937]">
                        Wallet System
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        Maintain student wallet balances and keep every wallet transaction organized.
                    </p>

                </div>

            </div>

        </div>

    </section>


    {{-- ================= HOW IT WORKS ================= --}}
    <section>

        <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">

            <div class="grid items-center gap-12 lg:grid-cols-2">

                <div>

                    <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#2874b9]">
                        Simple workflow
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
                        Run your library with less effort
                    </h2>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-[#667085] sm:text-base">
                        From assigning a seat to managing monthly fees, everything
                        stays connected in one system.
                    </p>


                    <div class="mt-8 space-y-6">

                        {{-- Step --}}
                        <div class="flex gap-4">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#2874b9] text-sm font-bold text-white">
                                1
                            </div>

                            <div>

                                <h3 class="font-semibold text-[#1f2937]">
                                    Add your library
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-[#667085]">
                                    Create libraries and organize their available seats.
                                </p>

                            </div>

                        </div>


                        {{-- Step --}}
                        <div class="flex gap-4">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#2874b9] text-sm font-bold text-white">
                                2
                            </div>

                            <div>

                                <h3 class="font-semibold text-[#1f2937]">
                                    Add students
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-[#667085]">
                                    Store student information and assign them to seats.
                                </p>

                            </div>

                        </div>


                        {{-- Step --}}
                        <div class="flex gap-4">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#2874b9] text-sm font-bold text-white">
                                3
                            </div>

                            <div>

                                <h3 class="font-semibold text-[#1f2937]">
                                    Manage fees & wallets
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-[#667085]">
                                    Track monthly fees, wallet balances and payment history.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Info Card --}}
                <div class="relative">

                    <div class="rounded-3xl border border-[#dce7f0] bg-[#eef6ff] p-6 sm:p-8">

                        <div class="rounded-2xl border border-white/80 bg-white p-6 shadow-sm">

                            <div class="flex items-center justify-between">

                                <div>

                                    <p class="text-xs text-[#667085]">
                                        Library Overview
                                    </p>

                                    <p class="mt-1 text-2xl font-bold text-[#101828]">
                                        ₹ 52,600
                                    </p>

                                    <p class="mt-1 text-xs text-green-600">
                                        Available wallet balance
                                    </p>

                                </div>

                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                                    <i data-lucide="wallet-cards" class="h-6 w-6"></i>

                                </div>

                            </div>


                            <div class="mt-6 grid grid-cols-2 gap-3">

                                <div class="rounded-xl bg-[#f8fafc] p-4">

                                    <p class="text-xs text-[#667085]">
                                        Active Students
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-[#101828]">
                                        248
                                    </p>

                                </div>


                                <div class="rounded-xl bg-[#f8fafc] p-4">

                                    <p class="text-xs text-[#667085]">
                                        Occupied Seats
                                    </p>

                                    <p class="mt-1 text-xl font-bold text-[#101828]">
                                        84
                                    </p>

                                </div>

                            </div>


                            <div class="mt-3 flex items-center justify-between rounded-xl border border-green-100 bg-green-50 px-4 py-3">

                                <div class="flex items-center gap-2">

                                    <i data-lucide="circle-check" class="h-4 w-4 text-green-600"></i>

                                    <span class="text-xs font-medium text-green-700">
                                        System running smoothly
                                    </span>

                                </div>

                                <span class="h-2 w-2 rounded-full bg-green-500"></span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- ================= CTA ================= --}}
    <section class="bg-[#2874b9]">

        <div class="mx-auto max-w-7xl px-5 py-14 text-center sm:px-6 lg:px-8">

            <div class="mx-auto max-w-2xl">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white">

                    <i data-lucide="library-big" class="h-6 w-6"></i>

                </div>

                <h2 class="mt-5 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Ready to manage your library smarter?
                </h2>

                <p class="mt-4 text-sm leading-6 text-blue-100 sm:text-base">
                    Get started with a simple, organized and modern library management experience.
                </p>


                @guest

                    <div class="mt-7 flex flex-wrap justify-center gap-3">

                        @if (Route::has('register'))

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#2874b9] shadow-sm transition hover:bg-blue-50"
                            >
                                Create Account
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </a>

                        @endif

                        @if (Route::has('login'))

                            <a
                                href="{{ route('login') }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10"
                            >
                                Login
                            </a>

                        @endif

                    </div>

                @endguest

            </div>

        </div>

    </section>

</main>


{{-- ================= FOOTER ================= --}}
<footer class="border-t border-[#e5eaf0] bg-white">

    <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-6 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">

        <div class="flex items-center gap-2">

            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#2874b9] text-white">

                <i data-lucide="library-big" class="h-4 w-4"></i>

            </div>

            <span class="text-sm font-semibold text-[#344054]">
                Library Management System
            </span>

        </div>


        <p class="text-xs text-[#98a2b3]">
            © {{ date('Y') }} Library Management System. All rights reserved.
        </p>

    </div>

</footer>


<script>
    lucide.createIcons();
</script>


</body>
</html>
