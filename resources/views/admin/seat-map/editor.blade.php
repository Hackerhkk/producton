@extends('admin.layouts.app')

@section('title', 'Library Room Layout')

@section('content')
<div class="space-y-5">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#2874b9]">
                    <i data-lucide="layout-dashboard"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#111827]">Library Room Layout</h1>
                    <p class="mt-0.5 text-sm text-[#667085]">
                        Design the actual physical seating layout of each library.
                    </p>
                </div>
            </div>
        </div>

        @if($selectedLibrary)
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054]">
                    <i data-lucide="building-2" class="h-4 w-4 text-[#2874b9]"></i>
                    {{ $selectedLibrary->name }}
                </span>

                <a href="{{ route('admin.seat-map.editor') }}"
                   class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f8fafc]">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    Reset
                </a>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i data-lucide="check-circle-2" class="mt-0.5 h-5 w-5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <div class="flex items-start gap-3">
                <i data-lucide="circle-alert" class="mt-0.5 h-5 w-5 shrink-0"></i>
                <div>
                    <p class="font-semibold">Layout could not be saved.</p>
                    <ul class="mt-1 list-disc pl-5 text-xs">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="rounded-2xl border border-[#e4e8ef] bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.seat-map.editor') }}" class="flex flex-col gap-3 md:flex-row md:items-end">
            <div class="flex-1">
                <label class="mb-1.5 block text-sm font-semibold text-[#344054]">
                    Select Library
                </label>

                <select name="library_id"
                        onchange="this.form.submit()"
                        class="w-full cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#344054] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                    <option value="">Choose library</option>

                    @foreach($libraries as $library)
                        <option value="{{ $library->id }}"
                            @selected($selectedLibrary && $selectedLibrary->id == $library->id)>
                            {{ $library->name }}{{ $library->location ? ' — '.$library->location : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($selectedLibrary)
                <div class="grid grid-cols-2 gap-3 md:w-[330px]">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#667085]">
                            Room width
                        </label>
                        <input id="roomWidth"
                               type="number"
                               min="500"
                               max="5000"
                               value="{{ $layout?->width ?? 1200 }}"
                               class="w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium text-[#344054] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-semibold text-[#667085]">
                            Room height
                        </label>
                        <input id="roomHeight"
                               type="number"
                               min="400"
                               max="5000"
                               value="{{ $layout?->height ?? 700 }}"
                               class="w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium text-[#344054] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>
            @endif
        </form>
    </div>

    @if(!$selectedLibrary)
        <div class="rounded-2xl border border-dashed border-[#cfd6df] bg-white px-6 py-16 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-50 text-[#2874b9]">
                <i data-lucide="map" class="h-8 w-8"></i>
            </div>

            <h2 class="mt-4 text-lg font-bold text-[#111827]">
                Select a library
            </h2>

            <p class="mx-auto mt-1 max-w-md text-sm text-[#667085]">
                Select a library above to start designing its actual room layout.
            </p>
        </div>
    @else
        <div class="grid min-w-0 gap-4 xl:grid-cols-[250px_minmax(500px,1fr)_270px]">
            {{-- LEFT PANEL --}}
            <aside class="min-w-0 rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">
                <div class="border-b border-[#edf0f4] px-4 py-4">
                    <h2 class="text-sm font-bold text-[#111827]">Library Elements</h2>
                    <p class="mt-1 text-xs text-[#667085]">
                        Add seats and room objects.
                    </p>
                </div>

                <div class="p-4">
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button"
                                data-object-type="table"
                                class="object-button cursor-pointer rounded-xl border border-[#d0d5dd] bg-white p-3 text-left transition hover:border-[#2874b9] hover:bg-blue-50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-700">
                                <i data-lucide="table-2" class="h-5 w-5"></i>
                            </div>
                            <p class="mt-2 text-xs font-bold text-[#344054]">Table</p>
                        </button>

                        <button type="button"
                                data-object-type="door"
                                class="object-button cursor-pointer rounded-xl border border-[#d0d5dd] bg-white p-3 text-left transition hover:border-[#2874b9] hover:bg-blue-50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-50 text-green-700">
                                <i data-lucide="door-open" class="h-5 w-5"></i>
                            </div>
                            <p class="mt-2 text-xs font-bold text-[#344054]">Door</p>
                        </button>

                        <button type="button"
                                data-object-type="wall"
                                class="object-button cursor-pointer rounded-xl border border-[#d0d5dd] bg-white p-3 text-left transition hover:border-[#2874b9] hover:bg-blue-50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-700">
                                <i data-lucide="minus" class="h-5 w-5"></i>
                            </div>
                            <p class="mt-2 text-xs font-bold text-[#344054]">Wall</p>
                        </button>

                        <button type="button"
                                id="addSeatButton"
                                class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white p-3 text-left transition hover:border-[#2874b9] hover:bg-blue-50">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-[#2874b9]">
                                <i data-lucide="armchair" class="h-5 w-5"></i>
                            </div>
                            <p class="mt-2 text-xs font-bold text-[#344054]">Seat</p>
                        </button>
                    </div>
                </div>

                <div class="border-t border-[#edf0f4] px-4 py-4">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="rounded-xl bg-green-50 p-3">
                            <p class="text-[11px] font-semibold text-green-700">Available</p>
                            <p id="availableCount" class="mt-1 text-xl font-extrabold text-green-800">0</p>
                        </div>

                        <div class="rounded-xl bg-red-50 p-3">
                            <p class="text-[11px] font-semibold text-red-700">Occupied</p>
                            <p id="occupiedCount" class="mt-1 text-xl font-extrabold text-red-800">0</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-[#edf0f4]">
                    <div class="flex items-center justify-between px-4 py-3">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wide text-[#667085]">
                                Seats
                            </h3>
                            <p class="mt-0.5 text-[11px] text-[#98a2b3]">
                                Click to place
                            </p>
                        </div>
                        <span id="seatTotal"
                              class="rounded-full bg-[#f2f4f7] px-2 py-1 text-[11px] font-bold text-[#475467]">
                            0
                        </span>
                    </div>

                    <div id="seatList"
                         class="max-h-[470px] space-y-2 overflow-y-auto px-3 pb-3">
                        @forelse($seats as $seat)
                            @php
                                $assignment = $seat->activeAssignment;
                                $student = $assignment?->student;
                                $occupied = (bool) $assignment;
                            @endphp

                            <button type="button"
                                    draggable="true"
                                    data-seat-id="{{ $seat->id }}"
                                    data-seat-number="{{ $seat->seat_number }}"
                                    data-occupied="{{ $occupied ? '1' : '0' }}"
                                    class="seat-source flex w-full cursor-pointer items-center gap-3 rounded-xl border border-[#e4e8ef] bg-white p-2.5 text-left transition hover:border-[#2874b9] hover:bg-blue-50">
                                <span class="seat-source-dot flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $occupied ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }}">
                                    <i data-lucide="armchair" class="h-4 w-4"></i>
                                </span>

                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-sm font-bold text-[#344054]">
                                        {{ $seat->seat_number }}
                                    </span>
                                    <span class="seat-source-status block truncate text-[11px] {{ $occupied ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $occupied ? ($student?->name ?? 'Occupied') : 'Available' }}
                                    </span>
                                </span>

                                <span class="seat-source-placed hidden rounded-full bg-blue-50 px-2 py-1 text-[10px] font-bold text-[#2874b9]">
                                    Placed
                                </span>
                            </button>
                        @empty
                            <div class="rounded-xl border border-dashed border-[#d0d5dd] px-3 py-6 text-center">
                                <i data-lucide="armchair" class="mx-auto h-6 w-6 text-[#98a2b3]"></i>
                                <p class="mt-2 text-xs font-semibold text-[#667085]">
                                    No seats found.
                                </p>
                                <p class="mt-1 text-[11px] text-[#98a2b3]">
                                    Add seats from Seat Management first.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </aside>

            {{-- CENTER --}}
            <section class="min-w-0 rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-[#edf0f4] px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-[#111827]">Room Designer</h2>
                        <p class="mt-1 text-xs text-[#667085]">
                            Drag items around the room. Select an item to edit its properties.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 text-[11px] font-semibold">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1.5 text-green-700">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            Available
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1.5 text-red-700">
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            Occupied
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-2.5 py-1.5 text-[#2874b9]">
                            <span class="h-2 w-2 rounded-full bg-[#2874b9]"></span>
                            Object
                        </span>
                    </div>
                </div>

                <div id="roomViewport"
                     class="overflow-auto bg-[#f8fafc] p-4 sm:p-6"
                     style="min-height: 650px;">
                    <div class="flex min-h-[600px] min-w-max items-center justify-center">
                        <div id="roomCanvas"
                             class="relative overflow-hidden rounded-xl border-2 border-[#475467] bg-white shadow-lg"
                             style="width: {{ $layout?->width ?? 1200 }}px; height: {{ $layout?->height ?? 700 }}px; background-image: linear-gradient(to right, #eef2f6 1px, transparent 1px), linear-gradient(to bottom, #eef2f6 1px, transparent 1px); background-size: 25px 25px;"
                             tabindex="0">
                            <div class="pointer-events-none absolute inset-0">
                                <div class="absolute left-3 top-2 text-[10px] font-semibold uppercase tracking-wider text-[#98a2b3]">
                                    {{ $selectedLibrary->name }}
                                </div>
                            </div>

                            <div id="roomItems"></div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 border-t border-[#edf0f4] px-4 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap items-center gap-2 text-xs text-[#667085]">
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="move" class="h-3.5 w-3.5"></i>
                            Move
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="maximize-2" class="h-3.5 w-3.5"></i>
                            Resize
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="rotate-cw" class="h-3.5 w-3.5"></i>
                            Rotate
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i data-lucide="grid-2x2" class="h-3.5 w-3.5"></i>
                            25px grid
                        </span>
                    </div>

                    <button type="button"
                            id="saveLayoutButton"
                            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#2168a8] disabled:cursor-not-allowed disabled:opacity-60">
                        <i data-lucide="save" class="h-4 w-4"></i>
                        Save Layout
                    </button>
                </div>
            </section>

            {{-- RIGHT PANEL --}}
            <aside class="min-w-0 rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">
                <div class="border-b border-[#edf0f4] px-4 py-4">
                    <h2 class="text-sm font-bold text-[#111827]">Properties</h2>
                    <p class="mt-1 text-xs text-[#667085]">
                        Edit the selected room element.
                    </p>
                </div>

                <div id="emptyProperties"
                     class="px-5 py-12 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#98a2b3]">
                        <i data-lucide="mouse-pointer-2" class="h-6 w-6"></i>
                    </div>
                    <p class="mt-3 text-sm font-semibold text-[#475467]">
                        No item selected
                    </p>
                    <p class="mt-1 text-xs leading-5 text-[#98a2b3]">
                        Select a seat, table, door or wall from the room.
                    </p>
                </div>

                <div id="propertiesPanel" class="hidden">
                    <div class="border-b border-[#edf0f4] px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div id="propertyIcon"
                                 class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-[#2874b9]">
                                <i data-lucide="square" class="h-5 w-5"></i>
                            </div>

                            <div class="min-w-0">
                                <p id="propertyTitle"
                                   class="truncate text-sm font-bold text-[#111827]">
                                    Item
                                </p>
                                <p id="propertySubtitle"
                                   class="truncate text-xs text-[#667085]">
                                    Room object
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 p-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                    X
                                </label>
                                <input id="propertyX"
                                       type="number"
                                       step="1"
                                       class="property-input w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                    Y
                                </label>
                                <input id="propertyY"
                                       type="number"
                                       step="1"
                                       class="property-input w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                    Width
                                </label>
                                <input id="propertyWidth"
                                       type="number"
                                       min="10"
                                       step="1"
                                       class="property-input w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                    Height
                                </label>
                                <input id="propertyHeight"
                                       type="number"
                                       min="10"
                                       step="1"
                                       class="property-input w-full rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">
                            </div>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                Rotation
                            </label>

                            <div class="flex gap-2">
                                <input id="propertyRotation"
                                       type="number"
                                       step="1"
                                       class="property-input min-w-0 flex-1 rounded-xl border border-[#d0d5dd] px-3 py-2.5 text-sm font-medium outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-blue-100">

                                <button type="button"
                                        id="rotateLeftButton"
                                        class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3 text-[#475467] transition hover:bg-[#f8fafc]">
                                    <i data-lucide="rotate-ccw" class="h-4 w-4"></i>
                                </button>

                                <button type="button"
                                        id="rotateRightButton"
                                        class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-3 text-[#475467] transition hover:bg-[#f8fafc]">
                                    <i data-lucide="rotate-cw" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </div>

                        <div id="seatDetails"
                             class="hidden rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-3">
                            <p class="text-[11px] font-bold uppercase tracking-wide text-[#667085]">
                                Seat information
                            </p>

                            <div class="mt-3 space-y-2 text-xs">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-[#667085]">Seat</span>
                                    <span id="detailSeatNumber"
                                          class="font-bold text-[#344054]">—</span>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-[#667085]">Status</span>
                                    <span id="detailStatus"
                                          class="font-bold">—</span>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-[#667085]">Student</span>
                                    <span id="detailStudent"
                                          class="max-w-[150px] truncate font-bold text-[#344054]">—</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button type="button"
                                    id="duplicateButton"
                                    class="cursor-pointer inline-flex items-center justify-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-3 py-2.5 text-xs font-bold text-[#344054] transition hover:bg-[#f8fafc]">
                                <i data-lucide="copy" class="h-4 w-4"></i>
                                Duplicate
                            </button>

                            <button type="button"
                                    id="deleteButton"
                                    class="cursor-pointer inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2.5 text-xs font-bold text-red-700 transition hover:bg-red-100">
                                <i data-lucide="trash-2" class="h-4 w-4"></i>
                                Delete
                            </button>
                        </div>

                        <div class="rounded-xl border border-blue-100 bg-blue-50 p-3 text-[11px] leading-5 text-blue-700">
                            <div class="flex gap-2">
                                <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0"></i>
                                <p>
                                    Changes are stored locally in the editor until you click
                                    <strong>Save Layout</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    @endif
</div>

@if($selectedLibrary)
@php
    $editorSeats = $seats->map(function ($seat) {
        $assignment = $seat->activeAssignment;

        return [
            'id' => (int) $seat->id,
            'seat_number' => $seat->seat_number,
            'occupied' => (bool) $assignment,
            'student_name' => $assignment && $assignment->student
                ? $assignment->student->name
                : null,
        ];
    })->values()->all();

    $editorItems = $layout
        ? $layout->items->map(function ($item) {
            return [
                'id' => (int) $item->id,
                'type' => $item->type,
                'seat_id' => $item->seat_id
                    ? (int) $item->seat_id
                    : null,
                'x' => (float) $item->x,
                'y' => (float) $item->y,
                'width' => (float) $item->width,
                'height' => (float) $item->height,
                'rotation' => (float) $item->rotation,
            ];
        })->values()->all()
        : [];
@endphp



    <form id="layoutSaveForm"
          method="POST"
          action="{{ route('admin.seat-map.save') }}"
          class="hidden">
        @csrf
        <input type="hidden" name="library_id" value="{{ $selectedLibrary->id }}">
        <input type="hidden" id="formWidth" name="width" value="{{ $layout?->width ?? 1200 }}">
        <input type="hidden" id="formHeight" name="height" value="{{ $layout?->height ?? 700 }}">
        <div id="formItems"></div>
    </form>

    <div id="deleteConfirmModal"
         class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 px-4">
        <div class="w-full max-w-sm rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-2xl">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                    <i data-lucide="trash-2" class="h-5 w-5"></i>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-[#111827]">Delete this item?</h3>
                    <p class="mt-1 text-xs leading-5 text-[#667085]">
                        This element will be removed from the current layout.
                    </p>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-2">
                <button type="button"
                        id="cancelDeleteButton"
                        class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] hover:bg-[#f8fafc]">
                    Cancel
                </button>

                <button type="button"
                        id="confirmDeleteButton"
                        class="cursor-pointer rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <style>
        #roomCanvas {
            transform-origin: center center;
        }

        .layout-item {
            position: absolute;
            box-sizing: border-box;
            user-select: none;
            touch-action: none;
            cursor: move;
        }

        .layout-item.selected {
            outline: 2px solid #2874b9;
            outline-offset: 3px;
            z-index: 50 !important;
        }

        .layout-item .resize-handle {
            position: absolute;
            right: -7px;
            bottom: -7px;
            width: 14px;
            height: 14px;
            border-radius: 4px;
            border: 2px solid white;
            background: #2874b9;
            box-shadow: 0 1px 4px rgba(16,24,40,.2);
            cursor: nwse-resize;
            touch-action: none;
        }

        .layout-seat {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 800;
            box-shadow: 0 2px 5px rgba(16,24,40,.08);
        }

        .layout-seat.available {
            border-color: #16a34a;
            background: #f0fdf4;
            color: #15803d;
        }

        .layout-seat.occupied {
            border-color: #dc2626;
            background: #fef2f2;
            color: #b91c1c;
        }

        .layout-table {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #b7791f;
            border-radius: 10px;
            background: #fff7e6;
            color: #8a5a12;
            font-size: 11px;
            font-weight: 800;
            box-shadow: 0 2px 5px rgba(16,24,40,.06);
        }

        .layout-door {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #16a34a;
            border-radius: 6px;
            background: #f0fdf4;
            color: #15803d;
            font-size: 10px;
            font-weight: 800;
        }

        .layout-wall {
            background: #475467;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(16,24,40,.15);
        }

        .room-drop-active {
            box-shadow: inset 0 0 0 3px rgba(40,116,185,.25);
        }

        @media (max-width: 1279px) {
            #roomViewport {
                min-height: 600px !important;
            }
        }
    </style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomCanvas = document.getElementById('roomCanvas');
        const roomItems = document.getElementById('roomItems');
        const roomWidthInput = document.getElementById('roomWidth');
        const roomHeightInput = document.getElementById('roomHeight');
        const formWidth = document.getElementById('formWidth');
        const formHeight = document.getElementById('formHeight');
        const saveButton = document.getElementById('saveLayoutButton');
        const saveForm = document.getElementById('layoutSaveForm');
        const formItems = document.getElementById('formItems');

        const emptyProperties = document.getElementById('emptyProperties');
        const propertiesPanel = document.getElementById('propertiesPanel');
        const propertyTitle = document.getElementById('propertyTitle');
        const propertySubtitle = document.getElementById('propertySubtitle');
        const propertyX = document.getElementById('propertyX');
        const propertyY = document.getElementById('propertyY');
        const propertyWidth = document.getElementById('propertyWidth');
        const propertyHeight = document.getElementById('propertyHeight');
        const propertyRotation = document.getElementById('propertyRotation');

        const seatDetails = document.getElementById('seatDetails');
        const detailSeatNumber = document.getElementById('detailSeatNumber');
        const detailStatus = document.getElementById('detailStatus');
        const detailStudent = document.getElementById('detailStudent');

        const availableCount = document.getElementById('availableCount');
        const occupiedCount = document.getElementById('occupiedCount');
        const seatTotal = document.getElementById('seatTotal');

        const duplicateButton = document.getElementById('duplicateButton');
        const deleteButton = document.getElementById('deleteButton');
        const rotateLeftButton = document.getElementById('rotateLeftButton');
        const rotateRightButton = document.getElementById('rotateRightButton');

        const deleteModal = document.getElementById('deleteConfirmModal');
        const cancelDeleteButton = document.getElementById('cancelDeleteButton');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

      
        const seats = @json($editorSeats);
        const savedItems = @json($editorItems);

        let items = [];
        let selectedItemId = null;
        let nextItemId = 1;
        let pendingDeleteId = null;
        let pointerState = null;

        const gridSize = 25;

        function uid() {
            return 'item_' + Date.now() + '_' + (nextItemId++);
        }

        function snap(value) {
            return Math.round(Number(value) / gridSize) * gridSize;
        }

        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        function getRoomWidth() {
            return Math.max(
                500,
                Number(roomWidthInput?.value) || 1200
            );
        }

        function getRoomHeight() {
            return Math.max(
                400,
                Number(roomHeightInput?.value) || 700
            );
        }

        function getSeat(seatId) {
            return seats.find(function (seat) {
                return Number(seat.id) === Number(seatId);
            });
        }

        function setRoomSize() {
            if (!roomCanvas) {
                return;
            }

            const width = getRoomWidth();
            const height = getRoomHeight();

            roomCanvas.style.width = width + 'px';
            roomCanvas.style.height = height + 'px';

            if (formWidth) {
                formWidth.value = width;
            }

            if (formHeight) {
                formHeight.value = height;
            }

            items.forEach(function (item) {
                item.x = clamp(
                    item.x,
                    0,
                    Math.max(0, width - item.width)
                );

                item.y = clamp(
                    item.y,
                    0,
                    Math.max(0, height - item.height)
                );
            });

            renderItems();
            updateSelectionPanel();
        }

        function itemStyle(item) {
            return {
                left: item.x + 'px',
                top: item.y + 'px',
                width: item.width + 'px',
                height: item.height + 'px',
                transform: `rotate(${item.rotation}deg)`,
            };
        }

        function getUsedSeatIds(exceptId = null) {
            return items
                .filter(function (item) {
                    return (
                        item.type === 'seat' &&
                        item.id !== exceptId
                    );
                })
                .map(function (item) {
                    return Number(item.seat_id);
                });
        }

        function seatIsPlaced(seatId, exceptId = null) {
            return getUsedSeatIds(exceptId).includes(
                Number(seatId)
            );
        }

        function createElement(item) {
            const element = document.createElement('div');

            element.className = 'layout-item';
            element.dataset.itemId = item.id;

            Object.assign(
                element.style,
                itemStyle(item)
            );

            if (item.type === 'seat') {
                const seat = getSeat(item.seat_id);

                if (!seat) {
                    return null;
                }

                element.classList.add('layout-seat');

                element.classList.add(
                    seat.occupied
                        ? 'occupied'
                        : 'available'
                );

                element.textContent = seat.seat_number;

                element.title = seat.occupied
                    ? `${seat.seat_number} — ${seat.student_name || 'Occupied'}`
                    : `${seat.seat_number} — Available`;
            }

            if (item.type === 'table') {
                element.classList.add('layout-table');
                element.textContent = 'TABLE';
            }

            if (item.type === 'door') {
                element.classList.add('layout-door');
                element.textContent = 'ENTRY / DOOR';
            }

            if (item.type === 'wall') {
                element.classList.add('layout-wall');
            }

            if (item.id === selectedItemId) {
                element.classList.add('selected');
            }

            const resizeHandle =
                document.createElement('span');

            resizeHandle.className =
                'resize-handle';

            resizeHandle.dataset.resize = '1';

            element.appendChild(resizeHandle);

            bindItemEvents(element, item);

            return element;
        }

        function bindItemEvents(element, item) {
            element.addEventListener(
                'pointerdown',
                function (event) {
                    if (
                        event.target.closest(
                            '.resize-handle'
                        )
                    ) {
                        startResize(
                            event,
                            item
                        );

                        return;
                    }

                    selectItem(item.id);

                    pointerState = {
                        mode: 'move',
                        itemId: item.id,
                        startClientX: event.clientX,
                        startClientY: event.clientY,
                        startX: item.x,
                        startY: item.y,
                    };

                    if (
                        element.setPointerCapture
                    ) {
                        try {
                            element.setPointerCapture(
                                event.pointerId
                            );
                        } catch (error) {
                            // Ignore pointer capture errors.
                        }
                    }

                    event.preventDefault();
                }
            );

            element.addEventListener(
                'click',
                function (event) {
                    event.stopPropagation();
                    selectItem(item.id);
                }
            );
        }

        function startResize(event, item) {
            selectItem(item.id);

            pointerState = {
                mode: 'resize',
                itemId: item.id,
                startClientX: event.clientX,
                startClientY: event.clientY,
                startWidth: item.width,
                startHeight: item.height,
            };

            event.preventDefault();
            event.stopPropagation();
        }

        function handlePointerMove(event) {
            if (!pointerState) {
                return;
            }

            const item = items.find(function (row) {
                return row.id === pointerState.itemId;
            });

            if (!item) {
                return;
            }

            const dx =
                event.clientX -
                pointerState.startClientX;

            const dy =
                event.clientY -
                pointerState.startClientY;

            if (pointerState.mode === 'move') {
                item.x = clamp(
                    snap(
                        pointerState.startX + dx
                    ),
                    0,
                    Math.max(
                        0,
                        getRoomWidth() -
                        item.width
                    )
                );

                item.y = clamp(
                    snap(
                        pointerState.startY + dy
                    ),
                    0,
                    Math.max(
                        0,
                        getRoomHeight() -
                        item.height
                    )
                );
            }

            if (pointerState.mode === 'resize') {
                item.width = clamp(
                    snap(
                        pointerState.startWidth + dx
                    ),
                    10,
                    Math.max(
                        10,
                        getRoomWidth() -
                        item.x
                    )
                );

                item.height = clamp(
                    snap(
                        pointerState.startHeight + dy
                    ),
                    10,
                    Math.max(
                        10,
                        getRoomHeight() -
                        item.y
                    )
                );
            }

            renderItems();
            updateSelectionPanel();
        }

        function handlePointerUp() {
            pointerState = null;
        }

        function renderItems() {
            if (!roomItems) {
                return;
            }

            roomItems.innerHTML = '';

            items.forEach(function (item) {
                const element =
                    createElement(item);

                if (element) {
                    roomItems.appendChild(
                        element
                    );
                }
            });

            updateSidebarState();
            updateCounters();
        }

        function selectItem(id) {
            selectedItemId = id;

            renderItems();
            updateSelectionPanel();
        }

        function getSelectedItem() {
            return items.find(function (item) {
                return item.id === selectedItemId;
            }) || null;
        }

        function updateSelectionPanel() {
            const item = getSelectedItem();

            if (!item) {
                emptyProperties?.classList.remove(
                    'hidden'
                );

                propertiesPanel?.classList.add(
                    'hidden'
                );

                return;
            }

            emptyProperties?.classList.add(
                'hidden'
            );

            propertiesPanel?.classList.remove(
                'hidden'
            );

            if (propertyX) {
                propertyX.value =
                    Math.round(item.x);
            }

            if (propertyY) {
                propertyY.value =
                    Math.round(item.y);
            }

            if (propertyWidth) {
                propertyWidth.value =
                    Math.round(item.width);
            }

            if (propertyHeight) {
                propertyHeight.value =
                    Math.round(item.height);
            }

            if (propertyRotation) {
                propertyRotation.value =
                    Math.round(item.rotation);
            }

            seatDetails?.classList.add(
                'hidden'
            );

            if (item.type === 'seat') {
                const seat =
                    getSeat(item.seat_id);

                propertyTitle.textContent =
                    seat
                        ? `Seat ${seat.seat_number}`
                        : 'Seat';

                propertySubtitle.textContent =
                    seat?.occupied
                        ? 'Occupied seat'
                        : 'Available seat';

                if (seat) {
                    seatDetails.classList.remove(
                        'hidden'
                    );

                    detailSeatNumber.textContent =
                        seat.seat_number;

                    detailStatus.textContent =
                        seat.occupied
                            ? 'Occupied'
                            : 'Available';

                    detailStatus.className =
                        'font-bold ' +
                        (
                            seat.occupied
                                ? 'text-red-600'
                                : 'text-green-600'
                        );

                    detailStudent.textContent =
                        seat.student_name || '—';
                }

                return;
            }

            if (item.type === 'table') {
                propertyTitle.textContent =
                    'Table';

                propertySubtitle.textContent =
                    'Library furniture';

                return;
            }

            if (item.type === 'door') {
                propertyTitle.textContent =
                    'Door';

                propertySubtitle.textContent =
                    'Entry / exit';

                return;
            }

            if (item.type === 'wall') {
                propertyTitle.textContent =
                    'Wall';

                propertySubtitle.textContent =
                    'Room boundary / partition';
            }
        }

        function updateSidebarState() {
            document
                .querySelectorAll('.seat-source')
                .forEach(function (button) {
                    const seatId =
                        Number(
                            button.dataset.seatId
                        );

                    const placed =
                        seatIsPlaced(
                            seatId
                        );

                    const placedBadge =
                        button.querySelector(
                            '.seat-source-placed'
                        );

                    if (placed) {
                        button.classList.add(
                            'border-blue-200',
                            'bg-blue-50'
                        );

                        placedBadge?.classList.remove(
                            'hidden'
                        );
                    } else {
                        button.classList.remove(
                            'border-blue-200',
                            'bg-blue-50'
                        );

                        placedBadge?.classList.add(
                            'hidden'
                        );
                    }
                });
        }

        function updateCounters() {
            const available =
                seats.filter(function (seat) {
                    return !seat.occupied;
                }).length;

            const occupied =
                seats.filter(function (seat) {
                    return seat.occupied;
                }).length;

            if (availableCount) {
                availableCount.textContent =
                    available;
            }

            if (occupiedCount) {
                occupiedCount.textContent =
                    occupied;
            }

            if (seatTotal) {
                seatTotal.textContent =
                    seats.length;
            }
        }

        function addSeat(
            seatId,
            x = null,
            y = null
        ) {
            const seat =
                getSeat(seatId);

            if (!seat) {
                return;
            }

            if (seatIsPlaced(seat.id)) {
                const existing =
                    items.find(function (item) {
                        return (
                            item.type === 'seat' &&
                            Number(item.seat_id) ===
                                Number(seat.id)
                        );
                    });

                if (existing) {
                    selectItem(
                        existing.id
                    );
                }

                return;
            }

            const width = 75;
            const height = 75;

            const defaultPosition =
                75 + items.length * 15;

            const item = {
                id: uid(),
                type: 'seat',
                seat_id: Number(seat.id),

                x: x !== null
                    ? clamp(
                        snap(x),
                        0,
                        Math.max(
                            0,
                            getRoomWidth() -
                            width
                        )
                    )
                    : clamp(
                        snap(defaultPosition),
                        0,
                        Math.max(
                            0,
                            getRoomWidth() -
                            width
                        )
                    ),

                y: y !== null
                    ? clamp(
                        snap(y),
                        0,
                        Math.max(
                            0,
                            getRoomHeight() -
                            height
                        )
                    )
                    : clamp(
                        snap(defaultPosition),
                        0,
                        Math.max(
                            0,
                            getRoomHeight() -
                            height
                        )
                    ),

                width: width,
                height: height,
                rotation: 0,
            };

            items.push(item);

            selectedItemId =
                item.id;

            renderItems();
            updateSelectionPanel();
        }

        function createObject(type) {
            const defaults = {
                table: {
                    width: 150,
                    height: 80,
                },

                door: {
                    width: 100,
                    height: 30,
                },

                wall: {
                    width: 200,
                    height: 20,
                },
            };

            const size =
                defaults[type];

            if (!size) {
                return;
            }

            const offset =
                items.length * 15;

            const item = {
                id: uid(),
                type: type,
                seat_id: null,

                x: clamp(
                    snap(150 + offset),
                    0,
                    Math.max(
                        0,
                        getRoomWidth() -
                        size.width
                    )
                ),

                y: clamp(
                    snap(150 + offset),
                    0,
                    Math.max(
                        0,
                        getRoomHeight() -
                        size.height
                    )
                ),

                width: size.width,
                height: size.height,
                rotation: 0,
            };

            items.push(item);

            selectedItemId =
                item.id;

            renderItems();
            updateSelectionPanel();
        }

        function duplicateSelected() {
            const item =
                getSelectedItem();

            if (!item) {
                return;
            }

            /*
             * Seat duplicate intentionally disabled.
             * One physical seat can only exist once.
             */
            if (item.type === 'seat') {
                return;
            }

            const copy = {
                ...item,

                id: uid(),

                x: clamp(
                    item.x + gridSize,
                    0,
                    Math.max(
                        0,
                        getRoomWidth() -
                        item.width
                    )
                ),

                y: clamp(
                    item.y + gridSize,
                    0,
                    Math.max(
                        0,
                        getRoomHeight() -
                        item.height
                    )
                ),
            };

            items.push(copy);

            selectedItemId =
                copy.id;

            renderItems();
            updateSelectionPanel();
        }

        function openDeleteModal() {
            if (!getSelectedItem()) {
                return;
            }

            pendingDeleteId =
                selectedItemId;

            deleteModal?.classList.remove(
                'hidden'
            );

            deleteModal?.classList.add(
                'flex'
            );
        }

        function closeDeleteModal() {
            pendingDeleteId = null;

            deleteModal?.classList.add(
                'hidden'
            );

            deleteModal?.classList.remove(
                'flex'
            );
        }

        function confirmDelete() {
            if (!pendingDeleteId) {
                closeDeleteModal();
                return;
            }

            items = items.filter(
                function (item) {
                    return (
                        item.id !==
                        pendingDeleteId
                    );
                }
            );

            if (
                selectedItemId ===
                pendingDeleteId
            ) {
                selectedItemId = null;
            }

            closeDeleteModal();

            renderItems();
            updateSelectionPanel();
        }

        function updateProperty(
            property,
            value
        ) {
            const item =
                getSelectedItem();

            if (!item) {
                return;
            }

            const number =
                Number(value);

            if (!Number.isFinite(number)) {
                return;
            }

            if (property === 'x') {
                item.x = clamp(
                    snap(number),
                    0,
                    Math.max(
                        0,
                        getRoomWidth() -
                        item.width
                    )
                );
            }

            if (property === 'y') {
                item.y = clamp(
                    snap(number),
                    0,
                    Math.max(
                        0,
                        getRoomHeight() -
                        item.height
                    )
                );
            }

            if (property === 'width') {
                item.width = clamp(
                    snap(number),
                    10,
                    Math.max(
                        10,
                        getRoomWidth() -
                        item.x
                    )
                );
            }

            if (property === 'height') {
                item.height = clamp(
                    snap(number),
                    10,
                    Math.max(
                        10,
                        getRoomHeight() -
                        item.y
                    )
                );
            }

            if (property === 'rotation') {
                item.rotation =
                    number % 360;
            }

            renderItems();
            updateSelectionPanel();
        }

        function buildSaveForm() {
            if (!formItems) {
                return;
            }

            formItems.innerHTML = '';

            items.forEach(
                function (item, index) {
                    const values = {
                        type: item.type,

                        seat_id:
                            item.type === 'seat'
                                ? item.seat_id
                                : '',

                        x:
                            Number(
                                item.x.toFixed(2)
                            ),

                        y:
                            Number(
                                item.y.toFixed(2)
                            ),

                        width:
                            Number(
                                item.width.toFixed(2)
                            ),

                        height:
                            Number(
                                item.height.toFixed(2)
                            ),

                        rotation:
                            Number(
                                item.rotation.toFixed(2)
                            ),
                    };

                    Object.entries(
                        values
                    ).forEach(
                        function ([key, value]) {
                            const input =
                                document.createElement(
                                    'input'
                                );

                            input.type =
                                'hidden';

                            input.name =
                                `items[${index}][${key}]`;

                            input.value =
                                value ?? '';

                            formItems.appendChild(
                                input
                            );
                        }
                    );
                }
            );

            formWidth.value =
                getRoomWidth();

            formHeight.value =
                getRoomHeight();
        }

        /*
         * Add Table / Door / Wall
         */
        document
            .querySelectorAll('.object-button')
            .forEach(function (button) {
                button.addEventListener(
                    'click',
                    function () {
                        createObject(
                            this.dataset.objectType
                        );
                    }
                );
            });

        /*
         * Add first unplaced seat
         */
        document
            .getElementById('addSeatButton')
            ?.addEventListener(
                'click',
                function () {
                    const firstAvailable =
                        seats.find(
                            function (seat) {
                                return !seatIsPlaced(
                                    seat.id
                                );
                            }
                        );

                    if (firstAvailable) {
                        addSeat(
                            firstAvailable.id
                        );
                    }
                }
            );

        /*
         * Seat sidebar click + desktop drag
         */
        document
            .querySelectorAll('.seat-source')
            .forEach(function (button) {
                button.addEventListener(
                    'click',
                    function () {
                        addSeat(
                            Number(
                                this.dataset.seatId
                            )
                        );
                    }
                );

                button.addEventListener(
                    'dragstart',
                    function (event) {
                        if (!event.dataTransfer) {
                            return;
                        }

                        event.dataTransfer.setData(
                            'text/seat-id',
                            this.dataset.seatId
                        );

                        event.dataTransfer.effectAllowed =
                            'copy';
                    }
                );
            });

        /*
         * Drag seat into room
         */
        roomCanvas?.addEventListener(
            'dragover',
            function (event) {
                event.preventDefault();

                roomCanvas.classList.add(
                    'room-drop-active'
                );
            }
        );

        roomCanvas?.addEventListener(
            'dragleave',
            function () {
                roomCanvas.classList.remove(
                    'room-drop-active'
                );
            }
        );

        roomCanvas?.addEventListener(
            'drop',
            function (event) {
                event.preventDefault();

                roomCanvas.classList.remove(
                    'room-drop-active'
                );

                const seatId =
                    event.dataTransfer
                        ?.getData(
                            'text/seat-id'
                        );

                if (!seatId) {
                    return;
                }

                const rect =
                    roomCanvas.getBoundingClientRect();

                const x =
                    event.clientX -
                    rect.left;

                const y =
                    event.clientY -
                    rect.top;

                addSeat(
                    Number(seatId),
                    x - 37,
                    y - 37
                );
            }
        );

        /*
         * Click empty room to deselect
         */
        roomCanvas?.addEventListener(
            'click',
            function (event) {
                if (
                    event.target ===
                        roomCanvas ||
                    event.target ===
                        roomItems
                ) {
                    selectedItemId =
                        null;

                    renderItems();
                    updateSelectionPanel();
                }
            }
        );

        /*
         * Move / Resize
         */
        document.addEventListener(
            'pointermove',
            handlePointerMove
        );

        document.addEventListener(
            'pointerup',
            handlePointerUp
        );

        /*
         * Property fields
         */
        propertyX?.addEventListener(
            'change',
            function (event) {
                updateProperty(
                    'x',
                    event.target.value
                );
            }
        );

        propertyY?.addEventListener(
            'change',
            function (event) {
                updateProperty(
                    'y',
                    event.target.value
                );
            }
        );

        propertyWidth?.addEventListener(
            'change',
            function (event) {
                updateProperty(
                    'width',
                    event.target.value
                );
            }
        );

        propertyHeight?.addEventListener(
            'change',
            function (event) {
                updateProperty(
                    'height',
                    event.target.value
                );
            }
        );

        propertyRotation?.addEventListener(
            'change',
            function (event) {
                updateProperty(
                    'rotation',
                    event.target.value
                );
            }
        );

        /*
         * Rotate Left
         */
        rotateLeftButton?.addEventListener(
            'click',
            function () {
                const item =
                    getSelectedItem();

                if (!item) {
                    return;
                }

                item.rotation -= 90;

                renderItems();
                updateSelectionPanel();
            }
        );

        /*
         * Rotate Right
         */
        rotateRightButton?.addEventListener(
            'click',
            function () {
                const item =
                    getSelectedItem();

                if (!item) {
                    return;
                }

                item.rotation += 90;

                renderItems();
                updateSelectionPanel();
            }
        );

        /*
         * Duplicate
         */
        duplicateButton?.addEventListener(
            'click',
            duplicateSelected
        );

        /*
         * Delete
         */
        deleteButton?.addEventListener(
            'click',
            openDeleteModal
        );

        cancelDeleteButton?.addEventListener(
            'click',
            closeDeleteModal
        );

        confirmDeleteButton?.addEventListener(
            'click',
            confirmDelete
        );

        deleteModal?.addEventListener(
            'click',
            function (event) {
                if (
                    event.target ===
                    deleteModal
                ) {
                    closeDeleteModal();
                }
            }
        );

        /*
         * Room dimensions
         */
        roomWidthInput?.addEventListener(
            'change',
            setRoomSize
        );

        roomHeightInput?.addEventListener(
            'change',
            setRoomSize
        );

        /*
         * Save Layout
         */
        saveButton?.addEventListener(
            'click',
            function () {
                buildSaveForm();

                saveButton.disabled =
                    true;

                const icon =
                    saveButton.querySelector(
                        'svg'
                    );

                if (icon) {
                    icon.classList.add(
                        'animate-spin'
                    );
                }

                saveForm.submit();
            }
        );

        /*
         * Keyboard shortcuts
         *
         * Delete = open delete confirmation
         * Escape = close modal / deselect
         */
        document.addEventListener(
            'keydown',
            function (event) {
                if (
                    event.target.matches(
                        'input, textarea, select'
                    ) &&
                    event.key !== 'Escape'
                ) {
                    return;
                }

                if (
                    event.key === 'Delete'
                ) {
                    if (
                        getSelectedItem()
                    ) {
                        openDeleteModal();
                    }
                }

                if (
                    event.key === 'Escape'
                ) {
                    closeDeleteModal();

                    if (selectedItemId) {
                        selectedItemId =
                            null;

                        renderItems();
                        updateSelectionPanel();
                    }
                }
            }
        );

        /*
         * Load saved database layout
         */
        items = savedItems.map(
            function (item) {
                return {
                    id:
                        'saved_' +
                        item.id,

                    type:
                        item.type,

                    seat_id:
                        item.seat_id
                            ? Number(
                                item.seat_id
                            )
                            : null,

                    x:
                        Number(item.x),

                    y:
                        Number(item.y),

                    width:
                        Number(item.width),

                    height:
                        Number(item.height),

                    rotation:
                        Number(
                            item.rotation
                        ),
                };
            }
        );

        /*
         * Initial render
         */
        setRoomSize();
        renderItems();
        updateSelectionPanel();

        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>

@endif
@endsection
