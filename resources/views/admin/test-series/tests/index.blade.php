@extends('admin.layouts.app')

@section('title', 'Tests')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
            <div class="mb-1 flex items-center gap-2 text-xs text-gray-500">
                <a
                    href="{{ route('admin.test-series.index') }}"
                    class="cursor-pointer transition hover:text-[#2874b9]"
                >
                    Test Series
                </a>

                <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>

                <span class="truncate">{{ $testSeries->name }}</span>
            </div>

            <h1 class="text-2xl font-bold text-[#111827]">Tests</h1>
            <p class="mt-1 text-sm text-gray-500">Manage tests in this series</p>
        </div>

        <button
            type="button"
            onclick="openAddModal()"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639d]"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add Test
        </button>
    </div>

    {{-- Series Info --}}
    <div class="rounded-xl border border-blue-100 bg-blue-50/60 p-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white text-[#2874b9] shadow-sm">
                    <i data-lucide="layers-3" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="truncate text-sm font-semibold text-[#111827]">
                            {{ $testSeries->name }}
                        </p>

                        @if($testSeries->is_free)
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-0.5 text-[10px] font-semibold text-green-700">
                                <i data-lucide="unlock" class="h-3 w-3"></i>
                                FREE SERIES
                            </span>
                        @endif
                    </div>

                    @if($testSeries->subject)
                        <p class="mt-0.5 text-xs text-gray-500">{{ $testSeries->subject }}</p>
                    @endif
                </div>
            </div>

            <div class="text-left sm:text-right">
                <p class="text-xs text-gray-500">Total Tests</p>
                <p class="text-lg font-bold text-[#2874b9]">{{ $tests->total() }}</p>
            </div>
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
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">
            <div class="flex items-center gap-2 text-sm font-semibold text-red-700">
                <i data-lucide="circle-alert" class="h-5 w-5"></i>
                Please fix the following errors:
            </div>

            <ul class="mt-2 list-disc space-y-1 pl-6 text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tests --}}
    <div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">
        {{-- Desktop --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left">
                <thead class="border-b border-[#e4e8ef] bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Test</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Questions</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Marks</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Duration</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Access</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#e4e8ef]">
                    @forelse($tests as $test)
                        <tr class="transition hover:bg-gray-50">
                            {{-- Test --}}
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[#111827]">
                                    {{ $test->name }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    Pass:
                                    {{ rtrim(rtrim(number_format((float) $test->passing_marks, 2), '0'), '.') }}
                                </div>
                            </td>

                            {{-- Questions --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 text-sm text-gray-700">
                                    <i data-lucide="list-checks" class="h-4 w-4 text-gray-400"></i>
                                    {{ $test->total_questions }}
                                </span>
                            </td>

                            {{-- Marks --}}
                            <td class="px-5 py-4">
                                <div class="text-sm font-medium text-gray-700">
                                    {{ rtrim(rtrim(number_format((float) $test->total_marks, 2), '0'), '.') }}
                                </div>

                                @if($test->negative_marking)
                                    <div class="mt-0.5 text-[11px] text-red-500">
                                        -{{ rtrim(rtrim(number_format((float) $test->negative_marks, 2), '0'), '.') }}
                                        negative
                                    </div>
                                @endif
                            </td>

                            {{-- Duration --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 text-sm text-gray-700">
                                    <i data-lucide="clock-3" class="h-4 w-4 text-gray-400"></i>
                                    {{ $test->duration }} min
                                </span>
                            </td>

                            {{-- Access --}}
                            <td class="px-5 py-4">
                                @if($test->is_free || $testSeries->is_free)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        <i data-lucide="unlock" class="h-3.5 w-3.5"></i>
                                        FREE
                                    </span>

                                    @if($testSeries->is_free && !$test->is_free)
                                        <div class="mt-1 text-[10px] text-gray-400">
                                            Series access
                                        </div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">
                                        <i data-lucide="lock" class="h-3.5 w-3.5"></i>
                                        PAID
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4">
                                <form
                                    method="POST"
                                    action="{{ route('admin.tests.status', $test) }}"
                                    class="test-status-form"
                                    data-message="Are you sure you want to {{ $test->status ? 'deactivate' : 'activate' }} this test?"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold transition {{ $test->status ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full {{ $test->status ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ $test->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.questions.index', $test) }}"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                    >
                                        <i data-lucide="list-checks" class="h-4 w-4"></i>
                                        Questions
                                    </a>

                                    <button
                                        type="button"
                                        onclick="openEditModal(
                                            {{ $test->id }},
                                            @js($test->name),
                                            {{ $test->duration }},
                                            {{ $test->total_questions }},
                                            {{ $test->total_marks }},
                                            {{ $test->passing_marks }},
                                            {{ $test->negative_marking ? 'true' : 'false' }},
                                            {{ $test->negative_marks }},
                                            @js($test->starts_at?->format('Y-m-d\TH:i')),
                                            @js($test->ends_at?->format('Y-m-d\TH:i')),
                                            {{ $test->is_free ? 'true' : 'false' }}
                                        )"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-[#2874b9] transition hover:bg-blue-100"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                        Edit
                                    </button>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.tests.destroy', $test) }}"
                                        class="delete-test-form"
                                        data-message="Are you sure you want to delete this test?"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete"
                                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-600 transition hover:bg-red-100"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-[#2874b9]">
                                        <i data-lucide="file-question" class="h-6 w-6"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-gray-800">No tests found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Add your first test to this series.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="divide-y divide-[#e4e8ef] md:hidden">
            @forelse($tests as $test)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="truncate font-semibold text-[#111827]">
                                {{ $test->name }}
                            </h3>

                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                <p class="text-xs text-gray-500">
                                    {{ $test->total_questions }} Questions • {{ $test->duration }} min
                                </p>

                                @if($test->is_free || $testSeries->is_free)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-[10px] font-semibold text-green-700">
                                        <i data-lucide="unlock" class="h-3 w-3"></i>
                                        FREE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600">
                                        <i data-lucide="lock" class="h-3 w-3"></i>
                                        PAID
                                    </span>
                                @endif
                            </div>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('admin.tests.status', $test) }}"
                            class="test-status-form"
                            data-message="Are you sure you want to {{ $test->status ? 'deactivate' : 'activate' }} this test?"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="shrink-0 cursor-pointer rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $test->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}"
                            >
                                {{ $test->status ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </div>

                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <div class="rounded-lg bg-gray-50 p-2.5">
                            <p class="text-[10px] uppercase tracking-wide text-gray-400">Marks</p>
                            <p class="mt-0.5 text-sm font-semibold text-gray-700">
                                {{ rtrim(rtrim(number_format((float) $test->total_marks, 2), '0'), '.') }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-50 p-2.5">
                            <p class="text-[10px] uppercase tracking-wide text-gray-400">Pass</p>
                            <p class="mt-0.5 text-sm font-semibold text-gray-700">
                                {{ rtrim(rtrim(number_format((float) $test->passing_marks, 2), '0'), '.') }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-gray-50 p-2.5">
                            <p class="text-[10px] uppercase tracking-wide text-gray-400">Duration</p>
                            <p class="mt-0.5 text-sm font-semibold text-gray-700">
                                {{ $test->duration }} min
                            </p>
                        </div>
                    </div>

                    @if($test->negative_marking)
                        <div class="mt-2 text-[11px] text-red-500">
                            Negative marking:
                            -{{ rtrim(rtrim(number_format((float) $test->negative_marks, 2), '0'), '.') }}
                        </div>
                    @endif

                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <a
                            href="{{ route('admin.questions.index', $test) }}"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-200 px-2 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                        >
                            <i data-lucide="list-checks" class="h-4 w-4"></i>
                            Questions
                        </a>

                        <button
                            type="button"
                            onclick="openEditModal(
                                {{ $test->id }},
                                @js($test->name),
                                {{ $test->duration }},
                                {{ $test->total_questions }},
                                {{ $test->total_marks }},
                                {{ $test->passing_marks }},
                                {{ $test->negative_marking ? 'true' : 'false' }},
                                {{ $test->negative_marks }},
                                @js($test->starts_at?->format('Y-m-d\TH:i')),
                                @js($test->ends_at?->format('Y-m-d\TH:i')),
                                {{ $test->is_free ? 'true' : 'false' }}
                            )"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2 py-2.5 text-xs font-medium text-[#2874b9] hover:bg-blue-100"
                        >
                            <i data-lucide="pencil" class="h-4 w-4"></i>
                            Edit
                        </button>

                        <form
                            method="POST"
                            action="{{ route('admin.tests.destroy', $test) }}"
                            class="delete-test-form"
                            data-message="Are you sure you want to delete this test?"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-2 py-2.5 text-xs font-medium text-red-600 hover:bg-red-100"
                            >
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-14 text-center">
                    <i data-lucide="file-question" class="mx-auto h-8 w-8 text-gray-300"></i>
                    <p class="mt-3 text-sm font-medium text-gray-700">No tests found</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($tests->hasPages())
            <div class="border-t border-[#e4e8ef] px-4 py-3">
                {{ $tests->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Add Modal --}}
<div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black/40 px-4 py-6">
    <div class="my-auto w-full max-w-2xl rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <h2 class="text-lg font-semibold text-[#111827]">Add Test</h2>
                <p class="mt-0.5 text-xs text-gray-500">
                    Add a test to {{ $testSeries->name }}
                </p>
            </div>

            <button
                type="button"
                onclick="closeAddModal()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.tests.store', $testSeries) }}" class="space-y-4 p-5">
            @csrf

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                    Test Name
                </label>

                <input
                    type="text"
                    name="name"
                    required
                    placeholder="e.g. RSCIT Mock Test 1"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Total Questions
                    </label>

                    <input
                        type="number"
                        name="total_questions"
                        value="0"
                        min="0"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Duration (Minutes)
                    </label>

                    <input
                        type="number"
                        name="duration"
                        value="30"
                        min="1"
                        max="600"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Total Marks
                    </label>

                    <input
                        type="number"
                        name="total_marks"
                        value="0"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Passing Marks
                    </label>

                    <input
                        type="number"
                        name="passing_marks"
                        value="0"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            {{-- Negative Marking --}}
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        type="checkbox"
                        name="negative_marking"
                        value="1"
                        onchange="toggleNegative('add')"
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <span class="text-sm font-medium text-gray-700">
                        Enable negative marking
                    </span>
                </label>

                <div id="addNegativeBox" class="mt-3 hidden">
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Negative Marks
                    </label>

                    <input
                        type="number"
                        name="negative_marks"
                        value="0"
                        min="0"
                        step="0.01"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            {{-- Free Access --}}
            <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-green-200 bg-green-50/60 p-3.5">
                <input
                    type="checkbox"
                    name="is_free"
                    value="1"
                    class="mt-0.5 h-4 w-4 cursor-pointer rounded border-gray-300 text-green-600 focus:ring-green-500"
                >

                <span>
                    <span class="flex items-center gap-1.5 text-sm font-semibold text-gray-800">
                        <i data-lucide="unlock" class="h-4 w-4 text-green-600"></i>
                        Available without subscription
                    </span>

                    <span class="mt-0.5 block text-xs leading-5 text-gray-500">
                        This test can be attempted without purchasing a test subscription.
                    </span>
                </span>
            </label>

            {{-- Availability --}}
            <div>
                <p class="mb-2 text-xs font-semibold text-gray-700">
                    Availability
                </p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] text-gray-500">
                            Start
                        </label>

                        <input
                            type="datetime-local"
                            name="starts_at"
                            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11px] text-gray-500">
                            End
                        </label>

                        <input
                            type="datetime-local"
                            name="ends_at"
                            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
                <button
                    type="button"
                    onclick="closeAddModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#21639d]"
                >
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Create Test
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black/40 px-4 py-6">
    <div class="my-auto w-full max-w-2xl rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <h2 class="text-lg font-semibold text-[#111827]">Edit Test</h2>
                <p class="mt-0.5 text-xs text-gray-500">Update test details</p>
            </div>

            <button
                type="button"
                onclick="closeEditModal()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form id="editForm" method="POST" class="space-y-4 p-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                    Test Name
                </label>

                <input
                    id="editName"
                    type="text"
                    name="name"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Total Questions
                    </label>

                    <input
                        id="editTotalQuestions"
                        type="number"
                        name="total_questions"
                        min="0"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Duration (Minutes)
                    </label>

                    <input
                        id="editDuration"
                        type="number"
                        name="duration"
                        min="1"
                        max="600"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Total Marks
                    </label>

                    <input
                        id="editTotalMarks"
                        type="number"
                        name="total_marks"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>

                <div>
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Passing Marks
                    </label>

                    <input
                        id="editPassingMarks"
                        type="number"
                        name="passing_marks"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            {{-- Negative Marking --}}
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                <label class="flex cursor-pointer items-center gap-2">
                    <input
                        id="editNegativeMarking"
                        type="checkbox"
                        name="negative_marking"
                        value="1"
                        onchange="toggleNegative('edit')"
                        class="h-4 w-4 cursor-pointer rounded border-gray-300 text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <span class="text-sm font-medium text-gray-700">
                        Enable negative marking
                    </span>
                </label>

                <div id="editNegativeBox" class="mt-3 hidden">
                    <label class="mb-1.5 block text-xs font-semibold text-gray-700">
                        Negative Marks
                    </label>

                    <input
                        id="editNegativeMarks"
                        type="number"
                        name="negative_marks"
                        min="0"
                        step="0.01"
                        class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>

            {{-- Free Access --}}
            <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-green-200 bg-green-50/60 p-3.5">
                <input
                    id="editIsFree"
                    type="checkbox"
                    name="is_free"
                    value="1"
                    class="mt-0.5 h-4 w-4 cursor-pointer rounded border-gray-300 text-green-600 focus:ring-green-500"
                >

                <span>
                    <span class="flex items-center gap-1.5 text-sm font-semibold text-gray-800">
                        <i data-lucide="unlock" class="h-4 w-4 text-green-600"></i>
                        Available without subscription
                    </span>

                    <span class="mt-0.5 block text-xs leading-5 text-gray-500">
                        This test can be attempted without purchasing a test subscription.
                    </span>
                </span>
            </label>

            {{-- Availability --}}
            <div>
                <p class="mb-2 text-xs font-semibold text-gray-700">
                    Availability
                </p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-[11px] text-gray-500">
                            Start
                        </label>

                        <input
                            id="editStartsAt"
                            type="datetime-local"
                            name="starts_at"
                            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>

                    <div>
                        <label class="mb-1.5 block text-[11px] text-gray-500">
                            End
                        </label>

                        <input
                            id="editEndsAt"
                            type="datetime-local"
                            name="ends_at"
                            class="w-full cursor-pointer rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-2 border-t border-gray-100 pt-4">
                <button
                    type="button"
                    onclick="closeEditModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#21639d]"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Confirmation Modal --}}
<div id="confirmModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-sm rounded-2xl border border-gray-200 bg-white shadow-2xl">
        <div class="flex items-start gap-3 px-5 pt-5">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-50">
                <i id="confirmIcon" data-lucide="triangle-alert" class="h-5 w-5 text-red-600"></i>
            </div>

            <div class="min-w-0">
                <h3 id="confirmTitle" class="text-base font-bold text-gray-900">
                    Confirm Action
                </h3>

                <p id="confirmMessage" class="mt-1 text-sm leading-5 text-gray-500">
                    Are you sure you want to continue?
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
                <i id="confirmButtonIcon" data-lucide="trash-2" class="h-4 w-4"></i>
                <span id="confirmButtonText">Delete</span>
            </button>
        </div>
    </div>
</div>

<script>
    let confirmForm = null;

    function openAddModal() {
        const modal = document.getElementById('addModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        const modal = document.getElementById('addModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    function openEditModal(
        id,
        name,
        duration,
        totalQuestions,
        totalMarks,
        passingMarks,
        negativeMarking,
        negativeMarks,
        startsAt,
        endsAt,
        isFree
    ) {
        document.getElementById('editForm').action =
            "{{ url('/admin/tests') }}/" + id;

        document.getElementById('editName').value = name ?? '';
        document.getElementById('editDuration').value = duration ?? 30;
        document.getElementById('editTotalQuestions').value = totalQuestions ?? 0;
        document.getElementById('editTotalMarks').value = totalMarks ?? 0;
        document.getElementById('editPassingMarks').value = passingMarks ?? 0;

        document.getElementById('editNegativeMarking').checked =
            negativeMarking === true;

        document.getElementById('editNegativeMarks').value =
            negativeMarks ?? 0;

        document.getElementById('editStartsAt').value =
            startsAt ?? '';

        document.getElementById('editEndsAt').value =
            endsAt ?? '';

        document.getElementById('editIsFree').checked =
            isFree === true;

        toggleNegative('edit');

        const modal = document.getElementById('editModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }

    function toggleNegative(type) {
        if (type === 'add') {
            const checkbox = document.querySelector(
                '#addModal input[name="negative_marking"]'
            );

            const box = document.getElementById('addNegativeBox');

            box.classList.toggle('hidden', !checkbox.checked);
        }

        if (type === 'edit') {
            const checkbox =
                document.getElementById('editNegativeMarking');

            const box =
                document.getElementById('editNegativeBox');

            box.classList.toggle('hidden', !checkbox.checked);
        }
    }

    function openConfirmModal(form, type, message) {
        confirmForm = form;

        const modal = document.getElementById('confirmModal');
        const title = document.getElementById('confirmTitle');
        const messageElement = document.getElementById('confirmMessage');
        const button = document.getElementById('confirmOkButton');
        const buttonText = document.getElementById('confirmButtonText');
        const icon = document.getElementById('confirmIcon');
        const buttonIcon = document.getElementById('confirmButtonIcon');

        messageElement.textContent = message;

        if (type === 'delete') {
            title.textContent = 'Confirm Delete';
            buttonText.textContent = 'Delete';

            button.className =
                'inline-flex cursor-pointer items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700';

            icon.setAttribute('data-lucide', 'triangle-alert');
            icon.className = 'h-5 w-5 text-red-600';

            buttonIcon.setAttribute('data-lucide', 'trash-2');
        } else {
            title.textContent = 'Confirm Status Change';
            buttonText.textContent = 'Continue';

            button.className =
                'inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639d]';

            icon.setAttribute('data-lucide', 'circle-help');
            icon.className = 'h-5 w-5 text-[#2874b9]';

            buttonIcon.setAttribute('data-lucide', 'check');
        }

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

    document.querySelectorAll('.delete-test-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            openConfirmModal(
                form,
                'delete',
                form.dataset.message ||
                    'Are you sure you want to delete this test?'
            );
        });
    });

    document.querySelectorAll('.test-status-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            openConfirmModal(
                form,
                'status',
                form.dataset.message ||
                    'Are you sure you want to change this test status?'
            );
        });
    });

    document.getElementById('confirmCancelButton').addEventListener(
        'click',
        function() {
            closeConfirmModal();
        }
    );

    document.getElementById('confirmOkButton').addEventListener(
        'click',
        function() {
            if (!confirmForm) {
                return;
            }

            const form = confirmForm;

            confirmForm = null;

            form.submit();
        }
    );

    document.getElementById('confirmModal').addEventListener(
        'click',
        function(event) {
            if (event.target === this) {
                closeConfirmModal();
            }
        }
    );

    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Escape') {
            return;
        }

        if (confirmForm) {
            closeConfirmModal();
            return;
        }

        if (!document.getElementById('addModal').classList.contains('hidden')) {
            closeAddModal();
        }

        if (!document.getElementById('editModal').classList.contains('hidden')) {
            closeEditModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection
