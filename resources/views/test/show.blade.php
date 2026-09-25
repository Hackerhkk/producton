@extends('test.layout')

@section('title', $test->name)

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | Effective Free Status
    |--------------------------------------------------------------------------
    |
    | Test FREE OR Test Series FREE = FREE
    |
    */
    $isFree =
        (bool) $test->is_free ||
        (bool) optional($test->testSeries)->is_free;


    /*
    |--------------------------------------------------------------------------
    | Subscription Access
    |--------------------------------------------------------------------------
    */
    $hasSubscriptionAccess = false;

    if (!$isFree && Auth::check()) {

        $subscription = Auth::user()
            ->latestSubscription()
            ->with('plan')
            ->first();

        if (
            $subscription &&
            $subscription->isActive() &&
            $subscription->plan &&
            $subscription->plan->tests_access
        ) {
            $hasSubscriptionAccess = true;
        }
    }

@endphp


<div class="min-h-screen bg-gray-50">

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">


        {{-- Back --}}
        <div class="mb-5">

            <a
                href="{{ route('student.tests.index') }}"
                class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#2874b9]"
            >

                <i data-lucide="arrow-left" class="h-4 w-4"></i>

                Back to Tests

            </a>

        </div>


        {{-- Test Header --}}
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">


                {{-- Title --}}
                <div class="min-w-0 flex-1">

                    <div class="flex flex-wrap items-center gap-2">

                        <p class="text-xs font-semibold text-[#2874b9]">
                            {{ $test->testSeries->name ?? 'Test Series' }}
                        </p>


                        {{-- FREE / PAID --}}
                        @if($isFree)

                            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-[10px] font-bold text-green-700">

                                <i data-lucide="unlock" class="h-3 w-3"></i>

                                FREE

                            </span>

                        @else

                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-1 text-[10px] font-bold text-amber-700">

                                <i data-lucide="lock" class="h-3 w-3"></i>

                                PAID

                            </span>

                        @endif

                    </div>


                    <h1 class="mt-2 text-xl font-bold text-gray-900 sm:text-2xl">
                        {{ $test->name }}
                    </h1>


                    @if($test->testSeries?->description)

                        <p class="mt-2 max-w-2xl text-sm text-gray-500">
                            {{ $test->testSeries->description }}
                        </p>

                    @endif

                </div>


                {{-- Active --}}
                @if($test->status)

                    <span class="inline-flex w-fit shrink-0 items-center gap-1.5 rounded-md bg-green-50 px-2.5 py-1.5 text-xs font-semibold text-green-700">

                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                        Active

                    </span>

                @endif

            </div>


            {{-- Paid Notice --}}
            @if(!$isFree)

                <div class="mt-5 flex items-start gap-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white text-amber-600 shadow-sm">

                        <i
                            data-lucide="{{ $hasSubscriptionAccess ? 'badge-check' : 'lock' }}"
                            class="h-4 w-4"
                        ></i>

                    </div>

                    <div>

                        @if($hasSubscriptionAccess)

                            <p class="text-sm font-semibold text-amber-800">
                                Test subscription active
                            </p>

                            <p class="mt-0.5 text-xs text-amber-700">
                                You have access to this paid test.
                            </p>

                        @else

                            <p class="text-sm font-semibold text-amber-800">
                                Subscription required
                            </p>

                            <p class="mt-0.5 text-xs text-amber-700">
                                This is a paid test. Purchase a test subscription to attempt it.
                            </p>

                        @endif

                    </div>

                </div>

            @endif


            {{-- Test Info --}}
            <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">


                {{-- Questions --}}
                <div class="rounded-lg bg-gray-50 p-3">

                    <div class="flex items-center gap-2 text-gray-500">

                        <i data-lucide="list-checks" class="h-4 w-4"></i>

                        <span class="text-xs">
                            Questions
                        </span>

                    </div>

                    <p class="mt-1 text-sm font-bold text-gray-900">
                        {{ $test->total_questions }}
                    </p>

                </div>


                {{-- Duration --}}
                <div class="rounded-lg bg-gray-50 p-3">

                    <div class="flex items-center gap-2 text-gray-500">

                        <i data-lucide="clock-3" class="h-4 w-4"></i>

                        <span class="text-xs">
                            Duration
                        </span>

                    </div>

                    <p class="mt-1 text-sm font-bold text-gray-900">
                        {{ $test->duration }} min
                    </p>

                </div>


                {{-- Total Marks --}}
                <div class="rounded-lg bg-gray-50 p-3">

                    <div class="flex items-center gap-2 text-gray-500">

                        <i data-lucide="award" class="h-4 w-4"></i>

                        <span class="text-xs">
                            Total Marks
                        </span>

                    </div>

                    <p class="mt-1 text-sm font-bold text-gray-900">
                        {{ $test->total_marks }}
                    </p>

                </div>


                {{-- Passing --}}
                <div class="rounded-lg bg-gray-50 p-3">

                    <div class="flex items-center gap-2 text-gray-500">

                        <i data-lucide="target" class="h-4 w-4"></i>

                        <span class="text-xs">
                            Passing
                        </span>

                    </div>

                    <p class="mt-1 text-sm font-bold text-gray-900">
                        {{ $test->passing_marks }}
                    </p>

                </div>

            </div>


            {{-- Negative Marking --}}
            @if($test->negative_marking)

                <div class="mt-4 flex items-center gap-2 rounded-lg border border-red-100 bg-red-50 px-3 py-2">

                    <i
                        data-lucide="triangle-alert"
                        class="h-4 w-4 text-red-500"
                    ></i>

                    <span class="text-xs font-medium text-red-600">
                        Negative marking:
                        -{{ $test->negative_marks }} marks
                    </span>

                </div>

            @endif


            {{-- Action --}}
            <div class="mt-5">


                {{-- FREE --}}
                @if($isFree)

                    <form
                        method="POST"
                        action="{{ route('student.test.start', $test) }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f] sm:w-auto sm:px-8"
                        >

                            <i data-lucide="play" class="h-4 w-4"></i>

                            Start Free Test

                        </button>

                    </form>


                {{-- PAID + ACCESS --}}
                @elseif($hasSubscriptionAccess)

                    <form
                        method="POST"
                        action="{{ route('student.test.start', $test) }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f] sm:w-auto sm:px-8"
                        >

                            <i data-lucide="play" class="h-4 w-4"></i>

                            Start Test

                        </button>

                    </form>


                {{-- PAID + NO ACCESS --}}
                @else

                    <a
                        href="{{ route('subscription.index') }}"
                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-amber-500 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 sm:w-auto sm:px-8"
                    >

                        <i data-lucide="lock-keyhole" class="h-4 w-4"></i>

                        Get Test Access

                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                    </a>

                @endif

            </div>

        </div>


        {{-- ============================= --}}
        {{-- RANK SUMMARY --}}
        {{-- ============================= --}}

        <div class="mt-5 grid gap-4 sm:grid-cols-2">


            {{-- My Rank --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6fc]">

                        <i
                            data-lucide="trophy"
                            class="h-5 w-5 text-[#2874b9]"
                        ></i>

                    </div>

                    <div>

                        <p class="text-xs font-medium text-gray-500">
                            Your Current Rank
                        </p>

                        @if($myRank)

                            <p class="mt-0.5 text-xl font-bold text-gray-900">

                                #{{ $myRank }}

                                <span class="text-sm font-medium text-gray-400">
                                    / {{ $totalTesters }}
                                </span>

                            </p>

                        @else

                            <p class="mt-0.5 text-base font-bold text-gray-900">
                                Not Ranked
                            </p>

                        @endif

                    </div>

                </div>


                @if($myRank)

                    @php

                        $myAttempt = $leaderboard->first(
                            function ($attempt) {
                                return (int) $attempt->user_id === (int) Auth::id();
                            }
                        );

                    @endphp


                    @if($myAttempt)

                        <div class="mt-4 grid grid-cols-2 gap-3">

                            <div class="rounded-lg bg-gray-50 p-3">

                                <p class="text-xs text-gray-500">
                                    Score
                                </p>

                                <p class="mt-1 text-sm font-bold text-gray-900">

                                    {{ number_format((float) $myAttempt->obtained_marks, 2) }}

                                    /

                                    {{ number_format((float) $myAttempt->total_marks, 2) }}

                                </p>

                            </div>


                            <div class="rounded-lg bg-gray-50 p-3">

                                <p class="text-xs text-gray-500">
                                    Percentage
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#2874b9]">

                                    {{ number_format((float) $myAttempt->percentage, 2) }}%

                                </p>

                            </div>

                        </div>

                    @endif

                @else

                    <p class="mt-3 text-xs text-gray-500">
                        Complete this test to appear in the ranking.
                    </p>

                @endif

            </div>


            {{-- Total Testers --}}
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-50">

                        <i
                            data-lucide="users"
                            class="h-5 w-5 text-gray-600"
                        ></i>

                    </div>

                    <div>

                        <p class="text-xs font-medium text-gray-500">
                            Total Testers
                        </p>

                        <p class="mt-0.5 text-xl font-bold text-gray-900">
                            {{ $totalTesters }}
                        </p>

                    </div>

                </div>

                <p class="mt-3 text-xs text-gray-500">
                    Users who have completed this test.
                </p>

            </div>

        </div>


        {{-- ============================= --}}
        {{-- LEADERBOARD --}}
        {{-- ============================= --}}

        <div class="mt-5 rounded-xl border border-gray-200 bg-white shadow-sm">


            {{-- Header --}}
            <div class="border-b border-gray-200 px-5 py-4">

                <div class="flex items-center justify-between gap-3">

                    <div>

                        <h2 class="flex items-center gap-2 text-base font-bold text-gray-900">

                            <i
                                data-lucide="medal"
                                class="h-5 w-5 text-[#2874b9]"
                            ></i>

                            Test Leaderboard

                        </h2>

                        <p class="mt-1 text-xs text-gray-500">
                            Ranking of users who completed this test.
                        </p>

                    </div>


                    <span class="rounded-md bg-gray-50 px-2.5 py-1 text-xs font-semibold text-gray-600">

                        {{ $totalTesters }}

                        {{ $totalTesters == 1 ? 'Tester' : 'Testers' }}

                    </span>

                </div>

            </div>


            @if($leaderboard->count())


                {{-- Desktop --}}
                <div class="hidden overflow-x-auto md:block">

                    <table class="w-full">

                        <thead class="bg-gray-50">

                            <tr class="border-b border-gray-200">

                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">
                                    Rank
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">
                                    User
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">
                                    Score
                                </th>

                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500">
                                    Percentage
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @foreach($leaderboard as $index => $attempt)

                                @php

                                    $rank = $index + 1;

                                    $isMe =
                                        (int) $attempt->user_id ===
                                        (int) Auth::id();

                                    $userName =
                                        $attempt->user->name ?? 'User';

                                @endphp


                                <tr class="{{ $isMe ? 'bg-[#f5faff]' : 'bg-white' }}">


                                    {{-- Rank --}}
                                    <td class="px-5 py-3">

                                        @if($rank <= 3)

                                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#eef6fc] text-sm font-bold text-[#2874b9]">

                                                {{ $rank }}

                                            </div>

                                        @else

                                            <span class="pl-2 text-sm font-semibold text-gray-500">
                                                {{ $rank }}
                                            </span>

                                        @endif

                                    </td>


                                    {{-- User --}}
                                    <td class="px-5 py-3">

                                        <div class="flex items-center gap-3">


                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#2874b9] text-xs font-bold text-white">

                                                {{ strtoupper(substr($userName, 0, 1)) }}

                                            </div>


                                            <div>

                                                <p class="text-sm font-semibold text-gray-900">

                                                    {{ $userName }}

                                                    @if($isMe)

                                                        <span class="ml-1 text-xs font-medium text-[#2874b9]">
                                                            (You)
                                                        </span>

                                                    @endif

                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Score --}}
                                    <td class="px-5 py-3 text-sm font-medium text-gray-700">

                                        {{ number_format((float) $attempt->obtained_marks, 2) }}

                                        /

                                        {{ number_format((float) $attempt->total_marks, 2) }}

                                    </td>


                                    {{-- Percentage --}}
                                    <td class="px-5 py-3">

                                        <span class="text-sm font-bold text-[#2874b9]">

                                            {{ number_format((float) $attempt->percentage, 2) }}%

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Mobile --}}
                <div class="divide-y divide-gray-100 md:hidden">

                    @foreach($leaderboard as $index => $attempt)

                        @php

                            $rank = $index + 1;

                            $isMe =
                                (int) $attempt->user_id ===
                                (int) Auth::id();

                            $userName =
                                $attempt->user->name ?? 'User';

                        @endphp


                        <div class="p-4 {{ $isMe ? 'bg-[#f5faff]' : 'bg-white' }}">

                            <div class="flex items-center gap-3">


                                {{-- Rank --}}
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#eef6fc] text-sm font-bold text-[#2874b9]">

                                    #{{ $rank }}

                                </div>


                                {{-- User --}}
                                <div class="min-w-0 flex-1">

                                    <p class="truncate text-sm font-semibold text-gray-900">

                                        {{ $userName }}

                                        @if($isMe)

                                            <span class="text-xs font-medium text-[#2874b9]">
                                                (You)
                                            </span>

                                        @endif

                                    </p>


                                    <p class="mt-0.5 text-xs text-gray-500">

                                        Score:

                                        {{ number_format((float) $attempt->obtained_marks, 2) }}

                                        /

                                        {{ number_format((float) $attempt->total_marks, 2) }}

                                    </p>

                                </div>


                                {{-- Percentage --}}
                                <div class="text-right">

                                    <p class="text-sm font-bold text-[#2874b9]">

                                        {{ number_format((float) $attempt->percentage, 2) }}%

                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>


            @else

                <div class="px-5 py-12 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                        <i
                            data-lucide="trophy"
                            class="h-6 w-6 text-gray-500"
                        ></i>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-gray-900">
                        No results yet
                    </h3>

                    <p class="mt-1 text-xs text-gray-500">
                        Be the first user to complete this test.
                    </p>

                </div>

            @endif

        </div>

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
