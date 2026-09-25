<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Library Management System</title>

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">


{{-- ========================================================= --}}
{{-- FLOATING NAVBAR --}}
{{-- ========================================================= --}}

<header class="sticky top-0 z-50 px-3 pt-3 sm:px-5">

    <div class="mx-auto max-w-6xl">

        <div class="flex h-14 items-center justify-between rounded-2xl border border-[#e4e8ef] bg-white/95 px-3 shadow-[0_8px_30px_rgba(16,24,40,0.07)] backdrop-blur sm:h-16 sm:px-4">

            {{-- Logo --}}
            <a
                href="{{ url('/') }}"
                class="flex items-center gap-2.5 cursor-pointer"
            >

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm sm:h-10 sm:w-10">

                    <i
                        data-lucide="library-big"
                        class="h-5 w-5"
                    ></i>

                </div>


                <div class="hidden sm:block">

                    <div class="text-[14px] font-bold tracking-tight text-[#172033]">
                        Library Management
                    </div>

                    <div class="text-[10px] text-[#667085]">
                        Smart Library System
                    </div>

                </div>

            </a>


            {{-- Center Navigation --}}
            <nav class="hidden items-center gap-1 md:flex">

                <a
                    href="#features"
                    class="rounded-lg px-3 py-2 text-xs font-semibold text-[#667085] transition hover:bg-[#f2f6fa] hover:text-[#2874b9] cursor-pointer"
                >
                    Features
                </a>

                <a
                    href="#online-tests"
                    class="rounded-lg px-3 py-2 text-xs font-semibold text-[#667085] transition hover:bg-[#f2f6fa] hover:text-[#2874b9] cursor-pointer"
                >
                    Online Tests
                </a>

                <a
                    href="#courses"
                    class="rounded-lg px-3 py-2 text-xs font-semibold text-[#667085] transition hover:bg-[#f2f6fa] hover:text-[#2874b9] cursor-pointer"
                >
                    Courses
                </a>

                <a
                    href="#how-it-works"
                    class="rounded-lg px-3 py-2 text-xs font-semibold text-[#667085] transition hover:bg-[#f2f6fa] hover:text-[#2874b9] cursor-pointer"
                >
                    How It Works
                </a>

            </nav>


            {{-- Right Actions --}}
            <nav class="flex items-center gap-1.5 sm:gap-2">

                @auth

                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-[#2874b9] px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#21659f] cursor-pointer sm:px-4 sm:py-2.5"
                    >

                        <i
                            data-lucide="layout-dashboard"
                            class="h-3.5 w-3.5 sm:h-4 sm:w-4"
                        ></i>

                        <span class="hidden xs:inline sm:inline">
                            Dashboard
                        </span>

                    </a>

                @else

                    @if (Route::has('login'))

                        <a
                            href="{{ route('login') }}"
                            class="hidden rounded-xl px-3 py-2 text-xs font-semibold text-[#344054] transition hover:bg-[#f2f6fa] hover:text-[#2874b9] sm:inline-flex sm:items-center sm:gap-1.5 cursor-pointer"
                        >

                            <i
                                data-lucide="log-in"
                                class="h-3.5 w-3.5"
                            ></i>

                            Login

                        </a>

                    @endif


                    @if (Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-[#2874b9] px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-[#21659f] cursor-pointer sm:px-4 sm:py-2.5"
                        >

                            <i
                                data-lucide="user-plus"
                                class="h-3.5 w-3.5"
                            ></i>

                            <span>
                                Register
                            </span>

                        </a>

                    @endif

                @endauth

            </nav>

        </div>

    </div>

</header>



{{-- ========================================================= --}}
{{-- MAIN --}}
{{-- ========================================================= --}}

<main>


{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

<section class="relative overflow-hidden">

    {{-- Background --}}
    <div class="pointer-events-none absolute -left-40 -top-40 h-96 w-96 rounded-full bg-[#2874b9]/10 blur-3xl"></div>

    <div class="pointer-events-none absolute -right-40 top-32 h-[450px] w-[450px] rounded-full bg-[#2874b9]/10 blur-3xl"></div>


    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 py-16 sm:px-6 sm:py-20 lg:grid-cols-2 lg:px-8 lg:py-24">


        {{-- Hero Content --}}
        <div>

            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-semibold text-[#2874b9]">

                <span class="h-1.5 w-1.5 rounded-full bg-[#2874b9]"></span>

                Smart Library & Learning Platform

            </div>


            <h1 class="max-w-2xl text-4xl font-bold leading-[1.12] tracking-tight text-[#101828] sm:text-5xl lg:text-[56px]">

                Manage Your Library

                <span class="text-[#2874b9]">
                    Smarter.
                </span>

            </h1>


            <p class="mt-6 max-w-xl text-base leading-7 text-[#667085] sm:text-lg">

                Manage students, seats, monthly fees, wallets and
                online tests from one simple and modern platform.

            </p>


            {{-- Buttons --}}
            <div class="mt-8 flex flex-wrap items-center gap-3">

                @auth

                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#21659f] cursor-pointer"
                    >

                        <i
                            data-lucide="layout-dashboard"
                            class="h-4 w-4"
                        ></i>

                        Open Dashboard

                        <i
                            data-lucide="arrow-right"
                            class="h-4 w-4"
                        ></i>

                    </a>

                @else

                    @if (Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#21659f] cursor-pointer"
                        >

                            Get Started

                            <i
                                data-lucide="arrow-right"
                                class="h-4 w-4"
                            ></i>

                        </a>

                    @endif


                    @if (Route::has('login'))

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-5 py-3 text-sm font-semibold text-[#344054] shadow-sm transition hover:border-[#2874b9] hover:text-[#2874b9] cursor-pointer"
                        >

                            <i
                                data-lucide="log-in"
                                class="h-4 w-4"
                            ></i>

                            Login

                        </a>

                    @endif

                @endauth

            </div>


            {{-- Trust --}}
            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 text-xs text-[#667085]">

                <div class="flex items-center gap-2">

                    <i
                        data-lucide="check-circle-2"
                        class="h-4 w-4 text-green-600"
                    ></i>

                    Easy to use

                </div>


                <div class="flex items-center gap-2">

                    <i
                        data-lucide="shield-check"
                        class="h-4 w-4 text-green-600"
                    ></i>

                    Secure

                </div>


                <div class="flex items-center gap-2">

                    <i
                        data-lucide="smartphone"
                        class="h-4 w-4 text-green-600"
                    ></i>

                    Mobile friendly

                </div>

            </div>

        </div>


        {{-- Hero Preview --}}
        <div class="relative">

            <div class="absolute -inset-4 rounded-[2rem] bg-[#2874b9]/5 blur-2xl"></div>


            <div class="relative overflow-hidden rounded-3xl border border-[#e4e8ef] bg-white shadow-[0_20px_60px_rgba(16,24,40,0.10)]">

                {{-- Preview Header --}}
                <div class="flex items-center justify-between border-b border-[#edf0f4] px-5 py-4">

                    <div class="flex items-center gap-2">

                        <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#d0d5dd]"></span>

                    </div>


                    <div class="rounded-md bg-[#f5f7fa] px-3 py-1 text-[10px] text-[#98a2b3]">
                        library-admin
                    </div>


                    <i
                        data-lucide="more-horizontal"
                        class="h-4 w-4 text-[#98a2b3]"
                    ></i>

                </div>


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

                            <i
                                data-lucide="library"
                                class="h-4 w-4"
                            ></i>

                        </div>

                    </div>


                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                        @foreach ([
                            ['icon' => 'users', 'label' => 'Students', 'value' => '248'],
                            ['icon' => 'armchair', 'label' => 'Seats', 'value' => '120'],
                            ['icon' => 'circle-check', 'label' => 'Available', 'value' => '36'],
                            ['icon' => 'wallet', 'label' => 'Wallet', 'value' => '₹52K'],
                        ] as $stat)

                            <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-3">

                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                                    <i
                                        data-lucide="{{ $stat['icon'] }}"
                                        class="h-4 w-4"
                                    ></i>

                                </div>

                                <p class="mt-3 text-[10px] text-[#667085]">
                                    {{ $stat['label'] }}
                                </p>

                                <p class="mt-0.5 text-lg font-bold text-[#101828]">
                                    {{ $stat['value'] }}
                                </p>

                            </div>

                        @endforeach

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



{{-- ========================================================= --}}
{{-- FEATURES --}}
{{-- ========================================================= --}}

<section
    id="features"
    class="relative overflow-hidden border-y border-[#e8edf2] bg-white"
>

    <div class="pointer-events-none absolute -right-32 top-10 h-72 w-72 rounded-full bg-[#2874b9]/5 blur-3xl"></div>


    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">


        <div class="grid items-end gap-8 lg:grid-cols-2">

            <div>

                <span class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-bold text-[#2874b9]">

                    <i
                        data-lucide="layers-3"
                        class="h-3.5 w-3.5"
                    ></i>

                    Everything in one place

                </span>


                <h2 class="mt-4 max-w-2xl text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">

                    Everything your library needs

                </h2>

            </div>


            <p class="max-w-xl text-sm leading-7 text-[#667085] lg:ml-auto lg:text-right sm:text-base">

                Keep your daily library operations simple,
                organized and under control.

            </p>

        </div>


        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

            @foreach ([
                [
                    'icon' => 'users',
                    'title' => 'Student Management',
                    'text' => 'Manage student profiles, documents, contact details and active assignments.'
                ],
                [
                    'icon' => 'armchair',
                    'title' => 'Seat Management',
                    'text' => 'Track available and occupied seats and manage library assignments easily.'
                ],
                [
                    'icon' => 'receipt',
                    'title' => 'Fee Management',
                    'text' => 'Manage monthly plans, fee cycles, payments and student fee history.'
                ],
                [
                    'icon' => 'wallet',
                    'title' => 'Wallet System',
                    'text' => 'Maintain wallet balances and keep every wallet transaction organized.'
                ],
            ] as $feature)

                <div class="group rounded-2xl border border-[#e4e8ef] bg-white p-6 transition hover:-translate-y-1 hover:border-[#b9d6eb] hover:shadow-[0_15px_40px_rgba(16,24,40,0.08)]">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] transition group-hover:bg-[#2874b9] group-hover:text-white">

                        <i
                            data-lucide="{{ $feature['icon'] }}"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <h3 class="mt-5 font-semibold text-[#1f2937]">
                        {{ $feature['title'] }}
                    </h3>


                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        {{ $feature['text'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- ONLINE TESTS --}}
{{-- ========================================================= --}}

<section
    id="online-tests"
    class="relative overflow-hidden bg-[#f8fafc]"
>

    <div class="pointer-events-none absolute -left-40 top-20 h-96 w-96 rounded-full bg-[#2874b9]/5 blur-3xl"></div>


    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">


        <div class="grid items-center gap-12 lg:grid-cols-2">


            {{-- Content --}}
            <div>

                <span class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-white px-3.5 py-1.5 text-xs font-bold text-[#2874b9] shadow-sm">

                    <i
                        data-lucide="clipboard-check"
                        class="h-3.5 w-3.5"
                    ></i>

                    Online Learning & Practice

                </span>


                <h2 class="mt-4 max-w-xl text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">

                    Practice with Online Tests

                </h2>


                <p class="mt-5 max-w-xl text-sm leading-7 text-[#667085] sm:text-base">

                    Prepare yourself with online test series,
                    practice tests and detailed performance results.

                </p>


                <div class="mt-7 space-y-4">

                    @foreach ([
                        ['icon' => 'file-check-2', 'title' => 'Online Test Series', 'text' => 'Attempt available tests from your account.'],
                        ['icon' => 'zap', 'title' => 'Instant Results', 'text' => 'View your score and performance after submission.'],
                        ['icon' => 'chart-no-axes-combined', 'title' => 'Performance Tracking', 'text' => 'Track marks, correct answers and attempts.'],
                        ['icon' => 'trophy', 'title' => 'Test Toppers', 'text' => 'See top performers for completed tests.'],
                    ] as $item)

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white text-[#2874b9] shadow-sm ring-1 ring-[#e4e8ef]">

                                <i
                                    data-lucide="{{ $item['icon'] }}"
                                    class="h-4 w-4"
                                ></i>

                            </div>


                            <div>

                                <p class="text-sm font-semibold text-[#344054]">
                                    {{ $item['title'] }}
                                </p>

                                <p class="mt-0.5 text-xs leading-5 text-[#98a2b3]">
                                    {{ $item['text'] }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>


                <div class="mt-8 flex flex-wrap gap-3">

                    <a
                        href="{{ route('test.toppers') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] cursor-pointer"
                    >

                        <i
                            data-lucide="trophy"
                            class="h-4 w-4"
                        ></i>

                        Test Toppers

                        <i
                            data-lucide="arrow-right"
                            class="h-4 w-4"
                        ></i>

                    </a>

                </div>

            </div>


            {{-- Test Preview --}}
            <div class="relative">

                <div class="absolute -inset-5 rounded-[2rem] bg-[#2874b9]/5 blur-2xl"></div>


                <div class="relative rounded-3xl border border-[#e4e8ef] bg-white p-5 shadow-[0_20px_60px_rgba(16,24,40,0.08)] sm:p-7">

                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                                <i
                                    data-lucide="file-question"
                                    class="h-5 w-5"
                                ></i>

                            </div>


                            <div>

                                <p class="text-sm font-semibold text-[#344054]">
                                    Practice Test
                                </p>

                                <p class="text-xs text-[#98a2b3]">
                                    Online assessment
                                </p>

                            </div>

                        </div>


                        <span class="rounded-full bg-green-50 px-3 py-1 text-[10px] font-semibold text-green-600">
                            Active
                        </span>

                    </div>


                    <div class="mt-6 rounded-2xl border border-[#edf0f4] bg-[#fafbfc] p-5">

                        <div class="flex items-center justify-between">

                            <span class="text-xs font-medium text-[#98a2b3]">
                                Question 12
                            </span>

                            <span class="text-xs font-semibold text-[#2874b9]">
                                12 / 50
                            </span>

                        </div>


                        <p class="mt-4 text-sm font-semibold leading-6 text-[#344054]">
                            Select the correct answer from the following options.
                        </p>


                        <div class="mt-5 space-y-2">

                            <div class="flex items-center gap-3 rounded-xl border border-[#edf0f4] bg-white px-3 py-3">

                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#f5f7fa] text-xs font-semibold text-[#667085]">
                                    A
                                </span>

                                <span class="text-xs text-[#667085]">
                                    Option One
                                </span>

                            </div>


                            <div class="flex items-center gap-3 rounded-xl border border-[#b9d6eb] bg-[#eef6ff] px-3 py-3">

                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#2874b9] text-xs font-semibold text-white">
                                    B
                                </span>

                                <span class="text-xs font-semibold text-[#2874b9]">
                                    Correct Option
                                </span>

                                <i
                                    data-lucide="check"
                                    class="ml-auto h-4 w-4 text-[#2874b9]"
                                ></i>

                            </div>


                            <div class="flex items-center gap-3 rounded-xl border border-[#edf0f4] bg-white px-3 py-3">

                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#f5f7fa] text-xs font-semibold text-[#667085]">
                                    C
                                </span>

                                <span class="text-xs text-[#667085]">
                                    Option Three
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="mt-4 grid grid-cols-3 gap-2">

                        <div class="rounded-xl border border-[#edf0f4] bg-white p-3 text-center">

                            <i
                                data-lucide="list-checks"
                                class="mx-auto h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-[10px] text-[#98a2b3]">
                                Questions
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                50
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#edf0f4] bg-white p-3 text-center">

                            <i
                                data-lucide="clock-3"
                                class="mx-auto h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-[10px] text-[#98a2b3]">
                                Duration
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                60 Min
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#edf0f4] bg-white p-3 text-center">

                            <i
                                data-lucide="bar-chart-3"
                                class="mx-auto h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-[10px] text-[#98a2b3]">
                                Result
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                Detailed
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- RKCL + TALLY COURSES --}}
{{-- ========================================================= --}}

<section
    id="courses"
    class="relative overflow-hidden border-y border-[#e8edf2] bg-white"
>

    <div class="pointer-events-none absolute -right-40 -top-32 h-96 w-96 rounded-full bg-[#2874b9]/5 blur-3xl"></div>


    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">


        {{-- Heading --}}
        <div class="grid items-end gap-8 lg:grid-cols-2">

            <div>

                <span class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-bold text-[#2874b9]">

                    <i
                        data-lucide="graduation-cap"
                        class="h-3.5 w-3.5"
                    ></i>

                    Computer Education

                </span>


                <h2 class="mt-4 max-w-2xl text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">

                    Build practical computer skills

                </h2>

            </div>


            <p class="max-w-xl text-sm leading-7 text-[#667085] lg:ml-auto lg:text-right sm:text-base">

                Learn computer fundamentals, digital skills,
                accounting and office productivity with practical courses.

            </p>

        </div>


        {{-- Course Cards --}}
        <div class="mt-12 grid gap-5 md:grid-cols-2">


            {{-- RKCL --}}
            <div class="group relative overflow-hidden rounded-3xl border border-[#dce7f0] bg-[#f8fbff] p-6 transition hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(16,24,40,0.08)] sm:p-8">

                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-[#2874b9]/5"></div>


                <div class="relative">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eef6ff] text-[#2874b9]">

                            <i
                                data-lucide="monitor-smartphone"
                                class="h-6 w-6"
                            ></i>

                        </div>


                        <span class="rounded-full bg-[#eef6ff] px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-[#2874b9]">
                            Computer Course
                        </span>

                    </div>


                    <h3 class="mt-6 text-2xl font-bold text-[#101828]">
                        RKCL / RSCIT
                    </h3>


                    <p class="mt-3 text-sm leading-7 text-[#667085]">

                        Learn essential computer knowledge,
                        internet usage, digital services and
                        everyday computer applications.

                    </p>


                    <div class="mt-6 grid grid-cols-2 gap-3">

                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="computer"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Computer Basics
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="globe"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Internet Skills
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="file-text"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Office Tools
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="smartphone"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Digital Services
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Tally --}}
            <div class="group relative overflow-hidden rounded-3xl border border-[#dce7f0] bg-[#f8fbff] p-6 transition hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(16,24,40,0.08)] sm:p-8">

                <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-[#2874b9]/5"></div>


                <div class="relative">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#eef6ff] text-[#2874b9]">

                            <i
                                data-lucide="calculator"
                                class="h-6 w-6"
                            ></i>

                        </div>


                        <span class="rounded-full bg-[#eef6ff] px-3 py-1 text-[10px] font-bold uppercase tracking-wide text-[#2874b9]">
                            Accounting Course
                        </span>

                    </div>


                    <h3 class="mt-6 text-2xl font-bold text-[#101828]">
                        Tally Prime + GST
                    </h3>


                    <p class="mt-3 text-sm leading-7 text-[#667085]">

                        Learn practical accounting with Tally Prime,
                        GST basics, invoicing, inventory and
                        day-to-day business accounting.

                    </p>


                    <div class="mt-6 grid grid-cols-2 gap-3">

                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="calculator"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Tally Prime
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="receipt"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                GST Basics
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="boxes"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Inventory
                            </p>

                        </div>


                        <div class="rounded-xl border border-[#e4e8ef] bg-white p-3">

                            <i
                                data-lucide="file-chart-column"
                                class="h-4 w-4 text-[#2874b9]"
                            ></i>

                            <p class="mt-2 text-xs font-semibold text-[#344054]">
                                Business Reports
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Course CTA --}}
        <div class="mt-8 rounded-2xl border border-[#dce7f0] bg-[#f8fbff] p-5 sm:p-6">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-start gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i
                            data-lucide="book-open"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <div>

                        <p class="text-sm font-semibold text-[#344054]">
                            Learn with practical computer education
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#98a2b3]">
                            Build useful skills for study, office work and business.
                        </p>

                    </div>

                </div>


                <a
                    href="#courses"
                    class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] cursor-pointer"
                >

                    Explore Courses

                    <i
                        data-lucide="arrow-right"
                        class="h-4 w-4"
                    ></i>

                </a>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- TEST TOPPERS --}}
{{-- ========================================================= --}}

<section class="relative overflow-hidden bg-[#f8fafc]">

    <div class="pointer-events-none absolute -left-32 top-10 h-80 w-80 rounded-full bg-[#2874b9]/5 blur-3xl"></div>


    <div class="relative mx-auto max-w-7xl px-5 py-16 text-center sm:px-6 sm:py-20 lg:px-8">

        <span class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-white px-3.5 py-1.5 text-xs font-bold text-[#2874b9] shadow-sm">

            <i
                data-lucide="trophy"
                class="h-3.5 w-3.5"
            ></i>

            Top Performers

        </span>


        <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
            Test Toppers
        </h2>


        <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#667085] sm:text-base">

            See top performers and their test results
            from completed online tests.

        </p>


        <div class="mt-8">

            <a
                href="{{ route('test.toppers') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-[#21659f] cursor-pointer"
            >

                <i
                    data-lucide="trophy"
                    class="h-5 w-5"
                ></i>

                View Test Toppers

                <i
                    data-lucide="arrow-right"
                    class="h-4 w-4"
                ></i>

            </a>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- HOW IT WORKS --}}
{{-- ========================================================= --}}

<section
    id="how-it-works"
    class="relative overflow-hidden border-y border-[#e8edf2] bg-white"
>

    <div class="relative mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">


        <div class="grid items-center gap-12 lg:grid-cols-2">


            {{-- Left --}}
            <div>

                <span class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-bold text-[#2874b9]">

                    <i
                        data-lucide="workflow"
                        class="h-3.5 w-3.5"
                    ></i>

                    Simple workflow

                </span>


                <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">

                    Run your library with less effort

                </h2>


                <p class="mt-5 max-w-xl text-sm leading-7 text-[#667085] sm:text-base">

                    From adding your library to managing students,
                    seats and monthly fees, everything stays connected.

                </p>


                <div class="mt-8 space-y-6">

                    @foreach ([
                        ['number' => '1', 'title' => 'Add your library', 'text' => 'Create libraries and organize their available seats.'],
                        ['number' => '2', 'title' => 'Add students', 'text' => 'Store student information and assign them to seats.'],
                        ['number' => '3', 'title' => 'Manage fees & wallets', 'text' => 'Track monthly fees, wallet balances and payment history.'],
                    ] as $step)

                        <div class="flex gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#2874b9] text-sm font-bold text-white shadow-sm">

                                {{ $step['number'] }}

                            </div>


                            <div>

                                <h3 class="font-semibold text-[#1f2937]">
                                    {{ $step['title'] }}
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-[#667085]">
                                    {{ $step['text'] }}
                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- Right --}}
            <div class="relative">

                <div class="absolute -inset-5 rounded-[2rem] bg-[#2874b9]/5 blur-2xl"></div>


                <div class="relative rounded-3xl border border-[#dce7f0] bg-[#eef6ff] p-5 sm:p-8">

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

                                <i
                                    data-lucide="wallet-cards"
                                    class="h-6 w-6"
                                ></i>

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

                                <i
                                    data-lucide="circle-check"
                                    class="h-4 w-4 text-green-600"
                                ></i>

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



{{-- ========================================================= --}}
{{-- CTA --}}
{{-- ========================================================= --}}

<section class="relative overflow-hidden bg-[#2874b9]">

    <div class="pointer-events-none absolute -left-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>

    <div class="pointer-events-none absolute -bottom-32 -right-20 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>


    <div class="relative mx-auto max-w-7xl px-5 py-16 text-center sm:px-6 sm:py-20 lg:px-8">

        <div class="mx-auto max-w-2xl">

            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white">

                <i
                    data-lucide="library-big"
                    class="h-6 w-6"
                ></i>

            </div>


            <h2 class="mt-5 text-3xl font-bold tracking-tight text-white sm:text-4xl">

                Ready to manage your library smarter?

            </h2>


            <p class="mt-4 text-sm leading-7 text-blue-100 sm:text-base">

                Get started with a simple, organized and modern
                library management experience.

            </p>


            @guest

                <div class="mt-7 flex flex-wrap justify-center gap-3">

                    @if (Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#2874b9] shadow-sm transition hover:bg-blue-50 cursor-pointer"
                        >

                            Create Account

                            <i
                                data-lucide="arrow-right"
                                class="h-4 w-4"
                            ></i>

                        </a>

                    @endif


                    @if (Route::has('login'))

                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10 cursor-pointer"
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



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="border-t border-[#e5eaf0] bg-white">

    <div class="mx-auto max-w-7xl px-5 py-7 sm:px-6 lg:px-8">

        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">


            {{-- Brand --}}
            <div class="flex items-center gap-2.5">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#2874b9] text-white">

                    <i
                        data-lucide="library-big"
                        class="h-4 w-4"
                    ></i>

                </div>


                <div>

                    <p class="text-sm font-semibold text-[#344054]">
                        Library Management System
                    </p>

                    <p class="mt-0.5 text-[11px] text-[#98a2b3]">
                        Smart Library System
                    </p>

                </div>

            </div>


            {{-- Links --}}
            <nav class="flex flex-wrap items-center gap-x-5 gap-y-2">

                <a
                    href="{{ route('terms') }}"
                    class="cursor-pointer text-xs font-medium text-[#667085] transition hover:text-[#2874b9]"
                >
                    Terms & Conditions
                </a>


                <span class="hidden h-3.5 w-px bg-[#d0d5dd] sm:block"></span>


                <a
                    href="{{ route('privacy') }}"
                    class="cursor-pointer text-xs font-medium text-[#667085] transition hover:text-[#2874b9]"
                >
                    Privacy Policy
                </a>


                <span class="hidden h-3.5 w-px bg-[#d0d5dd] sm:block"></span>


                <a
                    href="{{ route('refund') }}"
                    class="cursor-pointer text-xs font-medium text-[#667085] transition hover:text-[#2874b9]"
                >
                    Refund & Cancellation
                </a>

            </nav>

        </div>


        <div class="mt-6 flex flex-col gap-2 border-t border-[#edf0f4] pt-4 sm:flex-row sm:items-center sm:justify-between">

            <p class="text-[11px] text-[#98a2b3]">

                © {{ date('Y') }} Library Management System.
                All rights reserved.

            </p>


            <p class="flex items-center gap-1.5 text-[11px] text-[#98a2b3]">

                <i
                    data-lucide="shield-check"
                    class="h-3.5 w-3.5"
                ></i>

                Secure & Simple Library Management

            </p>

        </div>

    </div>

</footer>



{{-- ========================================================= --}}
{{-- LUCIDE --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});

</script>


</body>

</html>
