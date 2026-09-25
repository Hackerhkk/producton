<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

    <title>Test Toppers - Library Management System</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">


@include('partials.user-navbar')



{{-- ================= MAIN ================= --}}

<main>

    {{-- ================= HERO ================= --}}

    <section class="relative overflow-hidden border-b border-[#e8edf2] bg-white">

        {{-- Background decoration --}}

        <div
            class="pointer-events-none absolute -left-32 -top-32 h-80 w-80 rounded-full bg-[#2874b9]/10 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -right-32 top-10 h-96 w-96 rounded-full bg-[#2874b9]/10 blur-3xl"
        ></div>


        <div
            class="relative mx-auto max-w-7xl px-5 py-14 sm:px-6 sm:py-16 lg:px-8"
        >

            <div class="mx-auto max-w-3xl text-center">

                <span
                    class="inline-flex items-center gap-2 rounded-full border border-[#d8e8f5] bg-[#eef6ff] px-3.5 py-1.5 text-xs font-semibold text-[#2874b9]"
                >

                    <i
                        data-lucide="trophy"
                        class="h-3.5 w-3.5"
                    ></i>

                    Top Performers

                </span>


                <h1
                    class="mt-5 text-3xl font-bold tracking-tight text-[#101828] sm:text-5xl"
                >
                    Test Toppers
                </h1>


                <p
                    class="mx-auto mt-4 max-w-2xl text-sm leading-6 text-[#667085] sm:text-base"
                >
                    Explore the top performers from our online tests and
                    see their best scores and performance.
                </p>

            </div>

        </div>

    </section>



    {{-- ================= FILTER ================= --}}

    <section class="bg-[#f8fafc]">

        <div
            class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8"
        >

            <div
                class="rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm"
            >

                <form
                    method="GET"
                    action="{{ route('test.toppers') }}"
                    class="flex flex-col gap-3 sm:flex-row sm:items-end"
                >

                    <div class="flex-1">

                        <label
                            for="test_id"
                            class="mb-1.5 block text-xs font-semibold text-[#344054]"
                        >
                            Filter by Test
                        </label>

                        <select
                            id="test_id"
                            name="test_id"
                            onchange="this.form.submit()"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20 cursor-pointer"
                        >

                            <option value="">
                                All Tests
                            </option>

                            @foreach ($tests as $test)

                                <option
                                    value="{{ $test->id }}"
                                    @selected($selectedTestId == $test->id)
                                >
                                    {{ $test->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    @if ($selectedTestId)

                        <a
                            href="{{ route('test.toppers') }}"
                            class="inline-flex h-[42px] items-center justify-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:border-[#2874b9] hover:text-[#2874b9] cursor-pointer"
                        >

                            <i
                                data-lucide="x"
                                class="h-4 w-4"
                            ></i>

                            Clear

                        </a>

                    @endif

                </form>

            </div>

        </div>

    </section>



    {{-- ================= TOP 3 ================= --}}

    @if ($toppers->count() > 0)

        <section class="bg-[#f8fafc]">

            <div
                class="mx-auto max-w-7xl px-5 pb-10 sm:px-6 lg:px-8"
            >

                <div
                    class="mb-6 flex items-center justify-between"
                >

                    <div>

                        <span
                            class="text-xs font-bold uppercase tracking-[0.18em] text-[#2874b9]"
                        >
                            Best Performers
                        </span>

                        <h2
                            class="mt-1 text-xl font-bold text-[#101828] sm:text-2xl"
                        >
                            Top 3
                        </h2>

                    </div>

                </div>


                <div
                    class="grid gap-5 md:grid-cols-3"
                >

                    @foreach ($toppers->take(3) as $topper)

                        @php

                            $rank = $topper->rank ?? ($loop->iteration);

                            $name =
                                $topper->user?->name
                                ?? 'User';

                            $initial =
                                strtoupper(
                                    substr(
                                        trim($name),
                                        0,
                                        1
                                    )
                                );

                        @endphp


                        <div
                            class="relative overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                        >

                            {{-- Rank Badge --}}

                            <div
                                class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-xl bg-[#eef6ff] text-sm font-bold text-[#2874b9]"
                            >
                                #{{ $rank }}
                            </div>


                            {{-- User --}}

                            <div
                                class="flex items-center gap-3 pr-10"
                            >

                                <div
                                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-base font-bold text-[#2874b9]"
                                >
                                    {{ $initial }}
                                </div>


                                <div class="min-w-0">

                                    <p
                                        class="truncate text-base font-bold text-[#1f2937]"
                                    >
                                        {{ $name }}
                                    </p>

                                    <p
                                        class="mt-0.5 truncate text-xs text-[#98a2b3]"
                                    >
                                        {{ $topper->test?->name ?? 'Test' }}
                                    </p>

                                </div>

                            </div>


                            {{-- Score --}}

                            <div
                                class="mt-5 rounded-xl bg-[#f8fafc] p-4"
                            >

                                <div
                                    class="flex items-center justify-between"
                                >

                                    <span
                                        class="text-xs font-medium text-[#667085]"
                                    >
                                        Percentage
                                    </span>

                                    <span
                                        class="text-xl font-bold text-[#2874b9]"
                                    >
                                        {{ number_format((float) $topper->percentage, 2) }}%
                                    </span>

                                </div>


                                <div
                                    class="mt-3 h-2 overflow-hidden rounded-full bg-[#e7edf3]"
                                >

                                    <div
                                        class="h-full rounded-full bg-[#2874b9]"
                                        style="width: {{ min(100, max(0, (float) $topper->percentage)) }}%"
                                    ></div>

                                </div>


                                <div
                                    class="mt-4 grid grid-cols-2 gap-2"
                                >

                                    <div
                                        class="rounded-lg border border-[#edf0f4] bg-white p-2.5 text-center"
                                    >

                                        <p
                                            class="text-[10px] text-[#98a2b3]"
                                        >
                                            Score
                                        </p>

                                        <p
                                            class="mt-0.5 text-sm font-bold text-[#1f2937]"
                                        >
                                            {{ number_format((float) $topper->obtained_marks, 2) }}
                                        </p>

                                    </div>


                                    <div
                                        class="rounded-lg border border-[#edf0f4] bg-white p-2.5 text-center"
                                    >

                                        <p
                                            class="text-[10px] text-[#98a2b3]"
                                        >
                                            Correct
                                        </p>

                                        <p
                                            class="mt-0.5 text-sm font-bold text-green-600"
                                        >
                                            {{ $topper->correct }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>



        {{-- ================= COMPLETE RANKING ================= --}}

        <section class="bg-white">

            <div
                class="mx-auto max-w-7xl px-5 py-12 sm:px-6 lg:px-8"
            >

                <div class="mb-6">

                    <span
                        class="text-xs font-bold uppercase tracking-[0.18em] text-[#2874b9]"
                    >
                        Leaderboard
                    </span>

                    <h2
                        class="mt-2 text-2xl font-bold text-[#101828]"
                    >
                        Top Performers
                    </h2>

                    <p
                        class="mt-1 text-sm text-[#667085]"
                    >
                        Best submitted attempt of each user.
                    </p>

                </div>


                {{-- Desktop Table --}}

                <div
                    class="hidden overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm md:block"
                >

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-[#f8fafc]">

                                <tr>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Rank
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Performer
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Test
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Score
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Correct
                                    </th>

                                    <th
                                        class="px-5 py-3.5 text-left text-xs font-bold uppercase tracking-wide text-[#667085]"
                                    >
                                        Percentage
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-[#edf0f4]">

                                @foreach ($toppers as $topper)

                                    @php

                                        $name =
                                            $topper->user?->name
                                            ?? 'User';

                                        $initial =
                                            strtoupper(
                                                substr(
                                                    trim($name),
                                                    0,
                                                    1
                                                )
                                            );

                                    @endphp


                                    <tr
                                        class="transition hover:bg-[#f8fafc]"
                                    >

                                        <td class="px-5 py-4">

                                            <span
                                                class="inline-flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#eef6ff] px-2 text-xs font-bold text-[#2874b9]"
                                            >
                                                #{{ $topper->rank }}
                                            </span>

                                        </td>


                                        <td class="px-5 py-4">

                                            <div
                                                class="flex items-center gap-3"
                                            >

                                                <div
                                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-xs font-bold text-[#2874b9]"
                                                >
                                                    {{ $initial }}
                                                </div>

                                                <span
                                                    class="font-semibold text-[#344054]"
                                                >
                                                    {{ $name }}
                                                </span>

                                            </div>

                                        </td>


                                        <td
                                            class="max-w-[260px] px-5 py-4"
                                        >

                                            <p
                                                class="truncate text-sm text-[#667085]"
                                            >
                                                {{ $topper->test?->name ?? 'Test' }}
                                            </p>

                                            @if ($topper->test?->testSeries)

                                                <p
                                                    class="mt-0.5 truncate text-[10px] text-[#98a2b3]"
                                                >
                                                    {{ $topper->test->testSeries->name }}
                                                </p>

                                            @endif

                                        </td>


                                        <td
                                            class="px-5 py-4 text-sm font-bold text-[#1f2937]"
                                        >
                                            {{ number_format((float) $topper->obtained_marks, 2) }}
                                        </td>


                                        <td
                                            class="px-5 py-4 text-sm font-semibold text-green-600"
                                        >
                                            {{ $topper->correct }}
                                        </td>


                                        <td class="px-5 py-4">

                                            <span
                                                class="inline-flex rounded-full bg-[#eef6ff] px-3 py-1 text-xs font-bold text-[#2874b9]"
                                            >
                                                {{ number_format((float) $topper->percentage, 2) }}%
                                            </span>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>



                {{-- Mobile Cards --}}

                <div class="space-y-3 md:hidden">

                    @foreach ($toppers as $topper)

                        @php

                            $name =
                                $topper->user?->name
                                ?? 'User';

                            $initial =
                                strtoupper(
                                    substr(
                                        trim($name),
                                        0,
                                        1
                                    )
                                );

                        @endphp


                        <div
                            class="rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm"
                        >

                            <div
                                class="flex items-center gap-3"
                            >

                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-sm font-bold text-[#2874b9]"
                                >
                                    {{ $initial }}
                                </div>


                                <div class="min-w-0 flex-1">

                                    <div
                                        class="flex items-center justify-between gap-3"
                                    >

                                        <p
                                            class="truncate text-sm font-bold text-[#1f2937]"
                                        >
                                            {{ $name }}
                                        </p>

                                        <span
                                            class="shrink-0 rounded-lg bg-[#eef6ff] px-2.5 py-1 text-[11px] font-bold text-[#2874b9]"
                                        >
                                            #{{ $topper->rank }}
                                        </span>

                                    </div>


                                    <p
                                        class="mt-0.5 truncate text-xs text-[#98a2b3]"
                                    >
                                        {{ $topper->test?->name ?? 'Test' }}
                                    </p>

                                </div>

                            </div>


                            <div
                                class="mt-4 grid grid-cols-3 gap-2"
                            >

                                <div
                                    class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-2.5 text-center"
                                >

                                    <p
                                        class="text-[10px] text-[#98a2b3]"
                                    >
                                        Score
                                    </p>

                                    <p
                                        class="mt-0.5 text-sm font-bold text-[#1f2937]"
                                    >
                                        {{ number_format((float) $topper->obtained_marks, 2) }}
                                    </p>

                                </div>


                                <div
                                    class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-2.5 text-center"
                                >

                                    <p
                                        class="text-[10px] text-[#98a2b3]"
                                    >
                                        Correct
                                    </p>

                                    <p
                                        class="mt-0.5 text-sm font-bold text-green-600"
                                    >
                                        {{ $topper->correct }}
                                    </p>

                                </div>


                                <div
                                    class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-2.5 text-center"
                                >

                                    <p
                                        class="text-[10px] text-[#98a2b3]"
                                    >
                                        Percentage
                                    </p>

                                    <p
                                        class="mt-0.5 text-sm font-bold text-[#2874b9]"
                                    >
                                        {{ number_format((float) $topper->percentage, 2) }}%
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </section>


    @else


        {{-- ================= EMPTY STATE ================= --}}

        <section class="bg-[#f8fafc]">

            <div
                class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8"
            >

                <div
                    class="rounded-2xl border border-dashed border-[#d0d5dd] bg-white px-6 py-16 text-center shadow-sm"
                >

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef6ff] text-[#2874b9]"
                    >

                        <i
                            data-lucide="trophy"
                            class="h-7 w-7"
                        ></i>

                    </div>


                    <h2
                        class="mt-5 text-xl font-bold text-[#101828]"
                    >
                        No results yet
                    </h2>


                    <p
                        class="mx-auto mt-2 max-w-md text-sm leading-6 text-[#667085]"
                    >
                        Toppers will appear here after users complete
                        and submit online tests.
                    </p>


                    <a
                        href="{{ url('/') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] cursor-pointer"
                    >

                        <i
                            data-lucide="arrow-left"
                            class="h-4 w-4"
                        ></i>

                        Back to Home

                    </a>

                </div>

            </div>

        </section>

    @endif

</main>



{{-- ================= CTA ================= --}}

<section class="bg-[#2874b9]">

    <div
        class="mx-auto max-w-7xl px-5 py-12 text-center sm:px-6 lg:px-8"
    >

        <div class="mx-auto max-w-2xl">

            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white"
            >

                <i
                    data-lucide="graduation-cap"
                    class="h-6 w-6"
                ></i>

            </div>


            <h2
                class="mt-5 text-2xl font-bold tracking-tight text-white sm:text-3xl"
            >
                Ready to test your knowledge?
            </h2>


            <p
                class="mt-3 text-sm leading-6 text-blue-100"
            >
                Create an account and start practicing with online tests.
            </p>


            @guest

                <div
                    class="mt-6 flex flex-wrap justify-center gap-3"
                >

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

            @else

                <a
                    href="{{ route('dashboard') }}"
                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#2874b9] shadow-sm transition hover:bg-blue-50 cursor-pointer"
                >

                    Open Dashboard

                    <i
                        data-lucide="arrow-right"
                        class="h-4 w-4"
                    ></i>

                </a>

            @endguest

        </div>

    </div>

</section>



{{-- ================= FOOTER ================= --}}

<footer class="border-t border-[#e5eaf0] bg-white">

    <div
        class="mx-auto max-w-7xl px-5 py-7 sm:px-6 lg:px-8"
    >

        <div
            class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between"
        >

            <div class="flex items-center gap-2.5">

                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#2874b9] text-white"
                >

                    <i
                        data-lucide="library-big"
                        class="h-4 w-4"
                    ></i>

                </div>


                <div>

                    <p
                        class="text-sm font-semibold text-[#344054]"
                    >
                        Library Management System
                    </p>

                    <p
                        class="mt-0.5 text-[11px] text-[#98a2b3]"
                    >
                        Smart Library System
                    </p>

                </div>

            </div>


            <nav
                class="flex flex-wrap items-center gap-x-5 gap-y-2"
            >

                <a
                    href="{{ route('terms') }}"
                    class="text-xs font-medium text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                >
                    Terms & Conditions
                </a>

                <span
                    class="hidden h-3.5 w-px bg-[#d0d5dd] sm:block"
                ></span>

                <a
                    href="{{ route('privacy') }}"
                    class="text-xs font-medium text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                >
                    Privacy Policy
                </a>

                <span
                    class="hidden h-3.5 w-px bg-[#d0d5dd] sm:block"
                ></span>

                <a
                    href="{{ route('refund') }}"
                    class="text-xs font-medium text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                >
                    Refund & Cancellation
                </a>

            </nav>

        </div>


        <div
            class="mt-6 flex flex-col gap-2 border-t border-[#edf0f4] pt-4 sm:flex-row sm:items-center sm:justify-between"
        >

            <p
                class="text-[11px] text-[#98a2b3]"
            >
                © {{ date('Y') }} Library Management System.
                All rights reserved.
            </p>


            <p
                class="flex items-center gap-1.5 text-[11px] text-[#98a2b3]"
            >

                <i
                    data-lucide="shield-check"
                    class="h-3.5 w-3.5"
                ></i>

                Secure & Simple Library Management

            </p>

        </div>

    </div>

</footer>



<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            if (
                typeof lucide !== 'undefined'
            ) {
                lucide.createIcons();
            }

        }
    );

</script>


</body>

</html>
