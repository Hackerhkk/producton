@extends('admin.layouts.app')

@section('title', 'Result Details')

@section('content')

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-2">

                <a
                    href="{{ route('admin.test-results.index') }}"
                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#e4e8ef] bg-white text-[#667085] transition hover:border-[#2874b9] hover:text-[#2874b9]"
                >
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                </a>

                <h1 class="text-2xl font-bold text-[#1f2937]">
                    Result Details
                </h1>

            </div>

            <p class="mt-1 text-sm text-[#667085]">
                Detailed performance and question-wise answers.
            </p>
        </div>


        {{-- Result Status --}}
        @if($attempt->passed)

            <span class="inline-flex w-fit items-center gap-2 rounded-lg bg-green-50 px-3 py-2 text-sm font-semibold text-green-700">

                <i data-lucide="check-circle" class="h-4 w-4"></i>

                Passed

            </span>

        @else

            <span class="inline-flex w-fit items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-sm font-semibold text-red-700">

                <i data-lucide="x-circle" class="h-4 w-4"></i>

                Failed

            </span>

        @endif

    </div>


    {{-- Student + Test Info --}}
    <div class="grid gap-5 lg:grid-cols-2">

        {{-- Student --}}
        <div class="rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-lg font-bold text-[#2874b9]">
                    {{ strtoupper(substr($attempt->user->name ?? 'S', 0, 1)) }}
                </div>

                <div class="min-w-0">

                    <p class="text-xs font-medium uppercase tracking-wide text-[#98a2b3]">
                        Student
                    </p>

                    <h2 class="mt-0.5 truncate text-base font-bold text-[#1f2937]">
                        {{ $attempt->user->name ?? 'Unknown Student' }}
                    </h2>

                </div>

            </div>


            <div class="mt-5 grid grid-cols-2 gap-4">

                <div>
                    <p class="text-xs text-[#667085]">
                        Mobile
                    </p>

                    <p class="mt-1 text-sm font-semibold text-[#1f2937]">
                        {{ $attempt->user->mobile ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#667085]">
                        Student ID
                    </p>

                    <p class="mt-1 text-sm font-semibold text-[#1f2937]">
                        #{{ $attempt->user->id }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Test --}}
        <div class="rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

            <p class="text-xs font-medium uppercase tracking-wide text-[#98a2b3]">
                Test
            </p>

            <h2 class="mt-1 text-base font-bold text-[#1f2937]">
                {{ $attempt->test->name ?? '-' }}
            </h2>

            <p class="mt-1 text-sm text-[#667085]">
                {{ $attempt->test->testSeries->name ?? 'Test Series' }}
            </p>


            <div class="mt-5 grid grid-cols-3 gap-4">

                <div>
                    <p class="text-xs text-[#667085]">
                        Questions
                    </p>

                    <p class="mt-1 text-sm font-bold text-[#1f2937]">
                        {{ $attempt->total_questions }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#667085]">
                        Duration
                    </p>

                    <p class="mt-1 text-sm font-bold text-[#1f2937]">
                        {{ $attempt->test->duration }} min
                    </p>
                </div>

                <div>
                    <p class="text-xs text-[#667085]">
                        Total Marks
                    </p>

                    <p class="mt-1 text-sm font-bold text-[#1f2937]">
                        {{ number_format((float) $attempt->total_marks, 2) }}
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Score Cards --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">

        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Score
            </p>

            <p class="mt-1 text-xl font-bold text-[#2874b9]">
                {{ number_format((float) $attempt->obtained_marks, 2) }}
            </p>

            <p class="mt-0.5 text-[11px] text-[#98a2b3]">
                / {{ number_format((float) $attempt->total_marks, 2) }}
            </p>

        </div>


        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Percentage
            </p>

            <p class="mt-1 text-xl font-bold text-[#1f2937]">
                {{ number_format((float) $attempt->percentage, 2) }}%
            </p>

        </div>


        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Correct
            </p>

            <p class="mt-1 text-xl font-bold text-green-600">
                {{ $attempt->correct }}
            </p>

        </div>


        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Wrong
            </p>

            <p class="mt-1 text-xl font-bold text-red-600">
                {{ $attempt->wrong }}
            </p>

        </div>


        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Skipped
            </p>

            <p class="mt-1 text-xl font-bold text-[#667085]">
                {{ $attempt->skipped }}
            </p>

        </div>


        <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

            <p class="text-xs text-[#667085]">
                Time Taken
            </p>

            @php
                $minutes = floor($attempt->time_taken / 60);
                $seconds = $attempt->time_taken % 60;
            @endphp

            <p class="mt-1 text-xl font-bold text-[#1f2937]">
                {{ sprintf('%02d:%02d', $minutes, $seconds) }}
            </p>

        </div>

    </div>


    {{-- Attempt Information --}}
    <div class="rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

        <div class="flex items-center gap-2">

            <i data-lucide="info"
               class="h-4 w-4 text-[#2874b9]"></i>

            <h2 class="text-sm font-bold text-[#1f2937]">
                Attempt Information
            </h2>

        </div>


        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <div>
                <p class="text-xs text-[#667085]">
                    Started At
                </p>

                <p class="mt-1 text-sm font-semibold text-[#1f2937]">
                    {{ $attempt->started_at?->format('d M Y, h:i A') ?? '-' }}
                </p>
            </div>


            <div>
                <p class="text-xs text-[#667085]">
                    Submitted At
                </p>

                <p class="mt-1 text-sm font-semibold text-[#1f2937]">
                    {{ $attempt->submitted_at?->format('d M Y, h:i A') ?? '-' }}
                </p>
            </div>


            <div>
                <p class="text-xs text-[#667085]">
                    Passing Marks
                </p>

                <p class="mt-1 text-sm font-semibold text-[#1f2937]">
                    {{ number_format((float) $attempt->test->passing_marks, 2) }}
                </p>
            </div>


            <div>
                <p class="text-xs text-[#667085]">
                    Negative Marking
                </p>

                <p class="mt-1 text-sm font-semibold text-[#1f2937]">

                    @if($attempt->test->negative_marking)

                        Yes

                    @else

                        No

                    @endif

                </p>
            </div>

        </div>

    </div>


    {{-- Question Review --}}
    <div>

        <div class="mb-4">

            <h2 class="text-lg font-bold text-[#1f2937]">
                Question-wise Review
            </h2>

            <p class="mt-1 text-sm text-[#667085]">
                Review student's answers against the correct answers.
            </p>

        </div>


        <div class="space-y-4">

            @foreach($attempt->test->questions as $index => $question)

                @php

                    $answer = $attempt->answers
                        ->firstWhere('question_id', $question->id);

                    $selectedAnswer =
                        $answer?->selected_answer;

                    $correctAnswer =
                        $question->correct_answer;

                    $isAttempted =
                        !empty($selectedAnswer);

                    $isCorrect =
                        $answer?->is_correct ?? false;

                @endphp


                <div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">

                    {{-- Question Header --}}
                    <div class="flex flex-col gap-3 border-b border-[#edf0f4] bg-[#f8fafc] px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

                        <div class="flex items-center gap-3">

                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#2874b9] text-xs font-bold text-white">
                                {{ $index + 1 }}
                            </span>

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-[#98a2b3]">
                                    Question {{ $index + 1 }}
                                </p>

                                <p class="mt-0.5 text-xs text-[#667085]">
                                    {{ $question->marks }} marks
                                </p>

                            </div>

                        </div>


                        <div>

                            @if(!$isAttempted)

                                <span class="inline-flex items-center gap-1 rounded-md bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">

                                    <i data-lucide="minus-circle" class="h-3.5 w-3.5"></i>

                                    Skipped

                                </span>

                            @elseif($isCorrect)

                                <span class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">

                                    <i data-lucide="check-circle" class="h-3.5 w-3.5"></i>

                                    Correct

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1 rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">

                                    <i data-lucide="x-circle" class="h-3.5 w-3.5"></i>

                                    Wrong

                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="p-4 sm:p-5">

                        {{-- Question --}}
                        <h3 class="text-sm font-semibold leading-6 text-[#1f2937] sm:text-base">
                            {{ $question->question }}
                        </h3>


                        {{-- Options --}}
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">

                            @foreach(['A', 'B', 'C', 'D'] as $option)

                                @php
                                    $optionText =
                                        'option_' . strtolower($option);

                                    $isSelected =
                                        $selectedAnswer === $option;

                                    $isAnswer =
                                        $correctAnswer === $option;
                                @endphp


                                <div
                                    class="rounded-lg border p-3
                                    @if($isAnswer)
                                        border-green-300 bg-green-50
                                    @elseif($isSelected)
                                        border-red-300 bg-red-50
                                    @else
                                        border-[#e4e8ef] bg-white
                                    @endif"
                                >

                                    <div class="flex items-start gap-2.5">

                                        <span
                                            class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md text-xs font-bold
                                            @if($isAnswer)
                                                bg-green-600 text-white
                                            @elseif($isSelected)
                                                bg-red-600 text-white
                                            @else
                                                bg-[#f2f4f7] text-[#667085]
                                            @endif"
                                        >
                                            {{ $option }}
                                        </span>


                                        <div class="min-w-0 flex-1">

                                            <p class="text-sm leading-5 text-[#344054]">
                                                {{ $question->$optionText }}
                                            </p>


                                            @if($isAnswer)

                                                <span class="mt-1 inline-flex text-[11px] font-semibold text-green-700">
                                                    Correct Answer
                                                </span>

                                            @elseif($isSelected)

                                                <span class="mt-1 inline-flex text-[11px] font-semibold text-red-700">
                                                    Student's Answer
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- Answer Summary --}}
                        <div class="mt-5 grid gap-3 sm:grid-cols-3">

                            <div class="rounded-lg bg-[#f8fafc] p-3">

                                <p class="text-[11px] text-[#667085]">
                                    Student Answer
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#1f2937]">

                                    @if($selectedAnswer)
                                        {{ $selectedAnswer }}
                                    @else
                                        Not Answered
                                    @endif

                                </p>

                            </div>


                            <div class="rounded-lg bg-[#f8fafc] p-3">

                                <p class="text-[11px] text-[#667085]">
                                    Correct Answer
                                </p>

                                <p class="mt-1 text-sm font-bold text-green-700">
                                    {{ $correctAnswer }}
                                </p>

                            </div>


                            <div class="rounded-lg bg-[#f8fafc] p-3">

                                <p class="text-[11px] text-[#667085]">
                                    Obtained Marks
                                </p>

                                <p class="mt-1 text-sm font-bold
                                    @if((float) ($answer?->obtained_marks ?? 0) < 0)
                                        text-red-600
                                    @elseif($isCorrect)
                                        text-green-600
                                    @else
                                        text-[#1f2937]
                                    @endif"
                                >
                                    {{ number_format((float) ($answer?->obtained_marks ?? 0), 2) }}
                                </p>

                            </div>

                        </div>


                        {{-- Explanation --}}
                        @if($question->explanation)

                            <div class="mt-4 rounded-lg border border-blue-100 bg-blue-50 p-4">

                                <div class="flex items-start gap-2">

                                    <i data-lucide="lightbulb"
                                       class="mt-0.5 h-4 w-4 shrink-0 text-[#2874b9]"></i>

                                    <div>

                                        <p class="text-xs font-bold text-[#2874b9]">
                                            Explanation
                                        </p>

                                        <p class="mt-1 text-sm leading-6 text-[#344054]">
                                            {{ $question->explanation }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    {{-- Bottom Actions --}}
    <div class="flex flex-col gap-3 border-t border-[#e4e8ef] pt-5 sm:flex-row sm:justify-between">

        <a
            href="{{ route('admin.test-results.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#667085] transition hover:bg-gray-50"
        >

            <i data-lucide="arrow-left" class="h-4 w-4"></i>

            Back to Results

        </a>


        <div class="text-xs text-[#98a2b3] sm:self-center">

            Attempt #{{ $attempt->id }}

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
