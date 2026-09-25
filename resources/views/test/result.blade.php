@extends('test.layout')

@section('title', 'Test Result')

@section('content')

<div class="min-h-screen bg-[#f7f9fc] py-6 sm:py-8">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('student.tests.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-[#667085] transition hover:text-[#2874b9]">
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
                Back to Tests
            </a>
        </div>

        {{-- Result Summary --}}
        <div class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            {{-- Status Header --}}
            <div class="border-b border-[#e4e8ef] px-5 py-6 sm:px-7">

                <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#2874b9]">
                            {{ $attempt->test->testSeries->name ?? 'Test Series' }}
                        </p>

                        <h1 class="mt-1 text-xl font-bold text-[#1f2937] sm:text-2xl">
                            {{ $attempt->test->name }}
                        </h1>

                        <p class="mt-1 text-sm text-[#667085]">
                            Test Result
                        </p>
                    </div>

                    @if($attempt->passed)
                        <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-green-50 px-4 py-2.5 text-sm font-bold text-green-700">
                            <i data-lucide="circle-check" class="h-5 w-5"></i>
                            Passed
                        </div>
                    @else
                        <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-red-50 px-4 py-2.5 text-sm font-bold text-red-700">
                            <i data-lucide="circle-x" class="h-5 w-5"></i>
                            Failed
                        </div>
                    @endif

                </div>

            </div>

            {{-- Score --}}
            <div class="grid gap-4 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-4">

                <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                            <i data-lucide="award" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <p class="text-xs text-[#667085]">
                                Score
                            </p>

                            <p class="text-xl font-bold text-[#1f2937]">
                                {{ number_format((float) $attempt->obtained_marks, 2) }}
                                /
                                {{ number_format((float) $attempt->total_marks, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                            <i data-lucide="percent" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <p class="text-xs text-[#667085]">
                                Percentage
                            </p>

                            <p class="text-xl font-bold text-[#1f2937]">
                                {{ number_format((float) $attempt->percentage, 2) }}%
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                            <i data-lucide="circle-check" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <p class="text-xs text-[#667085]">
                                Passing Marks
                            </p>

                            <p class="text-xl font-bold text-[#1f2937]">
                                {{ number_format((float) $attempt->test->passing_marks, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-5">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                            <i data-lucide="clock-3" class="h-5 w-5"></i>
                        </div>

                        <div>
                            <p class="text-xs text-[#667085]">
                                Time Taken
                            </p>

                            @php
                                $minutes = floor($attempt->time_taken / 60);
                                $seconds = $attempt->time_taken % 60;
                            @endphp

                            <p class="text-xl font-bold text-[#1f2937]">
                                {{ $minutes }}m {{ $seconds }}s
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Statistics --}}
        <div class="mt-5 rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm sm:p-7">

            <div class="mb-5">
                <h2 class="text-base font-bold text-[#1f2937]">
                    Performance Summary
                </h2>

                <p class="mt-1 text-sm text-[#667085]">
                    Overview of your test performance.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                <div class="rounded-xl border border-[#e4e8ef] p-4">
                    <p class="text-xs text-[#667085]">
                        Total Questions
                    </p>

                    <p class="mt-1 text-2xl font-bold text-[#1f2937]">
                        {{ $attempt->total_questions }}
                    </p>
                </div>

                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <p class="text-xs text-green-700">
                        Correct
                    </p>

                    <p class="mt-1 text-2xl font-bold text-green-700">
                        {{ $attempt->correct }}
                    </p>
                </div>

                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="text-xs text-red-700">
                        Wrong
                    </p>

                    <p class="mt-1 text-2xl font-bold text-red-700">
                        {{ $attempt->wrong }}
                    </p>
                </div>

                <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-4">
                    <p class="text-xs text-[#667085]">
                        Skipped
                    </p>

                    <p class="mt-1 text-2xl font-bold text-[#1f2937]">
                        {{ $attempt->skipped }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Question Review --}}
        <div class="mt-5 rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="border-b border-[#e4e8ef] px-5 py-5 sm:px-7">
                <h2 class="text-base font-bold text-[#1f2937]">
                    Question Review
                </h2>

                <p class="mt-1 text-sm text-[#667085]">
                    Review your submitted answers.
                </p>
            </div>

            <div class="divide-y divide-[#edf0f4]">

                @foreach($attempt->test->questions as $index => $question)

                    @php
                        $answer = $attempt->answers
                            ->firstWhere('question_id', $question->id);
                    @endphp

                    <div class="p-5 sm:px-7">

                        <div class="flex items-start gap-3">

                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#f2f4f7] text-xs font-bold text-[#667085]">
                                {{ $index + 1 }}
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                    <h3 class="text-sm font-semibold leading-6 text-[#1f2937]">
                                        {{ $question->question }}
                                    </h3>

                                    @if($answer && $answer->is_correct)

                                        <span class="inline-flex w-fit shrink-0 items-center gap-1 rounded-md bg-green-50 px-2 py-1 text-xs font-semibold text-green-700">
                                            <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                            Correct
                                        </span>

                                    @elseif($answer && $answer->is_attempted)

                                        <span class="inline-flex w-fit shrink-0 items-center gap-1 rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">
                                            <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                            Wrong
                                        </span>

                                    @else

                                        <span class="inline-flex w-fit shrink-0 items-center gap-1 rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-[#667085]">
                                            Skipped
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-4 grid gap-2 sm:grid-cols-2">

                                    @foreach(['A', 'B', 'C', 'D'] as $option)

                                        @php
                                            $optionText = 'option_' . strtolower($option);

                                            $isSelected =
                                                $answer &&
                                                $answer->selected_answer === $option;

                                            $isCorrectOption =
                                                $question->correct_answer === $option;
                                        @endphp

                                        <div class="rounded-lg border p-3
                                            @if($isCorrectOption)
                                                border-green-200 bg-green-50
                                            @elseif($isSelected)
                                                border-red-200 bg-red-50
                                            @else
                                                border-[#e4e8ef] bg-white
                                            @endif
                                        ">

                                            <div class="flex items-start gap-2">

                                                <span class="font-bold
                                                    @if($isCorrectOption)
                                                        text-green-700
                                                    @elseif($isSelected)
                                                        text-red-700
                                                    @else
                                                        text-[#2874b9]
                                                    @endif
                                                ">
                                                    {{ $option }}.
                                                </span>

                                                <span class="text-sm leading-5 text-[#344054]">
                                                    {{ $question->$optionText }}
                                                </span>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                                <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 text-xs">

                                    <span class="text-[#667085]">
                                        Your answer:
                                        <strong class="text-[#1f2937]">
                                            {{ $answer?->selected_answer ?? 'Not answered' }}
                                        </strong>
                                    </span>

                                    <span class="text-[#667085]">
                                        Correct answer:
                                        <strong class="text-green-700">
                                            {{ $question->correct_answer }}
                                        </strong>
                                    </span>

                                    <span class="text-[#667085]">
                                        Marks:
                                        <strong class="text-[#1f2937]">
                                            {{ number_format((float) ($answer?->obtained_marks ?? 0), 2) }}
                                        </strong>
                                    </span>

                                </div>

                                @if($question->explanation)

                                    <div class="mt-4 rounded-lg bg-[#f8fafc] p-3">
                                        <p class="text-xs font-semibold text-[#667085]">
                                            Explanation
                                        </p>

                                        <p class="mt-1 text-sm leading-6 text-[#344054]">
                                            {{ $question->explanation }}
                                        </p>
                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- Bottom Actions --}}
        <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('student.tests.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-5 py-2.5 text-sm font-semibold text-[#667085] transition hover:bg-gray-50">
                <i data-lucide="list" class="h-4 w-4"></i>
                All Tests
            </a>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f]">
                <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
                Dashboard
            </a>

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
