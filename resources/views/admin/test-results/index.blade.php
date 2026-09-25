@extends('admin.layouts.app')

@section('title', 'Test Results')

@section('content')

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#1f2937]">
                Test Results
            </h1>

            <p class="mt-1 text-sm text-[#667085]">
                View student test attempts and performance.
            </p>
        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-[#e4e8ef] bg-white p-4 shadow-sm">

        <form method="GET"
              action="{{ route('admin.test-results.index') }}"
              class="grid gap-3 md:grid-cols-4">

            {{-- Search --}}
            <div>

                <label class="mb-1.5 block text-xs font-semibold text-[#667085]">
                    Student
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Name or mobile"
                    class="w-full rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                >

            </div>


            {{-- Test --}}
            <div>

                <label class="mb-1.5 block text-xs font-semibold text-[#667085]">
                    Test
                </label>

                <select
                    name="test_id"
                    class="w-full rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-sm text-[#1f2937] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                >

                    <option value="">
                        All Tests
                    </option>

                    @foreach($tests as $test)

                        <option
                            value="{{ $test->id }}"
                            @selected(request('test_id') == $test->id)
                        >
                            {{ $test->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Result --}}
            <div>

                <label class="mb-1.5 block text-xs font-semibold text-[#667085]">
                    Result
                </label>

                <select
                    name="result"
                    class="w-full rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-sm text-[#1f2937] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                >

                    <option value="">
                        All Results
                    </option>

                    <option
                        value="passed"
                        @selected(request('result') === 'passed')
                    >
                        Passed
                    </option>

                    <option
                        value="failed"
                        @selected(request('result') === 'failed')
                    >
                        Failed
                    </option>

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21649f]"
                >

                    <i data-lucide="search" class="h-4 w-4"></i>

                    Filter

                </button>


                <a
                    href="{{ route('admin.test-results.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-[#667085] transition hover:bg-gray-50"
                    title="Reset"
                >

                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>

                </a>

            </div>

        </form>

    </div>


    {{-- Results --}}
    <div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">

        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full">

                <thead class="border-b border-[#e4e8ef] bg-[#f8fafc]">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Student
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Test
                        </th>

                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Score
                        </th>

                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Percentage
                        </th>

                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Result
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#edf0f4]">

                    @forelse($attempts as $attempt)

                        <tr class="transition hover:bg-[#f8fbff]">

                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#eef6ff] text-sm font-bold text-[#2874b9]">
                                        {{ strtoupper(substr($attempt->user->name ?? 'S', 0, 1)) }}
                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-[#1f2937]">
                                            {{ $attempt->user->name ?? 'Unknown Student' }}
                                        </p>

                                        <p class="text-sm font-semibold text-[#1f2937]">
                                            {{ $attempt->user->email ?? 'Unknown eamil' }}
                                        </p>

                                        <p class="text-xs text-[#667085]">
                                            {{ $attempt->user->mobile ?? '-' }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <td class="px-5 py-4">

                                <p class="text-sm font-semibold text-[#1f2937]">
                                    {{ $attempt->test->name ?? '-' }}
                                </p>

                                <p class="mt-0.5 text-xs text-[#667085]">
                                    {{ $attempt->test->testSeries->name ?? 'Test Series' }}
                                </p>

                            </td>


                            <td class="px-5 py-4 text-center">

                                <span class="text-sm font-bold text-[#1f2937]">
                                    {{ number_format((float) $attempt->obtained_marks, 2) }}
                                </span>

                                <span class="text-xs text-[#667085]">
                                    /
                                    {{ number_format((float) $attempt->total_marks, 2) }}
                                </span>

                            </td>


                            <td class="px-5 py-4 text-center">

                                <span class="text-sm font-semibold text-[#1f2937]">
                                    {{ number_format((float) $attempt->percentage, 2) }}%
                                </span>

                            </td>


                            <td class="px-5 py-4 text-center">

                                @if($attempt->passed)

                                    <span class="inline-flex items-center gap-1 rounded-md bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        <i data-lucide="check-circle" class="h-3.5 w-3.5"></i>
                                        Passed
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1 rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        <i data-lucide="x-circle" class="h-3.5 w-3.5"></i>
                                        Failed
                                    </span>

                                @endif

                            </td>


                            <td class="px-5 py-4 text-right">

                                <a
                                    href="{{ route('admin.test-results.show', $attempt) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-xs font-semibold text-[#667085] transition hover:border-[#2874b9] hover:text-[#2874b9]"
                                >

                                    <i data-lucide="eye" class="h-4 w-4"></i>

                                    View

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-5 py-12 text-center">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#667085]">

                                    <i data-lucide="clipboard-list"
                                       class="h-6 w-6"></i>

                                </div>

                                <p class="mt-3 text-sm font-semibold text-[#1f2937]">
                                    No test results found
                                </p>

                                <p class="mt-1 text-xs text-[#667085]">
                                    Submitted test attempts will appear here.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Mobile Cards --}}
        <div class="divide-y divide-[#edf0f4] md:hidden">

            @forelse($attempts as $attempt)

                <div class="p-4">

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-[#1f2937]">
                                {{ $attempt->student->name ?? 'Unknown Student' }}
                            </p>

                            <p class="mt-1 text-xs text-[#667085]">
                                {{ $attempt->student->mobile ?? '-' }}
                            </p>

                        </div>


                        @if($attempt->passed)

                            <span class="shrink-0 rounded-md bg-green-50 px-2 py-1 text-xs font-semibold text-green-700">
                                Passed
                            </span>

                        @else

                            <span class="shrink-0 rounded-md bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">
                                Failed
                            </span>

                        @endif

                    </div>


                    <div class="mt-4 rounded-lg bg-[#f8fafc] p-3">

                        <p class="text-xs font-semibold text-[#2874b9]">
                            {{ $attempt->test->name ?? '-' }}
                        </p>

                        <p class="mt-1 text-xs text-[#667085]">
                            {{ $attempt->test->testSeries->name ?? 'Test Series' }}
                        </p>

                    </div>


                    <div class="mt-3 grid grid-cols-3 gap-2">

                        <div>
                            <p class="text-[11px] text-[#667085]">
                                Score
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                {{ number_format((float) $attempt->obtained_marks, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] text-[#667085]">
                                Percentage
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                {{ number_format((float) $attempt->percentage, 2) }}%
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] text-[#667085]">
                                Questions
                            </p>

                            <p class="mt-0.5 text-sm font-bold text-[#1f2937]">
                                {{ $attempt->total_questions }}
                            </p>
                        </div>

                    </div>


                    <a
                        href="{{ route('admin.test-results.show', $attempt) }}"
                        class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-xs font-semibold text-[#667085] transition hover:border-[#2874b9] hover:text-[#2874b9]"
                    >

                        <i data-lucide="eye" class="h-4 w-4"></i>

                        View Result

                    </a>

                </div>

            @empty

                <div class="px-5 py-12 text-center">

                    <i data-lucide="clipboard-list"
                       class="mx-auto h-7 w-7 text-[#98a2b3]"></i>

                    <p class="mt-3 text-sm font-semibold text-[#1f2937]">
                        No test results found
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- Pagination --}}
    @if($attempts->hasPages())

        <div>
            {{ $attempts->links() }}
        </div>

    @endif

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
