@extends('test.layout')

@section('title', 'Tests')

@section('content')

<div class="min-h-screen bg-[#f7f9fc]">

    <div class="mx-auto max-w-6xl px-4 py-5 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

            <div>
                <span class="inline-flex rounded-full bg-[#eef6ff] px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#2874b9]">
                    Test Preparation
                </span>

                <h1 class="mt-2 text-xl font-bold tracking-tight text-[#111827] sm:text-2xl">
                    Available Tests
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Choose a test and start your preparation.
                </p>
            </div>

            <div class="hidden h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9] sm:flex">
                <i data-lucide="clipboard-check" class="h-5 w-5"></i>
            </div>

        </div>


        {{-- Success --}}
        @if(session('success'))

            <div class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-white px-4 py-3 text-sm text-green-700 shadow-sm">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-green-50">
                    <i data-lucide="circle-check" class="h-4 w-4"></i>
                </div>

                <span>{{ session('success') }}</span>

            </div>

        @endif


        {{-- Error --}}
        @if(session('error'))

            <div class="mb-5 flex items-center gap-3 rounded-xl border border-red-200 bg-white px-4 py-3 text-sm text-red-700 shadow-sm">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-50">
                    <i data-lucide="circle-alert" class="h-4 w-4"></i>
                </div>

                <span>{{ session('error') }}</span>

            </div>

        @endif


        {{-- Search + Category --}}
        <form
            method="GET"
            action="{{ route('student.tests.index') }}"
            class="mb-5 rounded-xl border border-[#e4e8ef] bg-white p-3 shadow-sm sm:p-4"
        >

            <div class="grid gap-3 sm:grid-cols-[1fr_230px_auto]">

                {{-- Search --}}
                <div class="relative">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#98a2b3]">
                        <i data-lucide="search" class="h-4 w-4"></i>
                    </div>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search test or test series..."
                        autocomplete="off"
                        class="h-10 w-full rounded-lg border border-[#d0d5dd] bg-white pl-10 pr-10 text-sm text-[#1f2937] outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >

                    @if(request('search'))

                        <a
                            href="{{ route('student.tests.index', request('series') ? ['series' => request('series')] : []) }}"
                            class="absolute inset-y-0 right-0 flex cursor-pointer items-center pr-3 text-[#98a2b3] transition hover:text-red-500"
                            title="Clear search"
                        >
                            <i data-lucide="x" class="h-4 w-4"></i>
                        </a>

                    @endif

                </div>


                {{-- Category / Test Series --}}
                <div class="relative">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[#98a2b3]">
                        <i data-lucide="layers-3" class="h-4 w-4"></i>
                    </div>

                    <select
                        name="series"
                        onchange="this.form.submit()"
                        class="h-10 w-full cursor-pointer appearance-none rounded-lg border border-[#d0d5dd] bg-white pl-10 pr-9 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach($series as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected((string) request('series') === (string) $item->id)
                            >
                                {{ $item->name }}
                            </option>

                        @endforeach

                    </select>

                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-[#98a2b3]">
                        <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </div>

                </div>


                {{-- Search Button --}}
                <button
                    type="submit"
                    class="inline-flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f]"
                >
                    <i data-lucide="search" class="h-4 w-4"></i>
                    Search
                </button>

            </div>


            {{-- Active Filters --}}
            @if(request('search') || request('series'))

                <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-[#edf0f4] pt-3">

                    <span class="text-xs font-medium text-[#667085]">
                        Filters:
                    </span>


                    @if(request('search'))

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#eef6ff] px-2.5 py-1 text-[11px] font-semibold text-[#2874b9]">

                            <i data-lucide="search" class="h-3 w-3"></i>

                            {{ request('search') }}

                        </span>

                    @endif


                    @if(request('series'))

                        @php
                            $selectedSeries = $series->firstWhere(
                                'id',
                                request('series')
                            );
                        @endphp

                        @if($selectedSeries)

                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#f4f4f5] px-2.5 py-1 text-[11px] font-semibold text-[#52525b]">

                                <i data-lucide="layers-3" class="h-3 w-3"></i>

                                {{ $selectedSeries->name }}

                            </span>

                        @endif

                    @endif


                    <a
                        href="{{ route('student.tests.index') }}"
                        class="ml-auto inline-flex cursor-pointer items-center gap-1 text-xs font-semibold text-red-500 transition hover:text-red-600"
                    >
                        <i data-lucide="x" class="h-3.5 w-3.5"></i>
                        Clear
                    </a>

                </div>

            @endif

        </form>


        {{-- Result Info --}}
        @if(request('search') || request('series'))

            <div class="mb-4 flex items-center justify-between gap-3">

                <p class="text-sm text-[#667085]">

                    Showing
                    <span class="font-semibold text-[#1f2937]">
                        {{ $tests->total() }}
                    </span>
                    test{{ $tests->total() == 1 ? '' : 's' }}

                </p>

            </div>

        @endif


        {{-- Tests --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

            @forelse($tests as $test)

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | Effective Free Status
                    |--------------------------------------------------------------------------
                    |
                    | Test free OR its series free = FREE
                    |
                    */
                    $isFree =
                        (bool) $test->is_free ||
                        (bool) optional($test->testSeries)->is_free;

                @endphp


                <div class="group rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#2874b9]/30 hover:shadow-md sm:p-5">


                    {{-- Top --}}
                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0 flex-1">

                            <p class="truncate text-[11px] font-bold uppercase tracking-wide text-[#2874b9]">
                                {{ $test->testSeries->name ?? 'Test Series' }}
                            </p>

                            <h2 class="mt-1.5 line-clamp-2 text-base font-bold text-[#1f2937]">
                                {{ $test->name }}
                            </h2>

                        </div>


                        {{-- Free / Paid --}}
                        @if($isFree)

                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-bold text-green-700">

                                <i data-lucide="unlock" class="h-3 w-3"></i>

                                FREE

                            </span>

                        @else

                            <span class="inline-flex shrink-0 items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-bold text-amber-700">

                                <i data-lucide="lock" class="h-3 w-3"></i>

                                PAID

                            </span>

                        @endif

                    </div>


                    {{-- Active Status --}}
                    @if($test->status)

                        <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2 py-1 text-[10px] font-bold text-green-700">

                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                            Active

                        </div>

                    @endif


                    {{-- Test Info --}}
                    <div class="mt-4 grid grid-cols-2 gap-2">

                        {{-- Questions --}}
                        <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                            <div class="flex items-center gap-2 text-[#667085]">

                                <i data-lucide="list-checks" class="h-4 w-4"></i>

                                <span class="text-xs">
                                    Questions
                                </span>

                            </div>

                            <p class="mt-1 text-sm font-bold text-[#1f2937]">
                                {{ $test->total_questions }}
                            </p>

                        </div>


                        {{-- Duration --}}
                        <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                            <div class="flex items-center gap-2 text-[#667085]">

                                <i data-lucide="clock-3" class="h-4 w-4"></i>

                                <span class="text-xs">
                                    Duration
                                </span>

                            </div>

                            <p class="mt-1 text-sm font-bold text-[#1f2937]">
                                {{ $test->duration }} min
                            </p>

                        </div>


                        {{-- Total Marks --}}
                        <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                            <div class="flex items-center gap-2 text-[#667085]">

                                <i data-lucide="award" class="h-4 w-4"></i>

                                <span class="text-xs">
                                    Total Marks
                                </span>

                            </div>

                            <p class="mt-1 text-sm font-bold text-[#1f2937]">
                                {{ $test->total_marks }}
                            </p>

                        </div>


                        {{-- Passing --}}
                        <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                            <div class="flex items-center gap-2 text-[#667085]">

                                <i data-lucide="target" class="h-4 w-4"></i>

                                <span class="text-xs">
                                    Passing
                                </span>

                            </div>

                            <p class="mt-1 text-sm font-bold text-[#1f2937]">
                                {{ $test->passing_marks }}
                            </p>

                        </div>

                    </div>


                    {{-- Negative Marking --}}
                    @if($test->negative_marking)

                        <div class="mt-4 flex items-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2">

                            <i data-lucide="triangle-alert" class="h-4 w-4 shrink-0 text-red-500"></i>

                            <span class="text-xs font-medium text-red-600">
                                Negative marking: -{{ $test->negative_marks }}
                            </span>

                        </div>

                    @endif


                    {{-- View Test --}}
                    <div class="mt-5">

                        <a
                            href="{{ route('student.test.show', $test) }}"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f]"
                        >

                            @if($isFree)

                                <i data-lucide="unlock" class="h-4 w-4"></i>

                            @else

                                <i data-lucide="lock" class="h-4 w-4"></i>

                            @endif

                            View Test

                            <i data-lucide="arrow-up-right" class="h-4 w-4"></i>

                        </a>

                    </div>

                </div>

            @empty

                {{-- Empty --}}
                <div class="col-span-full rounded-xl border border-[#e4e8ef] bg-white px-5 py-14 text-center shadow-sm">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i
                            data-lucide="file-question"
                            class="h-6 w-6"
                        ></i>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#1f2937]">

                        @if(request('search') || request('series'))
                            No tests found
                        @else
                            No tests available
                        @endif

                    </h3>

                    <p class="mt-1 text-sm text-[#667085]">

                        @if(request('search') || request('series'))
                            Try changing your search or category.
                        @else
                            There are currently no active tests available.
                        @endif

                    </p>

                    @if(request('search') || request('series'))

                        <a
                            href="{{ route('student.tests.index') }}"
                            class="mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#21649f]"
                        >

                            <i data-lucide="rotate-ccw" class="h-4 w-4"></i>

                            View All Tests

                        </a>

                    @endif

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($tests->hasPages())

            <div class="mt-5 rounded-xl border border-[#e4e8ef] bg-white px-4 py-3 shadow-sm">

                {{ $tests->links() }}

            </div>

        @endif

    </div>

</div>


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
