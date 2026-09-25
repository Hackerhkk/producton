@extends('admin.layouts.app')

@section('title', 'Questions')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <a href="{{ route('admin.test-series.index') }}" class="cursor-pointer hover:text-[#2874b9]">
                    Test Series
                </a>
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                <a href="{{ route('admin.tests.index', $test->testSeries) }}" class="cursor-pointer hover:text-[#2874b9]">
                    {{ $test->testSeries->name }}
                </a>
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                <span class="text-gray-700">{{ $test->name }}</span>
            </div>
            <h1 class="text-2xl font-bold text-[#111827]">Questions</h1>
            <p class="mt-1 text-sm text-gray-500">Manage questions for this test.</p>
        </div>

        <button
            type="button"
            onclick="openAddModal()"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21649f]"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add Question
        </button>

<button
    type="button"
    onclick="openImportModal()"
    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 cursor-pointer"
>
    <i data-lucide="file-spreadsheet" class="h-4 w-4"></i>
    Import Excel
</button>

    </div>

    {{-- Test Info --}}
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500">Test</p>
            <p class="mt-1 truncate text-sm font-semibold text-gray-900">{{ $test->name }}</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500">Questions</p>
            <p class="mt-1 text-lg font-bold text-gray-900">{{ $test->questions()->count() }}</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500">Duration</p>
            <p class="mt-1 text-lg font-bold text-gray-900">{{ $test->duration }} min</p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-medium text-gray-500">Marks</p>
            <p class="mt-1 text-lg font-bold text-gray-900">{{ $test->total_marks }}</p>
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i data-lucide="circle-check" class="h-5 w-5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="mb-2 flex items-center gap-2 font-semibold">
                <i data-lucide="triangle-alert" class="h-5 w-5"></i>
                Please fix the following errors:
            </div>
            <ul class="list-inside list-disc space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

{{-- ================= REMAINING QUESTIONS ================= --}}

@if(session('remaining_count') > 0 && session('remaining_file'))

    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4">

        <div class="flex items-start gap-3">

            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600"
            >
                <i
                    data-lucide="download"
                    class="h-5 w-5"
                ></i>
            </div>

            <div class="flex-1">

                <h3 class="text-sm font-bold text-gray-900">
                    {{ session('remaining_count') }}
                    Questions Remaining
                </h3>

                <p class="mt-1 text-sm text-gray-600">
                    Test question limit reached. These questions
                    were not added and are available in a separate Excel file.
                </p>

                <a
                    href="{{ route('admin.questions.import.remaining', [
                        'test' => $test,
                        'file' => session('remaining_file')
                    ]) }}"
                    class="mt-3 inline-flex items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700 cursor-pointer"
                >

                    <i
                        data-lucide="download"
                        class="h-4 w-4"
                    ></i>

                    Download Remaining Questions
                </a>

            </div>

        </div>

    </div>

@endif


    {{-- Desktop Table --}}
    <div class="hidden overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm lg:block">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-gray-200 bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">#</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Question</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Correct</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Marks</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($questions as $index => $question)
                        <tr class="transition hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-500">
                                {{ $questions->firstItem() + $index }}
                            </td>

                            <td class="max-w-xl px-5 py-4">
                                <p class="line-clamp-2 text-sm font-medium text-gray-900">
                                    {{ $question->question }}
                                </p>

                                <div class="mt-2 grid grid-cols-2 gap-x-5 gap-y-1 text-xs text-gray-500">
                                    <span><strong>A.</strong> {{ $question->option_a }}</span>
                                    <span><strong>B.</strong> {{ $question->option_b }}</span>
                                    <span><strong>C.</strong> {{ $question->option_c }}</span>
                                    <span><strong>D.</strong> {{ $question->option_d }}</span>
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700">
                                    {{ $question->correct_answer }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $question->marks }}</div>
                            </td>

                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        onclick='openEditModal(@json($question))'
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="delete-question-form">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                                    <i data-lucide="file-question" class="h-6 w-6 text-gray-500"></i>
                                </div>
                                <h3 class="mt-4 text-sm font-semibold text-gray-900">No questions yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Add your first question to this test.</p>
                                <button
                                    type="button"
                                    onclick="openAddModal()"
                                    class="mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2 text-sm font-medium text-white hover:bg-[#21649f]"
                                >
                                    <i data-lucide="plus" class="h-4 w-4"></i>
                                    Add Question
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="space-y-3 lg:hidden">
        @forelse($questions as $index => $question)
            <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                <div class="flex min-w-0 gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-xs font-bold text-[#2874b9]">
                        {{ $questions->firstItem() + $index }}
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold leading-5 text-gray-900">
                            {{ $question->question }}
                        </p>

                        <div class="mt-3 space-y-1.5 text-xs text-gray-600">
                            <div><span class="font-semibold">A.</span> {{ $question->option_a }}</div>
                            <div><span class="font-semibold">B.</span> {{ $question->option_b }}</div>
                            <div><span class="font-semibold">C.</span> {{ $question->option_c }}</div>
                            <div><span class="font-semibold">D.</span> {{ $question->option_d }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2 border-t border-gray-100 pt-3">
                    <span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700">
                        Correct: {{ $question->correct_answer }}
                    </span>

                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                        {{ $question->marks }} marks
                    </span>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <button
                        type="button"
                        onclick='openEditModal(@json($question))'
                        class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                    >
                        <i data-lucide="pencil" class="h-4 w-4"></i>
                        Edit
                    </button>

                    <form method="POST" action="{{ route('admin.questions.destroy', $question) }}" class="delete-question-form">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="inline-flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-red-200 px-3 py-2.5 text-xs font-medium text-red-600 hover:bg-red-50"
                        >
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white px-5 py-12 text-center shadow-sm">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">
                    <i data-lucide="file-question" class="h-6 w-6 text-gray-500"></i>
                </div>
                <h3 class="mt-4 text-sm font-semibold text-gray-900">No questions yet</h3>
                <p class="mt-1 text-sm text-gray-500">Add your first question to this test.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($questions->hasPages())
        <div class="rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
            {{ $questions->links() }}
        </div>
    @endif
</div>

{{-- Add Question Modal --}}
<div id="addQuestionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-full items-center justify-center bg-black/40 p-4" onclick="closeAddModal()">
        <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Add Question</h2>
                    <p class="mt-0.5 text-xs text-gray-500">Add question and answer options.</p>
                </div>

                <button
                    type="button"
                    onclick="closeAddModal()"
                    class="cursor-pointer rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700"
                >
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.questions.store', $test) }}" class="max-h-[80vh] overflow-y-auto">
                @csrf

                <div class="space-y-5 p-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Question</label>
                        <textarea
                            name="question"
                            rows="3"
                            required
                            placeholder="Enter question..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >{{ old('question') }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Options</label>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option A</label>
                                <input
                                    type="text"
                                    name="option_a"
                                    value="{{ old('option_a') }}"
                                    required
                                    placeholder="Option A"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option B</label>
                                <input
                                    type="text"
                                    name="option_b"
                                    value="{{ old('option_b') }}"
                                    required
                                    placeholder="Option B"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option C</label>
                                <input
                                    type="text"
                                    name="option_c"
                                    value="{{ old('option_c') }}"
                                    required
                                    placeholder="Option C"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option D</label>
                                <input
                                    type="text"
                                    name="option_d"
                                    value="{{ old('option_d') }}"
                                    required
                                    placeholder="Option D"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Correct Answer</label>
                            <select
                                name="correct_answer"
                                required
                                class="w-full cursor-pointer rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                            >
                                <option value="">Select</option>
                                <option value="A" @selected(old('correct_answer') === 'A')>A</option>
                                <option value="B" @selected(old('correct_answer') === 'B')>B</option>
                                <option value="C" @selected(old('correct_answer') === 'C')>C</option>
                                <option value="D" @selected(old('correct_answer') === 'D')>D</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Marks</label>
                            <input
                                type="number"
                                name="marks"
                                value="{{ old('marks', 1) }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Explanation
                            <span class="font-normal text-gray-400">(Optional)</span>
                        </label>
                        <textarea
                            name="explanation"
                            rows="3"
                            placeholder="Explain the correct answer..."
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >{{ old('explanation') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-5 py-4">
                    <button
                        type="button"
                        onclick="closeAddModal()"
                        class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#21649f]"
                    >
                        <i data-lucide="plus" class="h-4 w-4"></i>
                        Add Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Question Modal --}}
<div id="editQuestionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex min-h-full items-center justify-center bg-black/40 p-4" onclick="closeEditModal()">
        <div class="w-full max-w-2xl rounded-2xl bg-white shadow-xl" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Edit Question</h2>
                    <p class="mt-0.5 text-xs text-gray-500">Update question and answer options.</p>
                </div>

                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="cursor-pointer rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700"
                >
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>

            <form id="editQuestionForm" method="POST" class="max-h-[80vh] overflow-y-auto">
                @csrf
                @method('PUT')

                <div class="space-y-5 p-5">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Question</label>
                        <textarea
                            id="edit_question"
                            name="question"
                            rows="3"
                            required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        ></textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700">Options</label>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option A</label>
                                <input
                                    id="edit_option_a"
                                    type="text"
                                    name="option_a"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option B</label>
                                <input
                                    id="edit_option_b"
                                    type="text"
                                    name="option_b"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option C</label>
                                <input
                                    id="edit_option_c"
                                    type="text"
                                    name="option_c"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <div>
                                <label class="mb-1 block text-xs font-medium text-gray-500">Option D</label>
                                <input
                                    id="edit_option_d"
                                    type="text"
                                    name="option_d"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Correct Answer</label>
                            <select
                                id="edit_correct_answer"
                                name="correct_answer"
                                required
                                class="w-full cursor-pointer rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                            >
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700">Marks</label>
                            <input
                                id="edit_marks"
                                type="number"
                                name="marks"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">
                            Explanation
                            <span class="font-normal text-gray-400">(Optional)</span>
                        </label>
                        <textarea
                            id="edit_explanation"
                            name="explanation"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        ></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-5 py-4">
                    <button
                        type="button"
                        onclick="closeEditModal()"
                        class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#21649f]"
                    >
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Custom Confirmation Modal --}}
<div id="confirmModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div id="confirmModalBox" class="w-full max-w-sm rounded-2xl border border-gray-200 bg-white shadow-2xl">
        <div class="flex items-start gap-3 px-5 pt-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50">
                <i data-lucide="triangle-alert" class="h-5 w-5 text-red-600"></i>
            </div>

            <div class="min-w-0">
                <h3 class="text-base font-bold text-gray-900">Confirm Delete</h3>
                <p id="confirmMessage" class="mt-1 text-sm leading-5 text-gray-500">
                    Are you sure you want to delete this?
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 py-4">
            <button
                type="button"
                id="confirmCancelButton"
                class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
            >
                Cancel
            </button>

            <button
                type="button"
                id="confirmOkButton"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
            >
                <i data-lucide="trash-2" class="h-4 w-4"></i>
                Delete
            </button>
        </div>
    </div>
