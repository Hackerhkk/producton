@extends('admin.layouts.app')

@section('title', 'Test Series')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-[#111827]">Test Series</h1>
            <p class="mt-1 text-sm text-gray-500">Create and manage your test series</p>
        </div>

        <button
            type="button"
            onclick="openAddModal()"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639d]"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add Test Series
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i data-lucide="circle-check" class="h-5 w-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Validation Errors --}}
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

    {{-- Test Series List --}}
    <div class="overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">
        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full text-left">
                <thead class="border-b border-[#e4e8ef] bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Series</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Subject</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Tests</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Access</th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#e4e8ef]">
                    @forelse($testSeries as $series)
                        <tr class="transition hover:bg-gray-50">
                            {{-- Series --}}
                            <td class="px-5 py-4">
                                <div class="font-semibold text-[#111827]">{{ $series->name }}</div>

                                @if($series->description)
                                    <div class="mt-1 max-w-md truncate text-xs text-gray-500">
                                        {{ $series->description }}
                                    </div>
                                @endif
                            </td>

                            {{-- Subject --}}
                            <td class="px-5 py-4">
                                @if($series->subject)
                                    <span class="inline-flex rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-[#2874b9]">
                                        {{ $series->subject }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Tests --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700">
                                    <i data-lucide="file-question" class="h-4 w-4 text-gray-400"></i>
                                    {{ $series->tests_count }}
                                </span>
                            </td>

                            {{-- Access --}}
                            <td class="px-5 py-4">
                                @if($series->is_free)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        <i data-lucide="unlock" class="h-3.5 w-3.5"></i>
                                        FREE
                                    </span>
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
                                    action="{{ route('admin.test-series.status', $series) }}"
                                    onsubmit="return openConfirmModal(
                                        this,
                                        '{{ $series->status ? 'Deactivate Test Series?' : 'Activate Test Series?' }}',
                                        '{{ $series->status ? 'Are you sure you want to deactivate this test series?' : 'Are you sure you want to activate this test series?' }}',
                                        '{{ $series->status ? 'Deactivate' : 'Activate' }}',
                                        '{{ $series->status ? 'triangle-alert' : 'circle-check' }}'
                                    )"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold transition {{ $series->status ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                    >
                                        <span class="h-1.5 w-1.5 rounded-full {{ $series->status ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ $series->status ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a
                                        href="{{ route('admin.tests.index', $series) }}"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                    >
                                        <i data-lucide="file-question" class="h-4 w-4"></i>
                                        Tests
                                    </a>

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        onclick="openEditModal(
                                            {{ $series->id }},
                                            @js($series->name),
                                            @js($series->description),
                                            @js($series->subject),
                                            {{ $series->is_free ? 'true' : 'false' }}
                                        )"
                                        class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-[#2874b9] transition hover:bg-blue-100"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                        Edit
                                    </button>

                                    {{-- Delete --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.test-series.destroy', $series) }}"
                                        onsubmit="return openConfirmModal(
                                            this,
                                            'Delete Test Series?',
                                            'Are you sure you want to delete this test series? This action cannot be undone.',
                                            'Delete',
                                            'trash-2'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-red-600 transition hover:bg-red-100"
                                            title="Delete"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-50 text-[#2874b9]">
                                        <i data-lucide="file-question" class="h-6 w-6"></i>
                                    </div>

                                    <h3 class="mt-4 text-sm font-semibold text-gray-800">No test series found</h3>
                                    <p class="mt-1 text-sm text-gray-500">Create your first test series to get started.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="divide-y divide-[#e4e8ef] md:hidden">
            @forelse($testSeries as $series)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="truncate font-semibold text-[#111827]">{{ $series->name }}</h3>

                            <div class="mt-1 flex flex-wrap items-center gap-2">
                                @if($series->subject)
                                    <span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-[11px] font-medium text-[#2874b9]">
                                        {{ $series->subject }}
                                    </span>
                                @endif

                                @if($series->is_free)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-[11px] font-semibold text-green-700">
                                        <i data-lucide="unlock" class="h-3 w-3"></i>
                                        FREE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-1 text-[11px] font-semibold text-gray-600">
                                        <i data-lucide="lock" class="h-3 w-3"></i>
                                        PAID
                                    </span>
                                @endif
                            </div>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('admin.test-series.status', $series) }}"
                            onsubmit="return openConfirmModal(
                                this,
                                '{{ $series->status ? 'Deactivate Test Series?' : 'Activate Test Series?' }}',
                                '{{ $series->status ? 'Are you sure you want to deactivate this test series?' : 'Are you sure you want to activate this test series?' }}',
                                '{{ $series->status ? 'Deactivate' : 'Activate' }}',
                                '{{ $series->status ? 'triangle-alert' : 'circle-check' }}'
                            )"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="shrink-0 cursor-pointer rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $series->status ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}"
                            >
                                {{ $series->status ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </div>

                    @if($series->description)
                        <p class="mt-2 line-clamp-2 text-xs text-gray-500">{{ $series->description }}</p>
                    @endif

                    <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                        <i data-lucide="file-question" class="h-4 w-4"></i>
                        {{ $series->tests_count }} Tests
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <a
                            href="{{ route('admin.tests.index', $series) }}"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-200 px-2 py-2.5 text-xs font-medium text-gray-700 hover:bg-gray-50"
                        >
                            <i data-lucide="file-question" class="h-4 w-4"></i>
                            Tests
                        </a>

                        <button
                            type="button"
                            onclick="openEditModal(
                                {{ $series->id }},
                                @js($series->name),
                                @js($series->description),
                                @js($series->subject),
                                {{ $series->is_free ? 'true' : 'false' }}
                            )"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2 py-2.5 text-xs font-medium text-[#2874b9] hover:bg-blue-100"
                        >
                            <i data-lucide="pencil" class="h-4 w-4"></i>
                            Edit
                        </button>

                        <form
                            method="POST"
                            action="{{ route('admin.test-series.destroy', $series) }}"
                            onsubmit="return openConfirmModal(
                                this,
                                'Delete Test Series?',
                                'Are you sure you want to delete this test series? This action cannot be undone.',
                                'Delete',
                                'trash-2'
                            )"
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
                    <p class="mt-3 text-sm font-medium text-gray-700">No test series found</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($testSeries->hasPages())
            <div class="border-t border-[#e4e8ef] px-4 py-3">
                {{ $testSeries->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Add Modal --}}
<div id="addModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <h2 class="text-lg font-semibold text-[#111827]">Add Test Series</h2>
                <p class="mt-0.5 text-xs text-gray-500">Create a new test series</p>
            </div>

            <button
                type="button"
                onclick="closeAddModal()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.test-series.store') }}" class="space-y-4 p-5">
            @csrf

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Series Name</label>
                <input
                    type="text"
                    name="name"
                    required
                    placeholder="e.g. RSCIT Mock Test"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Subject</label>
                <input
                    type="text"
                    name="subject"
                    placeholder="e.g. Computer"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Description</label>
                <textarea
                    name="description"
                    rows="3"
                    placeholder="Short description..."
                    class="w-full resize-none rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                ></textarea>
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
                        All tests inside this series will be accessible to users without a test subscription.
                    </span>
                </span>
            </label>

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
                    Create Series
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <h2 class="text-lg font-semibold text-[#111827]">Edit Test Series</h2>
                <p class="mt-0.5 text-xs text-gray-500">Update test series details</p>
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
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Series Name</label>
                <input
                    id="editName"
                    type="text"
                    name="name"
                    required
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Subject</label>
                <input
                    id="editSubject"
                    type="text"
                    name="subject"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                >
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-semibold text-gray-700">Description</label>
                <textarea
                    id="editDescription"
                    name="description"
                    rows="3"
                    class="w-full resize-none rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100"
                ></textarea>
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
                        All tests inside this series will be accessible to users without a test subscription.
                    </span>
                </span>
            </label>

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

{{-- Confirmation Modal --}}
<div
    id="confirmModal"
    class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 px-4"
    onclick="handleConfirmBackdrop(event)"
>
    <div class="w-full max-w-md rounded-xl bg-white shadow-xl" onclick="event.stopPropagation()">
        <div class="p-5">
            <div class="flex items-start gap-4">
                <div
                    id="confirmIconWrapper"
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600"
                >
                    <i id="confirmIcon" data-lucide="trash-2" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <h2 id="confirmTitle" class="text-lg font-semibold text-[#111827]">
                        Confirm Action
                    </h2>

                    <p id="confirmMessage" class="mt-1.5 text-sm leading-6 text-gray-500">
                        Are you sure?
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2">
                <button
                    type="button"
                    onclick="closeConfirmModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    id="confirmButton"
                    type="button"
                    onclick="submitConfirmedForm()"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                >
                    <i id="confirmButtonIcon" data-lucide="trash-2" class="h-4 w-4"></i>
                    <span id="confirmButtonText">Delete</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let pendingConfirmForm = null;

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

    function openEditModal(id, name, description, subject, isFree) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        form.action = "{{ url('/admin/test-series') }}/" + id;

        document.getElementById('editName').value = name ?? '';
        document.getElementById('editDescription').value = description ?? '';
        document.getElementById('editSubject').value = subject ?? '';
        document.getElementById('editIsFree').checked = Boolean(isFree);

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

    function openConfirmModal(form, title, message, buttonText = 'Delete', icon = 'trash-2') {
        pendingConfirmForm = form;

        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;
        document.getElementById('confirmButtonText').textContent = buttonText;

        const button = document.getElementById('confirmButton');
        const iconWrapper = document.getElementById('confirmIconWrapper');
        const iconElement = document.getElementById('confirmIcon');
        const buttonIcon = document.getElementById('confirmButtonIcon');

        const isDelete = icon === 'trash-2';

        button.className = isDelete
            ? 'inline-flex cursor-pointer items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700'
            : 'inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21639d]';

        iconWrapper.className = isDelete
            ? 'flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600'
            : 'flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-50 text-[#2874b9]';

        iconElement.setAttribute('data-lucide', icon);
        buttonIcon.setAttribute('data-lucide', icon);

        const modal = document.getElementById('confirmModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        return false;
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        pendingConfirmForm = null;

        if (
            document.getElementById('addModal').classList.contains('hidden') &&
            document.getElementById('editModal').classList.contains('hidden')
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    function submitConfirmedForm() {
        if (!pendingConfirmForm) {
            closeConfirmModal();
            return;
        }

        const form = pendingConfirmForm;
        pendingConfirmForm = null;
        form.submit();
    }

    function handleConfirmBackdrop(event) {
        if (event.target.id === 'confirmModal') {
            closeConfirmModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key !== 'Escape') {
            return;
        }

        closeConfirmModal();
        closeAddModal();
        closeEditModal();
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection
