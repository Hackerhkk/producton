@extends('admin.layouts.app')

@section('title', 'Library Seat Map')

@section('content')

@php
    $viewItems = collect();

    if ($layout) {
        $viewItems = $layout->items->map(function ($item) {
            $seat = $item->seat;
            $assignment = $seat?->activeAssignment;
            $student = $assignment?->student;
            $fee = $assignment?->fees;

            $occupied = $seat
                ? ($seat->status === 'occupied' || $assignment !== null)
                : false;

            return [
                'id' => (int) $item->id,
                'type' => $item->type,
                'seat_id' => $item->seat_id ? (int) $item->seat_id : null,
                'seat_number' => $seat?->seat_number,
                'occupied' => $occupied,
                'student_name' => $student?->name,
                'student_mobile' => $student?->mobile,
                'fee_name' => $fee?->fees,
                'fee_amount' => $fee?->amount !== null ? (float) $fee->amount : null,
                'assign_date' => $assignment?->assign_date
                    ? $assignment->assign_date->format('d M Y')
                    : null,
                'x' => (float) $item->x,
                'y' => (float) $item->y,
                'width' => (float) $item->width,
                'height' => (float) $item->height,
                'rotation' => (float) $item->rotation,
            ];
        })->values();
    }

    $seatItems = $viewItems->where('type', 'seat')->values();

    $availableCount = $seatItems->where('occupied', false)->count();
    $occupiedCount = $seatItems->where('occupied', true)->count();

    $tableCount = $viewItems->where('type', 'table')->count();
    $doorCount = $viewItems->where('type', 'door')->count();
    $wallCount = $viewItems->where('type', 'wall')->count();
@endphp

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-[#111827]">
            Library Seat Map
        </h1>

        <p class="mt-1 text-sm text-[#667085]">
            Manage students directly from the library room layout.
        </p>
    </div>

    <a
        href="{{ route('admin.seat-map.editor', $selectedLibrary ? ['library_id' => $selectedLibrary->id] : []) }}"
        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#2168ae]"
    >
        <i data-lucide="layout-dashboard" class="h-4 w-4"></i>
        Edit Layout
    </a>
</div>

@if(session('success'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-[#abefc6] bg-[#ecfdf3] px-4 py-3 text-sm text-[#027a48]">
        <i data-lucide="check-circle-2" class="mt-0.5 h-5 w-5 shrink-0"></i>

        <div class="font-medium">
            {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-[#fecdca] bg-[#fef3f2] px-4 py-3 text-sm text-[#b42318]">
        <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>

        <div class="font-medium">
            {{ session('error') }}
        </div>
    </div>
@endif

@if($errors->any())
    <div class="mb-5 rounded-xl border border-[#fecdca] bg-[#fef3f2] px-4 py-3 text-sm text-[#b42318]">
        <div class="flex items-start gap-3">
            <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>

            <div>
                <p class="font-semibold">
                    Please check the following:
                </p>

                <ul class="mt-1 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

{{-- ================= LIBRARY SELECT ================= --}}

<div class="mb-5 rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm">
    <form
        method="GET"
        action="{{ route('admin.seat-map.view') }}"
        class="flex flex-col gap-3 sm:flex-row sm:items-end"
    >
        <div class="w-full sm:max-w-sm">
            <label class="mb-1.5 block text-sm font-medium text-[#344054]">
                Select Library
            </label>

            <select
                name="library_id"
                onchange="this.form.submit()"
                class="w-full cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
            >
                <option value="">
                    Select library
                </option>

                @foreach($libraries as $library)
                    <option
                        value="{{ $library->id }}"
                        @selected($selectedLibrary && $selectedLibrary->id == $library->id)
                    >
                        {{ $library->name }}

                        @if($library->location)
                            — {{ $library->location }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

{{-- ================= CHANGE MONTHLY PLAN ================= --}}

@if($selectedLibrary)
    <div class="mb-6 rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-[#2874b9]">
                        <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-[#1f2937]">
                            Change Monthly Plan
                        </h2>

                        <p class="mt-0.5 text-xs text-[#667085]">
                            Change the monthly fee plan for all active students in this library.
                        </p>
                    </div>
                </div>
            </div>

            <form
                id="bulkPlanForm"
                method="POST"
                action="{{ route('admin.seat-map.change-plan') }}"
                class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto"
            >
                @csrf

                <input
                    type="hidden"
                    name="library_id"
                    value="{{ $selectedLibrary->id }}"
                >

                <div class="relative">
                    <select
                        name="fees_id"
                        id="bulkFeesId"
                        required
                        class="h-10 w-full min-w-[220px] cursor-pointer appearance-none rounded-lg border border-[#d0d5dd] bg-white px-3 pr-9 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100 sm:w-[240px]"
                    >
                        <option value="">
                            Select new monthly plan
                        </option>

                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}">
                                ₹{{ number_format((float) $fee->amount, 2) }}
                                / Month
                            </option>
                        @endforeach
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                    ></i>
                </div>

                <button
                    type="button"
                    id="openBulkPlanConfirm"
                    class="inline-flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 text-sm font-semibold text-white transition hover:bg-[#21639e]"
                >
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    Change Plan
                </button>
            </form>
        </div>
    </div>
@endif

{{-- ================= EMPTY STATES ================= --}}

@if(!$selectedLibrary)

    <div class="rounded-2xl border border-dashed border-[#d0d5dd] bg-white px-6 py-16 text-center shadow-sm">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef6fd] text-[#2874b9]">
            <i data-lucide="map" class="h-7 w-7"></i>
        </div>

        <h2 class="mt-4 text-lg font-semibold text-[#1f2937]">
            Select a library
        </h2>

        <p class="mx-auto mt-1 max-w-md text-sm text-[#667085]">
            Select a library above to view and manage its seats.
        </p>
    </div>

@elseif(!$layout)

    <div class="rounded-2xl border border-dashed border-[#d0d5dd] bg-white px-6 py-16 text-center shadow-sm">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#fff7ed] text-[#c2410c]">
            <i data-lucide="map-off" class="h-7 w-7"></i>
        </div>

        <h2 class="mt-4 text-lg font-semibold text-[#1f2937]">
            Layout not created
        </h2>

        <p class="mx-auto mt-1 max-w-md text-sm text-[#667085]">
            No room layout has been saved for
            <strong>{{ $selectedLibrary->name }}</strong>.
        </p>

        <a
            href="{{ route('admin.seat-map.editor', ['library_id' => $selectedLibrary->id]) }}"
            class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2168ae]"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            Create Layout
        </a>
    </div>

@else

    {{-- ================= STATISTICS ================= --}}

    <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-4">

        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6fd] text-[#2874b9]">
                    <i data-lucide="armchair" class="h-5 w-5"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-[#8190a6]">
                        Total Seats
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-[#111827]">
                        {{ $seatItems->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#abefc6] bg-[#f6fef9] p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#dcfae6] text-[#039855]">
                    <i data-lucide="check-circle-2" class="h-5 w-5"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-[#027a48]">
                        Available
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-[#027a48]">
                        {{ $availableCount }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#fecdca] bg-[#fffbfa] p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fee4e2] text-[#d92d20]">
                    <i data-lucide="user-round" class="h-5 w-5"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-[#b42318]">
                        Occupied
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-[#b42318]">
                        {{ $occupiedCount }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#475467]">
                    <i data-lucide="layout-grid" class="h-5 w-5"></i>
                </div>

                <div>
                    <p class="text-xs font-medium text-[#8190a6]">
                        Room Objects
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-[#111827]">
                        {{ $tableCount + $doorCount + $wallCount }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= ROOM MAP ================= --}}

    <div class="overflow-hidden rounded-2xl border border-[#d0d5dd] bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-[#e4e8ef] px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

            <div>
                <h2 class="text-base font-bold text-[#1f2937]">
                    {{ $selectedLibrary->name }}
                </h2>

                @if($selectedLibrary->location)
                    <p class="mt-0.5 text-xs text-[#667085]">
                        {{ $selectedLibrary->location }}
                    </p>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-2">

                <div class="flex items-center gap-2 rounded-full border border-[#abefc6] bg-[#ecfdf3] px-3 py-1.5 text-xs font-semibold text-[#027a48]">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#12b76a]"></span>
                    Available {{ $availableCount }}
                </div>

                <div class="flex items-center gap-2 rounded-full border border-[#fecdca] bg-[#fef3f2] px-3 py-1.5 text-xs font-semibold text-[#b42318]">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#f04438]"></span>
                    Occupied {{ $occupiedCount }}
                </div>

            </div>
        </div>

        {{-- IMPORTANT: SCROLLABLE MAP CONTAINER --}}

      <div
    class="relative w-full max-w-full overflow-x-auto overflow-y-auto bg-[#f8fafc] p-3 sm:p-4 lg:p-6"
    style="
        max-height: 70vh;
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    "
>

            {{-- Scrollbar helper wrapper --}}

          <div
    class="relative"
    style="
        width: max-content;
        min-width: max-content;
    "
>

                <div
                    class="relative mx-auto overflow-hidden rounded-xl border-2 border-[#344054] bg-white shadow-inner"
                    style="
                        width: {{ $layout->width }}px;
                        height: {{ $layout->height }}px;
                        min-width: {{ $layout->width }}px;
                        min-height: {{ $layout->height }}px;
                    "
                >

                    {{-- GRID --}}

                    <div
                        class="pointer-events-none absolute inset-0 opacity-40"
                        style="
                            background-image:
                                linear-gradient(to right, #e5e7eb 1px, transparent 1px),
                                linear-gradient(to bottom, #e5e7eb 1px, transparent 1px);
                            background-size: 25px 25px;
                        "
                    ></div>

                    {{-- ================= MAP ITEMS ================= --}}

                    @foreach($viewItems as $item)

                        {{-- ================= SEAT ================= --}}

                        @if($item['type'] === 'seat')

                            @php
                                $seatBg = $item['occupied']
                                    ? '#fee4e2'
                                    : '#dcfae6';

                                $seatBorder = $item['occupied']
                                    ? '#f04438'
                                    : '#12b76a';

                                $seatText = $item['occupied']
                                    ? '#b42318'
                                    : '#027a48';

                                $seatIconBg = $item['occupied']
                                    ? '#f04438'
                                    : '#12b76a';
                            @endphp

                            <button
                                type="button"
                                class="seat-item absolute flex cursor-pointer select-none flex-col items-center justify-center overflow-hidden rounded-xl border-2 text-center transition duration-150 hover:z-50 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-[#2874b9]/20"
                                style="
                                    left: {{ $item['x'] }}px;
                                    top: {{ $item['y'] }}px;
                                    width: {{ $item['width'] }}px;
                                    height: {{ $item['height'] }}px;
                                    transform: rotate({{ $item['rotation'] }}deg);
                                    background: {{ $seatBg }};
                                    border-color: {{ $seatBorder }};
                                    color: {{ $seatText }};
                                "
                                data-seat-id="{{ $item['seat_id'] }}"
                                data-seat-number="{{ $item['seat_number'] }}"
                                data-occupied="{{ $item['occupied'] ? '1' : '0' }}"
                                data-student-name="{{ $item['student_name'] }}"
                                data-student-mobile="{{ $item['student_mobile'] }}"
                                data-fee-name="{{ $item['fee_name'] }}"
                                data-fee-amount="{{ $item['fee_amount'] }}"
                                data-assign-date="{{ $item['assign_date'] }}"
                            >

                                <div
                                    class="flex h-7 w-7 items-center justify-center rounded-full text-white"
                                    style="background: {{ $seatIconBg }};"
                                >
                                    <i
                                        data-lucide="{{ $item['occupied'] ? 'user-round' : 'armchair' }}"
                                        class="h-4 w-4"
                                    ></i>
                                </div>

                                <span class="mt-1 max-w-full truncate px-1 text-[11px] font-bold">
                                    {{ $item['seat_number'] ?? 'Seat' }}
                                </span>

                                @if($item['occupied'] && $item['student_name'])
                                    <span class="max-w-full truncate px-1 text-[9px] font-semibold">
                                        {{ $item['student_name'] }}
                                    </span>
                                @else
                                    <span class="text-[9px] font-semibold">
                                        Available
                                    </span>
                                @endif

                            </button>

                        {{-- ================= TABLE ================= --}}

                        @elseif($item['type'] === 'table')

                            <div
                                class="pointer-events-none absolute flex select-none items-center justify-center rounded-xl border-2 border-[#98a2b3] bg-[#f2f4f7] text-[#667085] shadow-sm"
                                style="
                                    left: {{ $item['x'] }}px;
                                    top: {{ $item['y'] }}px;
                                    width: {{ $item['width'] }}px;
                                    height: {{ $item['height'] }}px;
                                    transform: rotate({{ $item['rotation'] }}deg);
                                "
                            >
                                <div class="flex flex-col items-center justify-center">
                                    <i data-lucide="table-2" class="h-5 w-5"></i>

                                    <span class="mt-1 text-[10px] font-semibold">
                                        Table
                                    </span>
                                </div>
                            </div>

                        {{-- ================= DOOR ================= --}}

                        @elseif($item['type'] === 'door')

                            <div
                                class="pointer-events-none absolute flex select-none items-center justify-center rounded-md border-2 border-[#7f56d9] bg-[#f9f5ff] text-[#6941c6] shadow-sm"
                                style="
                                    left: {{ $item['x'] }}px;
                                    top: {{ $item['y'] }}px;
                                    width: {{ $item['width'] }}px;
                                    height: {{ $item['height'] }}px;
                                    transform: rotate({{ $item['rotation'] }}deg);
                                "
                            >
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="door-open" class="h-4 w-4"></i>

                                    <span class="text-[10px] font-bold">
                                        Entry
                                    </span>
                                </div>
                            </div>

                        {{-- ================= WALL ================= --}}

                        @elseif($item['type'] === 'wall')

                            <div
                                class="pointer-events-none absolute select-none rounded-sm border border-[#344054] bg-[#344054]"
                                style="
                                    left: {{ $item['x'] }}px;
                                    top: {{ $item['y'] }}px;
                                    width: {{ $item['width'] }}px;
                                    height: {{ $item['height'] }}px;
                                    transform: rotate({{ $item['rotation'] }}deg);
                                "
                            ></div>

                        @endif

                    @endforeach

                    {{-- ================= NO SEATS ================= --}}

                    @if($seatItems->isEmpty())
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="rounded-2xl border border-dashed border-[#d0d5dd] bg-white px-8 py-6 text-center shadow-sm">

                                <i
                                    data-lucide="armchair"
                                    class="mx-auto h-8 w-8 text-[#98a2b3]"
                                ></i>

                                <p class="mt-2 text-sm font-semibold text-[#344054]">
                                    No seats placed
                                </p>

                                <p class="mt-1 text-xs text-[#667085]">
                                    Add seats to the layout from the editor.
                                </p>

                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

@endif

{{-- ================= ASSIGN STUDENT MODAL ================= --}}

<div
    id="assignModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>
    <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

        <div class="flex items-start justify-between border-b border-[#e4e8ef] px-5 py-4">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-[#8190a6]">
                    Assign Student
                </p>

                <h3
                    id="assignSeatNumber"
                    class="mt-1 text-xl font-bold text-[#111827]"
                >
                    Seat
                </h3>
            </div>

            <button
                type="button"
                id="closeAssignModal"
                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f2f4f7] hover:text-[#344054]"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>

        <form
            id="assignForm"
            method="POST"
            action=""
        >
            @csrf

            <div class="space-y-4 p-5">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-[#344054]">
                        Student
                    </label>

                    <select
                        name="student_id"
                        id="assignStudent"
                        required
                        class="w-full cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >
                        <option value="">
                            Select student
                        </option>

                        @foreach($availableStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }}

                                @if($student->mobile)
                                    — {{ $student->mobile }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @if($availableStudents->isEmpty())
                        <p class="mt-1.5 text-xs text-[#b42318]">
                            No available students found.
                        </p>
                    @endif
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-[#344054]">
                        Monthly Fee Plan
                    </label>

                    <select
                        name="fees_id"
                        id="assignFee"
                        required
                        class="w-full cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >
                        <option value="">
                            Select fee plan
                        </option>

                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}">
                                {{ $fee->fees }} — ₹{{ number_format((float) $fee->amount, 2) }}
                            </option>
                        @endforeach
                    </select>

                    @if($fees->isEmpty())
                        <p class="mt-1.5 text-xs text-[#b42318]">
                            No monthly fee plan found for this library.
                        </p>
                    @endif
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-[#344054]">
                        Assign Date
                    </label>

                    <input
                        type="date"
                        name="assign_date"
                        id="assignDate"
                        value="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >
                </div>

                <div class="rounded-xl border border-[#d0d5dd] bg-[#f8fafc] p-3">
                    <div class="flex items-start gap-2">
                        <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0 text-[#2874b9]"></i>

                        <p class="text-xs leading-5 text-[#667085]">
                            The applicable fee will be calculated automatically according to the assignment date.
                        </p>
                    </div>
                </div>

            </div>

            <div class="flex gap-3 border-t border-[#e4e8ef] px-5 py-4">

                <button
                    type="button"
                    id="cancelAssign"
                    class="flex-1 cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="flex-1 cursor-pointer rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2168ae]"
                >
                    Assign Seat
                </button>

            </div>

        </form>

    </div>
</div>

{{-- ================= OCCUPIED SEAT DETAILS MODAL ================= --}}

<div
    id="detailsModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 p-4"
>
    <div class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl">

        <div class="flex items-start justify-between border-b border-[#e4e8ef] px-5 py-4">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-[#8190a6]">
                    Occupied Seat
                </p>

                <h3
                    id="detailsSeatNumber"
                    class="mt-1 text-xl font-bold text-[#111827]"
                >
                    Seat
                </h3>
            </div>

            <button
                type="button"
                id="closeDetailsModal"
                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg text-[#667085] transition hover:bg-[#f2f4f7] hover:text-[#344054]"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>

        <div class="space-y-3 p-5">

            <div class="flex items-center gap-3 rounded-xl border border-[#fecdca] bg-[#fef3f2] p-4">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#fee4e2] text-[#d92d20]">
                    <i data-lucide="user-round" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs text-[#8190a6]">
                        Student
                    </p>

                    <p
                        id="detailsStudentName"
                        class="truncate text-sm font-bold text-[#1f2937]"
                    >
                        —
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-3">

                <div class="rounded-xl border border-[#e4e8ef] p-3">
                    <p class="text-xs text-[#8190a6]">
                        Mobile
                    </p>

                    <p
                        id="detailsStudentMobile"
                        class="mt-1 text-sm font-semibold text-[#344054]"
                    >
                        —
                    </p>
                </div>

                <div class="rounded-xl border border-[#e4e8ef] p-3">
                    <p class="text-xs text-[#8190a6]">
                        Monthly Fee
                    </p>

                    <p
                        id="detailsFeeAmount"
                        class="mt-1 text-sm font-semibold text-[#344054]"
                    >
                        —
                    </p>
                </div>

            </div>

            <div class="rounded-xl border border-[#e4e8ef] p-3">
                <p class="text-xs text-[#8190a6]">
                    Fee Plan
                </p>

                <p
                    id="detailsFeeName"
                    class="mt-1 text-sm font-semibold text-[#344054]"
                >
                    —
                </p>
            </div>

            <div class="rounded-xl border border-[#e4e8ef] p-3">
                <p class="text-xs text-[#8190a6]">
                    Assignment Date
                </p>

                <p
                    id="detailsAssignDate"
                    class="mt-1 text-sm font-semibold text-[#344054]"
                >
                    —
                </p>
            </div>

        </div>

        <div class="flex gap-3 border-t border-[#e4e8ef] px-5 py-4">

            <button
                type="button"
                id="closeDetailsButton"
                class="flex-1 cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
            >
                Close
            </button>

            <button
                type="button"
                id="releaseSeatButton"
                class="flex-1 cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
            >
                Release Seat
            </button>

        </div>

    </div>
</div>

{{-- ================= RELEASE CONFIRMATION ================= --}}

<div
    id="releaseModal"
    class="fixed inset-0 z-[110] hidden items-center justify-center bg-black/40 p-4"
>
    <div class="w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-2xl">

        <div class="p-5">

            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#fee4e2] text-[#d92d20]">
                <i data-lucide="user-round-x" class="h-5 w-5"></i>
            </div>

            <h3 class="mt-4 text-lg font-bold text-[#111827]">
                Release this seat?
            </h3>

            <p class="mt-1.5 text-sm leading-5 text-[#667085]">
                The active student assignment will be marked inactive and the seat will become available.
            </p>

        </div>

        <div class="flex gap-3 border-t border-[#e4e8ef] px-5 py-4">

            <button
                type="button"
                id="cancelRelease"
                class="flex-1 cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
            >
                Cancel
            </button>

            <form
                id="releaseForm"
                method="POST"
                action=""
                class="flex-1"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full cursor-pointer rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2168ae]"
                >
                    Yes, Release
                </button>
            </form>

        </div>

    </div>
</div>

{{-- ================= BULK PLAN CONFIRMATION ================= --}}

@if($selectedLibrary)

    <div
        id="bulkPlanConfirmModal"
        class="fixed inset-0 z-[120] hidden items-center justify-center bg-black/40 px-4"
    >
        <div class="w-full max-w-md overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-2xl">

            <div class="flex items-start gap-4 p-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6fd] text-[#2874b9]">
                    <i data-lucide="refresh-cw" class="h-5 w-5"></i>
                </div>

                <div class="min-w-0">
                    <h3 class="text-base font-bold text-[#1f2937]">
                        Change Monthly Plan?
                    </h3>

                    <p class="mt-1.5 text-sm leading-6 text-[#667085]">
                        This will change the monthly fee plan for all active students
                        in
                        <span class="font-semibold text-[#344054]">
                            {{ $selectedLibrary->name }}
                        </span>
                        from the current month.
                    </p>

                    <p class="mt-2 text-xs text-[#667085]">
                        Existing fee history will remain unchanged.
                    </p>
                </div>

            </div>

            <div class="flex justify-end gap-2 border-t border-[#e4e8ef] bg-[#f8fafc] px-5 py-4">

                <button
                    type="button"
                    id="cancelBulkPlan"
                    class="inline-flex h-10 cursor-pointer items-center justify-center rounded-lg border border-[#d0d5dd] bg-white px-4 text-sm font-semibold text-[#344054] transition hover:bg-gray-50"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="confirmBulkPlan"
                    class="inline-flex h-10 cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 text-sm font-semibold text-white transition hover:bg-[#2168ae]"
                >
                    <i data-lucide="check" class="h-4 w-4"></i>
                    Yes, Change Plan
                </button>

            </div>

        </div>
    </div>

@endif

{{-- ================= JAVASCRIPT ================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.lucide) {
        lucide.createIcons();
    }

    /* =========================================================
       BULK MONTHLY PLAN
    ========================================================= */

    const bulkPlanForm =
        document.getElementById('bulkPlanForm');

    const bulkFeesId =
        document.getElementById('bulkFeesId');

    const openBulkPlanConfirm =
        document.getElementById('openBulkPlanConfirm');

    const bulkPlanConfirmModal =
        document.getElementById('bulkPlanConfirmModal');

    const cancelBulkPlan =
        document.getElementById('cancelBulkPlan');

    const confirmBulkPlan =
        document.getElementById('confirmBulkPlan');


    function openBulkPlanModal() {

        if (!bulkPlanConfirmModal) {
            return;
        }

        bulkPlanConfirmModal.classList.remove('hidden');
        bulkPlanConfirmModal.classList.add('flex');

        if (window.lucide) {
            lucide.createIcons();
        }
    }


    function closeBulkPlanModal() {

        if (!bulkPlanConfirmModal) {
            return;
        }

        bulkPlanConfirmModal.classList.add('hidden');
        bulkPlanConfirmModal.classList.remove('flex');
    }


    if (openBulkPlanConfirm) {

        openBulkPlanConfirm.addEventListener(
            'click',
            function () {

                if (!bulkFeesId || !bulkFeesId.value) {

                    bulkFeesId?.focus();

                    return;
                }

                openBulkPlanModal();
            }
        );
    }


    if (cancelBulkPlan) {

        cancelBulkPlan.addEventListener(
            'click',
            function () {

                closeBulkPlanModal();
            }
        );
    }


    if (confirmBulkPlan) {

        confirmBulkPlan.addEventListener(
            'click',
            function () {

                if (!bulkPlanForm) {
                    return;
                }

                confirmBulkPlan.disabled = true;

                confirmBulkPlan.classList.add(
                    'opacity-70',
                    'cursor-not-allowed'
                );

                bulkPlanForm.submit();
            }
        );
    }


    if (bulkPlanConfirmModal) {

        bulkPlanConfirmModal.addEventListener(
            'click',
            function (event) {

                if (event.target === bulkPlanConfirmModal) {
                    closeBulkPlanModal();
                }
            }
        );
    }


    /* =========================================================
       ASSIGN / DETAILS / RELEASE
    ========================================================= */

    const assignModal =
        document.getElementById('assignModal');

    const detailsModal =
        document.getElementById('detailsModal');

    const releaseModal =
        document.getElementById('releaseModal');


    const assignForm =
        document.getElementById('assignForm');

    const releaseForm =
        document.getElementById('releaseForm');


    const assignSeatNumber =
        document.getElementById('assignSeatNumber');

    const assignStudent =
        document.getElementById('assignStudent');

    const assignFee =
        document.getElementById('assignFee');

    const assignDate =
        document.getElementById('assignDate');


    const detailsSeatNumber =
        document.getElementById('detailsSeatNumber');

    const detailsStudentName =
        document.getElementById('detailsStudentName');

    const detailsStudentMobile =
        document.getElementById('detailsStudentMobile');

    const detailsFeeAmount =
        document.getElementById('detailsFeeAmount');

    const detailsFeeName =
        document.getElementById('detailsFeeName');

    const detailsAssignDate =
        document.getElementById('detailsAssignDate');


    let selectedSeatId = null;


    function openModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (window.lucide) {
            lucide.createIcons();
        }
    }


    function closeModal(modal) {

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }


    function openAssignModal(button) {

        const seatId =
            button.dataset.seatId;

        const seatNumber =
            button.dataset.seatNumber || 'Seat';


        if (!seatId) {
            return;
        }


        selectedSeatId = seatId;


        if (assignSeatNumber) {

            assignSeatNumber.textContent =
                seatNumber;
        }


        if (assignForm) {

            assignForm.action =
                "{{ url('/admin/seat-map') }}/" +
                seatId +
                "/assign";
        }


        if (assignStudent) {
            assignStudent.value = '';
        }


        if (assignFee) {
            assignFee.value = '';
        }


        if (assignDate && !assignDate.value) {

            assignDate.value =
                new Date()
                    .toISOString()
                    .split('T')[0];
        }


        openModal(assignModal);
    }


    function openDetailsModal(button) {

        selectedSeatId =
            button.dataset.seatId;


        if (detailsSeatNumber) {

            detailsSeatNumber.textContent =
                button.dataset.seatNumber || 'Seat';
        }


        if (detailsStudentName) {

            detailsStudentName.textContent =
                button.dataset.studentName || 'Student';
        }


        if (detailsStudentMobile) {

            detailsStudentMobile.textContent =
                button.dataset.studentMobile || '—';
        }


        const feeAmount =
            button.dataset.feeAmount;


        if (
            detailsFeeAmount &&
            feeAmount &&
            feeAmount !== 'null' &&
            feeAmount !== 'undefined'
        ) {

            detailsFeeAmount.textContent =
                '₹' +
                Number(feeAmount)
                    .toLocaleString('en-IN');
        }

        else if (detailsFeeAmount) {

            detailsFeeAmount.textContent = '—';
        }


        if (detailsFeeName) {

            detailsFeeName.textContent =
                button.dataset.feeName || '—';
        }


        if (detailsAssignDate) {

            detailsAssignDate.textContent =
                button.dataset.assignDate || '—';
        }


        if (releaseForm && selectedSeatId) {

            releaseForm.action =
                "{{ url('/admin/seat-map') }}/" +
                selectedSeatId +
                "/release";
        }


        openModal(detailsModal);
    }


    document
        .querySelectorAll('.seat-item')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    if (
                        this.dataset.occupied === '1'
                    ) {

                        openDetailsModal(this);

                    } else {

                        openAssignModal(this);
                    }
                }
            );
        });


    document
        .getElementById('closeAssignModal')
        ?.addEventListener(
            'click',
            function () {

                closeModal(assignModal);
            }
        );


    document
        .getElementById('cancelAssign')
        ?.addEventListener(
            'click',
            function () {

                closeModal(assignModal);
            }
        );


    document
        .getElementById('closeDetailsModal')
        ?.addEventListener(
            'click',
            function () {

                closeModal(detailsModal);
            }
        );


    document
        .getElementById('closeDetailsButton')
        ?.addEventListener(
            'click',
            function () {

                closeModal(detailsModal);
            }
        );


    document
        .getElementById('releaseSeatButton')
        ?.addEventListener(
            'click',
            function () {

                closeModal(detailsModal);

                openModal(releaseModal);
            }
        );


    document
        .getElementById('cancelRelease')
        ?.addEventListener(
            'click',
            function () {

                closeModal(releaseModal);
            }
        );


    [
        assignModal,
        detailsModal,
        releaseModal
    ].forEach(function (modal) {

        if (!modal) {
            return;
        }


        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {
                    closeModal(modal);
                }
            }
        );
    });


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeModal(assignModal);
                closeModal(detailsModal);
                closeModal(releaseModal);
                closeBulkPlanModal();
            }
        }
    );

});
</script>

@endsection