</div>
{{-- ================= IMPORT EXCEL MODAL ================= --}}

<div
    id="importExcelModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 px-4"
>
    <div
        class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
    >

        {{-- Header --}}
        <div class="flex items-center justify-between border-b px-6 py-4">

            <div>
                <h2 class="text-lg font-bold text-gray-900">
                    Import Questions
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Add multiple questions using Excel
                </p>
            </div>

            <button
                type="button"
                onclick="closeImportModal()"
                class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600 cursor-pointer"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>


        {{-- Body --}}
        <div class="space-y-5 p-6">

            {{-- Download Template --}}
            <div
                class="rounded-xl border border-blue-100 bg-blue-50 p-4"
            >

                <div class="flex items-start gap-3">

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-600"
                    >
                        <i
                            data-lucide="file-spreadsheet"
                            class="h-5 w-5"
                        ></i>
                    </div>

                    <div class="flex-1">

                        <h3 class="text-sm font-semibold text-gray-900">
                            Download Excel Template
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Use the template so your questions are imported
                            correctly.
                        </p>

                        <a
                            href="{{ route('admin.questions.import.template',$test) }}"
                            class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-[#2874b9] hover:underline cursor-pointer"
                        >
                            <i
                                data-lucide="download"
                                class="h-4 w-4"
                            ></i>

                            Download Template
                        </a>

                    </div>

                </div>

            </div>


            {{-- File Upload --}}
            <form
                method="POST"
                action="{{ route('admin.questions.import', $test) }}"
                enctype="multipart/form-data"
                id="importExcelForm"
            >

                @csrf

                <div>

                    <label
                        class="mb-2 block text-sm font-semibold text-gray-700"
                    >
                        Select Excel File
                    </label>

                    <label
                        for="excelFile"
                        class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-center transition hover:border-[#2874b9] hover:bg-blue-50"
                    >

                        <div
                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500"
                        >
                            <i
                                data-lucide="upload"
                                class="h-6 w-6"
                            ></i>
                        </div>

                        <p
                            id="excelFileName"
                            class="text-sm font-semibold text-gray-700"
                        >
                            Click to select Excel file
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            XLSX, XLS or CSV • Maximum 10 MB
                        </p>

                        <input
                            type="file"
                            name="file"
                            id="excelFile"
                            accept=".xlsx,.xls,.csv"
                            class="hidden"
                            required
                        >

                    </label>

                </div>


                {{-- Format Information --}}
                <div class="rounded-xl bg-gray-50 p-4">

                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-gray-500">
                        Excel Columns
                    </p>

                    <div class="flex flex-wrap gap-2">

                        @foreach([
                            'question',
                            'option_a',
                            'option_b',
                            'option_c',
                            'option_d',
                            'correct_answer',
                            'marks',
                            'explanation'
                        ] as $column)

                            <span
                                class="rounded-md bg-white px-2 py-1 text-xs font-medium text-gray-600 shadow-sm ring-1 ring-gray-200"
                            >
                                {{ $column }}
                            </span>

                        @endforeach

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-6 flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="closeImportModal()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 cursor-pointer"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700 cursor-pointer"
                    >
                        <i
                            data-lucide="upload"
                            class="h-4 w-4"
                        ></i>

                        Import Questions
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

<script>
    let confirmForm = null;

    function openAddModal() {
        document.getElementById('addQuestionModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        document.getElementById('addQuestionModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openEditModal(question) {
        document.getElementById('edit_question').value = question.question ?? '';
        document.getElementById('edit_option_a').value = question.option_a ?? '';
        document.getElementById('edit_option_b').value = question.option_b ?? '';
        document.getElementById('edit_option_c').value = question.option_c ?? '';
        document.getElementById('edit_option_d').value = question.option_d ?? '';
        document.getElementById('edit_correct_answer').value = question.correct_answer ?? 'A';
        document.getElementById('edit_marks').value = question.marks ?? 1;
        document.getElementById('edit_explanation').value = question.explanation ?? '';
        document.getElementById('editQuestionForm').action = "{{ url('/admin/questions') }}/" + question.id;
        document.getElementById('editQuestionModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('editQuestionModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openConfirmModal(form, message) {
        confirmForm = form;
        document.getElementById('confirmMessage').textContent = message;
        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        confirmForm = null;
    }

    document.querySelectorAll('.delete-question-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            openConfirmModal(form, 'Are you sure you want to delete this question?');
        });
    });

    document.getElementById('confirmCancelButton').addEventListener('click', function() {
        closeConfirmModal();
    });

    document.getElementById('confirmOkButton').addEventListener('click', function() {
        if (!confirmForm) {
            return;
        }

        const form = confirmForm;
        confirmForm = null;
        form.submit();
    });

    document.getElementById('confirmModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeConfirmModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Escape') {
            return;
        }

        if (confirmForm) {
            closeConfirmModal();
            return;
        }

        if (!document.getElementById('addQuestionModal').classList.contains('hidden')) {
            closeAddModal();
        }

        if (!document.getElementById('editQuestionModal').classList.contains('hidden')) {
            closeEditModal();
        }
    });


/* ================= IMPORT EXCEL MODAL ================= */

function openImportModal() {

    const modal =
        document.getElementById('importExcelModal');

    if (!modal) return;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeImportModal() {

    const modal =
        document.getElementById('importExcelModal');

    if (!modal) return;

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    const form =
        document.getElementById('importExcelForm');

    if (form) {
        form.reset();
    }

    const fileName =
        document.getElementById('excelFileName');

    if (fileName) {
        fileName.textContent =
            'Click to select Excel file';
    }
}


/* ================= EXCEL FILE NAME ================= */

const excelFile =
    document.getElementById('excelFile');

if (excelFile) {

    excelFile.addEventListener('change', function () {

        const fileName =
            document.getElementById('excelFileName');

        if (!fileName) return;

        if (this.files && this.files.length > 0) {

            fileName.textContent =
                this.files[0].name;

            fileName.classList.remove(
                'text-gray-700'
            );

            fileName.classList.add(
                'text-[#2874b9]'
            );

        } else {

            fileName.textContent =
                'Click to select Excel file';
        }
    });
}


/* ================= ESC KEY ================= */

document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {
        closeImportModal();
    }

});


/* ================= CLICK OUTSIDE ================= */

const importModal =
    document.getElementById('importExcelModal');

if (importModal) {

    importModal.addEventListener('click', function (event) {

        if (event.target === this) {
            closeImportModal();
        }

    });

}

</script>

@push('scripts')
<script>
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endpush

@endsection

