@extends('admin.layouts.app')

@section('title', 'Students')

@section('content')

{{-- ================= HEADER ================= --}}

<div class="mb-6 flex items-center justify-between">

<form
    method="GET"
    action="{{ route('admin.student.index') }}"
    id="studentFilterForm"
    class="flex items-center gap-2">

    {{-- Search --}}
    <div class="relative">

        <i
            data-lucide="search"
            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
        </i>

        <input
            type="text"
            name="search"
            id="studentSearch"
            value="{{ request('search') }}"
            placeholder="Name or Seat..."
            autocomplete="off"
            class="w-40 rounded-xl border border-gray-200 bg-white py-2 pl-9 pr-3 text-sm text-gray-700 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">
    </div>

    {{-- Library --}}
    <select
        name="library_id"
        id="libraryFilter"
        class="cursor-pointer w-40 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        <option value="">
            All Libraries
        </option>

        @foreach($libraries as $library)

            <option
                value="{{ $library->id }}"
                {{ request('library_id') == $library->id ? 'selected' : '' }}>

                {{ $library->name }}

            </option>

        @endforeach

    </select>

</form>

{{-- Add Student --}}
<a
    href="{{ route('student.create') }}"
    class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2167a7]"
>
    <i data-lucide="user-plus" class="h-4 w-4"></i>
    
</a>

</div>

{{-- ================= STUDENT MODAL ================= --}}

<div
     
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

<div
    class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl">

    {{-- Modal Header --}}
    <div class="flex items-start justify-between">

        <div>

            <div class="flex items-center gap-2">

                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#e7f1fb] text-[#2874b9]">

                    <i
                        data-lucide="user-plus"
                        class="h-4 w-4">
                    </i>

                </div>
                <h2 class="text-xl font-semibold text-gray-900">
                    Add Student
                </h2>
            </div>

            <p class="mt-2 text-xs text-gray-500">
                Enter details to add a new student record
            </p>

        </div>

        <button
            type="button"
            onclick="closeStudentModal()"
            class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">

            <i
                data-lucide="x"
                class="h-4 w-4">
            </i>

        </button>

    </div>


    {{-- Form --}}
    <form
        id="studentForm"
        method="POST"
        action="{{ route('student.store') }}"
        enctype="multipart/form-data"
        class="mt-6 space-y-4">

        @csrf

        {{-- Student Name --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Student Name
                <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="e.g. John Doe"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Father Name --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Father Name
                <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="father"
                value="{{ old('father') }}"
                placeholder="e.g. Father Name"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Village --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Village Name
                <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="village"
                value="{{ old('village') }}"
                placeholder="e.g. Village Name"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Mobile --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Mobile
                <span class="text-red-500">*</span>
            </label>

            <input
                type="tel"
                name="mobile"
                value="{{ old('mobile') }}"
                inputmode="numeric"
                maxlength="10"
                pattern="[0-9]{10}"
                placeholder="Enter mobile number"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Aadhaar --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Aadhaar Number
                <span class="text-red-500">*</span>
            </label>

            <div class="relative">

                <input
                    type="text"
                    name="aadhar_no"
                    id="aadharInput"
                    value="{{ old('aadhar_no') }}"
                    inputmode="numeric"
                    maxlength="12"
                    pattern="[0-9]{12}"
                    placeholder="Enter 12 digit Aadhaar number"
                    required
                    autocomplete="off"
                    class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 pr-10 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                <span
                    id="aadharIcon"
                    class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2">
                </span>

            </div>

            <p
                id="aadharMessage"
                class="hidden text-xs font-medium">
            </p>

        </div>


        {{-- Biometric --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Biometric Number
            </label>

            <input
                type="text"
                name="biometric_no"
                value="{{ old('biometric_no') }}"
                placeholder="Enter biometric number"
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Student Photo --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                Student Photo
                <span class="text-red-500">*</span>
            </label>

            <input
                type="file"
                name="student_photo"
                accept="image/jpeg,image/png,image/webp"
                required
                class="w-full rounded-lg border border-gray-300 text-sm text-gray-600 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-gray-700 hover:file:bg-gray-200">

        </div>


        {{-- ID Proof Front --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                ID Proof Front Photo
                <span class="text-red-500">*</span>
            </label>

            <input
                type="file"
                name="id_front"
                accept="image/jpeg,image/png,image/webp"
                required
                class="w-full rounded-lg border border-gray-300 text-sm text-gray-600 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-gray-700 hover:file:bg-gray-200">

        </div>


        {{-- ID Proof Back --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">
                ID Proof Back Photo
                <span class="text-red-500">*</span>
            </label>

            <input
                type="file"
                name="id_back"
                accept="image/jpeg,image/png,image/webp"
                required
                class="w-full rounded-lg border border-gray-300 text-sm text-gray-600 file:mr-4 file:cursor-pointer file:rounded-l-lg file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-gray-700 hover:file:bg-gray-200">

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-5">

            <button
                type="button"
                onclick="closeStudentModal()"
                class="cursor-pointer rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

                Cancel

            </button>

            <button
                type="submit"
                id="saveStudentButton"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-[#2874b9] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#2167a7]">

                <i
                    data-lucide="save"
                    class="h-4 w-4">
                </i>

                Save Student

            </button>

        </div>

    </form>

</div>

</div>

{{-- ================= STUDENTS ================= --}}

<div class="mt-8">

{{-- Heading --}}
<div class="mb-5 flex items-center justify-between">

    <div>

        <h2 class="text-lg font-semibold text-[#111827]">
            Students
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Manage all registered students
        </p>

    </div>

    <span
        class="rounded-full bg-[#e7f1fb] px-3 py-1 text-xs font-semibold text-[#347ec0]">

        {{ $students->count() }}

    </span>

</div>


{{-- Student Results --}}
<div
    id="studentResults"
    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

    @if($students->count() > 0)

        @foreach($students as $student)

            @php

                $activeSeatAssignment = $student->seatAssignments
                    ->where('status', 'active')
                    ->first();

                $activeSeat = $activeSeatAssignment?->seat;

                $activeLibrary = $activeSeat?->library;

                $dueAmount = \App\Models\FeeCycle::where(
                    'student_id',
                    $student->id
                )
                ->whereIn('status', ['pending', 'partial'])
                ->get()
                ->sum(function ($feeCycle) {
                    return max(
                        0,
                        (float) $feeCycle->amount -
                        (float) $feeCycle->paid_amount
                    );
                });

            @endphp


            {{-- ================= FLIP CARD ================= --}}
            <div
                class="student-card h-[300px] cursor-pointer"
                onclick="this.classList.toggle('flipped')">

                <div class="student-card-inner relative h-full w-full">

                    {{-- ================= FRONT ================= --}}

                    <div
                        class="student-card-front absolute inset-0 overflow-hidden rounded-xl border border-[#e5eaf0] bg-white shadow-[0_1px_3px_rgba(16,24,40,0.04)]">

                        {{-- TOP --}}
                        <div
                            class="flex items-center justify-between border-b border-gray-100 px-3.5 py-2.5">

                            <div class="flex items-center gap-2">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e7f1fb] text-[#347ec0]">

                                    <i
                                        data-lucide="graduation-cap"
                                        class="h-4 w-4">
                                    </i>

                                </div>

                                <div>

                                    <p class="text-[9px] font-semibold uppercase tracking-wider text-gray-400">
                                        Student
                                    </p>

                                    <p class="text-xs font-semibold text-gray-700">
                                        Active
                                    </p>

                                </div>

                            </div>


                            {{-- Wallet + Due --}}
                            <div class="flex items-center gap-2">

                                <div
                                    class="flex items-center gap-1 rounded-full bg-green-50 px-2 py-1">

                                    <i
                                        data-lucide="wallet"
                                        class="h-3 w-3 text-green-600">
                                    </i>

                                    <span class="text-[10px] font-bold text-green-600">

                                        ₹{{ number_format((float) ($student->wallet->balance ?? 0), 0) }}

                                    </span>

                                </div>


                                <div
                                    class="flex items-center gap-1 rounded-full {{ $dueAmount > 0 ? 'bg-red-50' : 'bg-gray-50' }} px-2 py-1">

                                    <i
                                        data-lucide="receipt"
                                        class="h-3 w-3 {{ $dueAmount > 0 ? 'text-red-500' : 'text-gray-400' }}">
                                    </i>

                                    <span
                                        class="text-[10px] font-bold {{ $dueAmount > 0 ? 'text-red-600' : 'text-gray-400' }}">

                                        ₹{{ number_format($dueAmount, 0) }}

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- PROFILE --}}
                        <div class="flex items-center gap-3 px-3.5 py-3">

                            @if($student->student_photo)

                                <img
                                    src="{{ asset('storage/' . $student->student_photo) }}"
                                    alt="{{ $student->name }}"
                                    loading="lazy"
                                    class="h-14 w-14 shrink-0 rounded-xl border border-gray-200 object-cover">

                            @else

                                <div
                                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[#e7f1fb] text-lg font-bold text-[#347ec0]">

                                    {{ strtoupper(substr($student->name, 0, 1)) }}

                                </div>

                            @endif


                            <div class="min-w-0">

                                <h3
                                    class="truncate text-sm font-bold text-[#111827]"
                                    title="{{ $student->name }}">

                                    {{ $student->name }}

                                </h3>

                                <div class="mt-1 flex items-center gap-1.5">

                                    <i
                                        data-lucide="user-round"
                                        class="h-3 w-3 shrink-0 text-gray-400">
                                    </i>

                                    <span
                                        class="truncate text-[11px] text-gray-500"
                                        title="{{ $student->father }}">

                                        {{ $student->father }}

                                    </span>

                                </div>

                            </div>

                        </div>


                        {{-- LIBRARY + SEAT --}}
                        <div class="mx-3.5 grid grid-cols-2 gap-2">

                            {{-- Library --}}
                            <div
                                class="min-w-0 rounded-lg border border-[#e5eaf0] bg-[#f8fafc] px-2.5 py-2">

                                <div class="flex items-center gap-1.5">

                                    <div
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#e7f1fb] text-[#347ec0]">

                                        <i
                                            data-lucide="library"
                                            class="h-3.5 w-3.5">
                                        </i>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[8px] font-semibold uppercase tracking-wide text-gray-400">
                                            Library
                                        </p>

                                        @if($activeLibrary)

                                            <p
                                                class="truncate text-[11px] font-semibold text-gray-700"
                                                title="{{ $activeLibrary->name }}">

                                                {{ $activeLibrary->name }}

                                            </p>

                                        @else

                                            <p class="text-[11px] font-medium text-gray-400">
                                                Not Assigned
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Seat --}}
                            <div
                                class="min-w-0 rounded-lg border border-[#e5eaf0] bg-[#f8fafc] px-2.5 py-2">

                                <div class="flex items-center gap-1.5">

                                    <div
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-gray-100 text-gray-600">

                                        <i
                                            data-lucide="armchair"
                                            class="h-3.5 w-3.5">
                                        </i>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[8px] font-semibold uppercase tracking-wide text-gray-400">
                                            Seat
                                        </p>

                                        @if($activeSeat)

                                            <p class="text-[11px] font-bold text-gray-700">

                                                {{ $activeSeat->seat_number }}

                                            </p>

                                        @else

                                            <p class="text-[11px] font-medium text-gray-400">
                                                Not Assigned
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- VILLAGE + MOBILE --}}
                        <div class="mx-3.5 grid grid-cols-2 gap-2">

                            {{-- Village --}}
                            <div
                                class="my-2 min-w-0 rounded-lg border border-[#e5eaf0] bg-[#f8fafc] px-2.5 py-2">

                                <div class="flex items-center gap-1.5">

                                    <div
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-[#e7f1fb] text-[#347ec0]">

                                        <i
                                            data-lucide="map-pin"
                                            class="h-3.5 w-3.5">
                                        </i>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[8px] font-semibold uppercase tracking-wide text-gray-400">
                                            Village
                                        </p>

                                        <p
                                            class="truncate text-[11px] font-semibold text-gray-700"
                                            title="{{ $student->village }}">

                                            {{ $student->village }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Mobile --}}
                            <div
                                class="my-2 min-w-0 rounded-lg border border-[#e5eaf0] bg-[#f8fafc] px-2.5 py-2">

                                <div class="flex items-center gap-1.5">

                                    <div
                                        class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-gray-100 text-gray-600">

                                        <i
                                            data-lucide="phone"
                                            class="h-3.5 w-3.5">
                                        </i>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-[8px] font-semibold uppercase tracking-wide text-gray-400">
                                            Mobile
                                        </p>

                                        <p class="text-[11px] font-bold text-gray-700">
                                            {{ $student->mobile }}
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FOOTER --}}
                        <div
                            class="absolute bottom-0 left-0 right-0 flex items-center justify-between border-t border-gray-100 bg-white px-3.5 py-2.5">

                            {{-- Flip Hint --}}
                            <div class="flex items-center gap-1.5 text-[10px] text-gray-400">

                                <i
                                    data-lucide="rotate-3d"
                                    class="h-3.5 w-3.5">
                                </i>

                                More details

                            </div>


                            {{-- ACTIONS --}}
                            <div class="flex items-center gap-1.5">

                                {{-- Edit --}}
                                <a
                                    href="{{ route('student.edit', $student->id) }}"
                                    onclick="event.stopPropagation()"
                                    class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-lg bg-amber-50 text-amber-600 transition hover:bg-amber-100"
                                    title="Edit Student">

                                    <i
                                        data-lucide="square-pen"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </a>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('student.destroy', $student->id) }}"
                                    method="POST"
                                    onclick="event.stopPropagation()"
                                    onsubmit="return confirm('Are you sure you want to delete {{ addslashes($student->name) }}?');">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-lg bg-red-50 text-red-600 transition hover:bg-red-100"
                                        title="Delete Student">

                                        <i
                                            data-lucide="trash-2"
                                            class="h-3.5 w-3.5">
                                        </i>

                                    </button>

                                </form>


                                {{-- Wallet --}}
                                <button
                                    type="button"
                                    onclick="event.stopPropagation(); window.location.href='{{ route('admin.wallet.history', $student->id) }}'"
                                    class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-lg bg-green-50 text-green-600 transition hover:bg-green-100"
                                    title="Wallet">

                                    <i
                                        data-lucide="wallet"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </button>


                                {{-- Fees --}}
                                <a
                                    href="{{ route('admin.student.fees', $student->id) }}"
                                    onclick="event.stopPropagation()"
                                    class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition hover:bg-blue-100"
                                    title="Fees">

                                    <i
                                        data-lucide="receipt"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </a>

                            </div>

                        </div>

                    </div>


                    {{-- ================= BACK ================= --}}

                    <div
                        class="student-card-back absolute inset-0 overflow-hidden rounded-xl border border-[#e5eaf0] bg-white shadow-[0_1px_3px_rgba(16,24,40,0.04)]">

                        {{-- Header --}}
                        <div
                            class="flex items-center justify-between border-b border-gray-100 px-3.5 py-2.5">

                            <div class="flex items-center gap-2">

                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e7f1fb] text-[#347ec0]">

                                    <i
                                        data-lucide="file-user"
                                        class="h-4 w-4">
                                    </i>

                                </div>

                                <div>

                                    <p class="text-[9px] font-semibold uppercase tracking-wider text-gray-400">
                                        Student
                                    </p>

                                    <p class="text-xs font-semibold text-gray-700">
                                        Documents
                                    </p>

                                </div>

                            </div>

                            <i
                                data-lucide="rotate-ccw"
                                class="h-4 w-4 text-gray-400">
                            </i>

                        </div>


                        {{-- Details --}}
                        <div class="space-y-2.5 px-3.5 py-3">

                            {{-- Aadhaar --}}
                            <div
                                class="flex items-center gap-2.5 rounded-lg bg-gray-50 px-2.5 py-2">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-white text-gray-500">

                                    <i
                                        data-lucide="credit-card"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[8px] uppercase tracking-wide text-gray-400">
                                        Aadhaar
                                    </p>

                                    <p class="truncate text-[11px] font-semibold text-gray-800">

                                        {{ $student->aadhar_no ?: 'Not Added' }}

                                    </p>

                                </div>

                            </div>


                            {{-- Biometric --}}
                            <div
                                class="flex items-center gap-2.5 rounded-lg bg-gray-50 px-2.5 py-2">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-white text-gray-500">

                                    <i
                                        data-lucide="fingerprint"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[8px] uppercase tracking-wide text-gray-400">
                                        Biometric
                                    </p>

                                    <p class="truncate text-[11px] font-semibold text-gray-800">

                                        {{ $student->biometric_no ?: 'Not Added' }}

                                    </p>

                                </div>

                            </div>


                            {{-- Library --}}
                            <div
                                class="flex items-center gap-2.5 rounded-lg bg-gray-50 px-2.5 py-2">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-white text-[#2874b9]">

                                    <i
                                        data-lucide="library"
                                        class="h-3.5 w-3.5">
                                    </i>

                                </div>

                                <div class="min-w-0">

                                    <p class="text-[8px] uppercase tracking-wide text-gray-400">
                                        Library / Seat
                                    </p>

                                    <p class="truncate text-[11px] font-semibold text-gray-800">

                                        @if($activeLibrary && $activeSeat)

                                            {{ $activeLibrary->name }}
                                            · Seat {{ $activeSeat->seat_number }}

                                        @elseif($activeLibrary)

                                            {{ $activeLibrary->name }}

                                        @elseif($activeSeat)

                                            Seat {{ $activeSeat->seat_number }}

                                        @else

                                            Not Assigned

                                        @endif

                                    </p>

                                </div>

                            </div>


                            {{-- ID Proof --}}
                            <div class="flex gap-2 pt-0.5">

                                @if($student->id_front)

                                    <a
                                        href="{{ asset('storage/' . $student->id_front) }}"
                                        target="_blank"
                                        onclick="event.stopPropagation()"
                                        class="flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-200 px-2 py-2 text-[10px] font-semibold text-gray-600 transition hover:bg-gray-50">

                                        <i
                                            data-lucide="image"
                                            class="h-3.5 w-3.5">
                                        </i>

                                        Front

                                    </a>

                                @endif


                                @if($student->id_back)

                                    <a
                                        href="{{ asset('storage/' . $student->id_back) }}"
                                        target="_blank"
                                        onclick="event.stopPropagation()"
                                        class="flex flex-1 cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-gray-200 px-2 py-2 text-[10px] font-semibold text-gray-600 transition hover:bg-gray-50">

                                        <i
                                            data-lucide="image"
                                            class="h-3.5 w-3.5">
                                        </i>

                                        Back

                                    </a>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    @else

        {{-- ================= NO STUDENT ================= --}}

        <div
            class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-12 text-center">

            <div
                class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

                <i
                    data-lucide="user-x"
                    class="h-6 w-6">
                </i>

            </div>

            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                No Student Found
            </h3>

            <p class="mt-1 text-xs text-gray-500">
                Try another student name or seat number.
            </p>

        </div>

    @endif

</div>


{{-- ================= PAGINATION ================= --}}

<div id="studentPagination">

    @if($students->hasPages())

        <div
            class="mt-6 flex items-center justify-between rounded-xl border border-gray-200 bg-white px-4 py-3">

            {{-- Previous --}}
            <div>

                @if($students->onFirstPage())

                    <span
                        class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-gray-200 px-3 text-xs font-medium text-gray-300">

                        <i
                            data-lucide="chevron-left"
                            class="h-4 w-4">
                        </i>

                        Previous

                    </span>

                @else

                    <a
                        href="{{ $students->previousPageUrl() }}"
                        class="inline-flex h-9 cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 px-3 text-xs font-medium text-gray-600 transition hover:border-[#2874b9] hover:bg-[#e7f1fb] hover:text-[#2874b9]">

                        <i
                            data-lucide="chevron-left"
                            class="h-4 w-4">
                        </i>

                        Previous

                    </a>

                @endif

            </div>


            {{-- Pages --}}
            <div class="flex items-center gap-1">

                @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)

                    @if($page == $students->currentPage())

                        <span
                            class="inline-flex h-9 min-w-9 items-center justify-center rounded-lg bg-[#2874b9] px-2.5 text-xs font-semibold text-white shadow-sm">

                            {{ $page }}

                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="inline-flex h-9 min-w-9 cursor-pointer items-center justify-center rounded-lg border border-gray-200 bg-white px-2.5 text-xs font-medium text-gray-600 transition hover:border-[#2874b9] hover:bg-[#e7f1fb] hover:text-[#2874b9]">

                            {{ $page }}

                        </a>

                    @endif

                @endforeach

            </div>


            {{-- Next --}}
            <div>

                @if($students->hasMorePages())

                    <a
                        href="{{ $students->nextPageUrl() }}"
                        class="inline-flex h-9 cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 px-3 text-xs font-medium text-gray-600 transition hover:border-[#2874b9] hover:bg-[#e7f1fb] hover:text-[#2874b9]">

                        Next

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4">
                        </i>

                    </a>

                @else

                    <span
                        class="inline-flex h-9 items-center gap-1.5 rounded-lg border border-gray-200 px-3 text-xs font-medium text-gray-300">

                        Next

                        <i
                            data-lucide="chevron-right"
                            class="h-4 w-4">
                        </i>

                    </span>

                @endif

            </div>

        </div>

    @endif

</div>

</div>

{{-- ================= FLIP CARD CSS ================= --}}

<style>

.student-card {
    perspective: 1000px;
}

.student-card-inner {
    transform-style: preserve-3d;
    transition: transform 0.5s ease;
}

.student-card.flipped .student-card-inner {
    transform: rotateY(180deg);
}

.student-card-front,
.student-card-back {
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
}

.student-card-back {
    transform: rotateY(180deg);
}

</style>

{{-- ================= WALLET MODAL ================= --}}

<div
    id="walletModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

<div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-lg font-semibold text-gray-900">
                Add Money
            </h2>

            <p class="mt-1 text-sm text-gray-500">

                Student:

                <span
                    id="walletStudentName"
                    class="font-semibold text-gray-700">
                </span>

            </p>

        </div>

        <button
            type="button"
            onclick="closeWalletModal()"
            class="flex h-8 w-8 cursor-pointer items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600">

            <i
                data-lucide="x"
                class="h-4 w-4">
            </i>

        </button>

    </div>


    <form
        id="walletForm"
        method="POST"
        class="mt-6 space-y-4">

        @csrf

        {{-- Amount --}}
        <div>

            <label class="mb-1 block text-sm font-medium text-gray-700">
                Amount
            </label>

            <div class="relative">

                <span
                    class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                    ₹
                </span>

                <input
                    type="number"
                    name="amount"
                    min="1"
                    step="0.01"
                    required
                    placeholder="Enter amount"
                    class="w-full rounded-xl border border-gray-300 py-3 pl-8 pr-3 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

            </div>

        </div>


        {{-- Date --}}
        <div>

            <label class="mb-1 block text-sm font-medium text-gray-700">
                Date
            </label>

            <input
                type="date"
                name="transaction_date"
                value="{{ date('Y-m-d') }}"
                required
                class="w-full rounded-xl border border-gray-300 px-3 py-3 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Description --}}
        <div>

            <label class="mb-1 block text-sm font-medium text-gray-700">
                Description
            </label>

            <input
                type="text"
                name="description"
                placeholder="Example: Cash Deposit"
                class="w-full rounded-xl border border-gray-300 px-3 py-3 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Buttons --}}
        <div class="flex justify-end gap-3 pt-2">

            <button
                type="button"
                onclick="closeWalletModal()"
                class="cursor-pointer rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">

                Cancel

            </button>

            <button
                type="submit"
                class="cursor-pointer rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700">

                Add Money

            </button>

        </div>

    </form>

</div>

</div>

{{-- ================= JAVASCRIPT ================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* ================= STUDENT MODAL ================= */

    const studentModal =
        document.getElementById('studentModal');

    const studentForm =
        document.getElementById('studentForm');


    function openStudentModal() {

        if (!studentModal) {
            return;
        }

        studentModal.classList.remove('hidden');
        studentModal.classList.add('flex');

        document.body.classList.add('overflow-hidden');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    }


    function closeStudentModal() {

        if (!studentModal) {
            return;
        }

        studentModal.classList.add('hidden');
        studentModal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');

    }


    window.openStudentModal =
        openStudentModal;

    window.closeStudentModal =
        closeStudentModal;


    if (studentModal) {

        studentModal.addEventListener(
            'click',
            function (event) {

                if (event.target === studentModal) {

                    closeStudentModal();

                }

            }
        );

    }


    /* ================= WALLET MODAL ================= */

    const walletModal =
        document.getElementById('walletModal');


    window.openWalletModal =
        function (studentId, studentName) {

            if (!walletModal) {
                return;
            }

            const form =
                document.getElementById('walletForm');

            const name =
                document.getElementById('walletStudentName');


            form.action =
                '/students/' +
                studentId +
                '/wallet/add-money';


            name.textContent =
                studentName;


            walletModal.classList.remove('hidden');
            walletModal.classList.add('flex');

            document.body.classList.add('overflow-hidden');


            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        };


    window.closeWalletModal =
        function () {

            if (!walletModal) {
                return;
            }

            walletModal.classList.add('hidden');
            walletModal.classList.remove('flex');

            document.body.classList.remove('overflow-hidden');

        };


    if (walletModal) {

        walletModal.addEventListener(
            'click',
            function (event) {

                if (event.target === walletModal) {

                    window.closeWalletModal();

                }

            }
        );

    }


    /* ================= ESC KEY ================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {

                closeStudentModal();

                if (window.closeWalletModal) {
                    window.closeWalletModal();
                }

            }

        }
    );


    /* ================= LUCIDE ================= */

    if (typeof lucide !== 'undefined') {

        lucide.createIcons();

    }


    /* ================= AADHAAR LIVE CHECK ================= */

    const aadharInput =
        document.getElementById('aadharInput');

    const aadharMessage =
        document.getElementById('aadharMessage');

    const aadharIcon =
        document.getElementById('aadharIcon');

    const saveStudentButton =
        document.getElementById('saveStudentButton');


    let aadharTimer;

    let aadharExists = false;

    let aadharChecking = false;


    function resetAadharState() {

        aadharExists = false;
        aadharChecking = false;

        if (!aadharInput) {
            return;
        }

        aadharInput.classList.remove(
            'border-red-500',
            'border-green-500'
        );

        aadharInput.classList.add(
            'border-gray-300'
        );

        if (aadharMessage) {

            aadharMessage.className =
                'hidden text-xs font-medium';

            aadharMessage.textContent =
                '';

        }

        if (aadharIcon) {

            aadharIcon.classList.add('hidden');

            aadharIcon.innerHTML =
                '';

        }

        if (saveStudentButton) {

            saveStudentButton.disabled =
                false;

            saveStudentButton.classList.remove(
                'cursor-not-allowed',
                'opacity-60'
            );

            saveStudentButton.classList.add(
                'cursor-pointer'
            );

        }

    }


    function setAadharChecking() {

        aadharExists = false;
        aadharChecking = true;

        aadharInput.classList.remove(
            'border-red-500',
            'border-green-500'
        );

        aadharInput.classList.add(
            'border-gray-300'
        );

        if (aadharMessage) {

            aadharMessage.className =
                'text-xs font-medium text-gray-500';

            aadharMessage.textContent =
                'Checking Aadhaar...';

        }

        if (aadharIcon) {

            aadharIcon.classList.remove('hidden');

            aadharIcon.innerHTML =
                '<i data-lucide="loader-circle" class="h-4 w-4 animate-spin text-gray-400"></i>';

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        }

        if (saveStudentButton) {

            saveStudentButton.disabled =
                true;

            saveStudentButton.classList.remove(
                'cursor-pointer'
            );

            saveStudentButton.classList.add(
                'cursor-not-allowed',
                'opacity-60'
            );

        }

    }


    function setAadharResult(exists) {

        aadharExists = exists;
        aadharChecking = false;

        if (aadharIcon) {

            aadharIcon.classList.remove('hidden');

        }


        if (exists) {

            aadharInput.classList.remove(
                'border-gray-300',
                'border-green-500'
            );

            aadharInput.classList.add(
                'border-red-500'
            );


            if (aadharMessage) {

                aadharMessage.className =
                    'text-xs font-medium text-red-600';

                aadharMessage.textContent =
                    'This Aadhaar number is already used.';

            }


            if (aadharIcon) {

                aadharIcon.innerHTML =
                    '<i data-lucide="circle-x" class="h-4 w-4 text-red-500"></i>';

            }


            if (saveStudentButton) {

                saveStudentButton.disabled =
                    true;

                saveStudentButton.classList.remove(
                    'cursor-pointer'
                );

                saveStudentButton.classList.add(
                    'cursor-not-allowed',
                    'opacity-60'
                );

            }

        } else {

            aadharInput.classList.remove(
                'border-gray-300',
                'border-red-500'
            );

            aadharInput.classList.add(
                'border-green-500'
            );


            if (aadharMessage) {

                aadharMessage.className =
                    'text-xs font-medium text-green-600';

                aadharMessage.textContent =
                    'Aadhaar number is available.';

            }


            if (aadharIcon) {

                aadharIcon.innerHTML =
                    '<i data-lucide="circle-check" class="h-4 w-4 text-green-500"></i>';

            }


            if (saveStudentButton) {

                saveStudentButton.disabled =
                    false;

                saveStudentButton.classList.remove(
                    'cursor-not-allowed',
                    'opacity-60'
                );

                saveStudentButton.classList.add(
                    'cursor-pointer'
                );

            }

        }


        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    }


    if (aadharInput) {

        aadharInput.addEventListener(
            'input',
            function () {

                clearTimeout(aadharTimer);

                const aadhar =
                    this.value
                        .replace(/\D/g, '')
                        .slice(0, 12);

                this.value =
                    aadhar;


                resetAadharState();


                if (aadhar.length !== 12) {

                    return;

                }


                setAadharChecking();


                aadharTimer =
                    setTimeout(
                        function () {

                            fetch(
                                '{{ route("student.check-aadhar") }}?aadhar_no=' +
                                encodeURIComponent(aadhar),
                                {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    }
                                }
                            )
                            .then(
                                function (response) {

                                    if (!response.ok) {
                                        throw new Error(
                                            'Aadhaar check failed'
                                        );
                                    }

                                    return response.json();

                                }
                            )
                            .then(
                                function (data) {

                                    if (
                                        aadharInput.value !== aadhar
                                    ) {
                                        return;
                                    }

                                    setAadharResult(
                                        data.exists === true
                                    );

                                }
                            )
                            .catch(
                                function () {

                                    aadharChecking =
                                        false;

                                    aadharExists =
                                        false;


                                    if (aadharMessage) {

                                        aadharMessage.className =
                                            'text-xs font-medium text-gray-500';

                                        aadharMessage.textContent =
                                            'Unable to check Aadhaar right now. Please try again.';

                                    }


                                    if (aadharIcon) {

                                        aadharIcon.classList.add(
                                            'hidden'
                                        );

                                    }


                                    if (saveStudentButton) {

                                        saveStudentButton.disabled =
                                            false;

                                        saveStudentButton.classList.remove(
                                            'cursor-not-allowed',
                                            'opacity-60'
                                        );

                                        saveStudentButton.classList.add(
                                            'cursor-pointer'
                                        );

                                    }

                                }
                            );

                        },
                        300
                    );

            }
        );

    }


    /* ================= FORM SUBMIT GUARD ================= */

    if (studentForm) {

        studentForm.addEventListener(
            'submit',
            function (event) {

                const aadhar =
                    aadharInput
                        ? aadharInput.value.trim()
                        : '';


                if (aadhar.length !== 12) {

                    event.preventDefault();

                    if (aadharInput) {
                        aadharInput.focus();
                    }

                    return;

                }


                if (aadharChecking) {

                    event.preventDefault();

                    if (aadharMessage) {

                        aadharMessage.className =
                            'text-xs font-medium text-gray-500';

                        aadharMessage.textContent =
                            'Please wait while Aadhaar is being checked.';

                    }

                    if (aadharInput) {
                        aadharInput.focus();
                    }

                    return;

                }


                if (aadharExists) {

                    event.preventDefault();

                    if (aadharInput) {
                        aadharInput.focus();
                    }

                    return;

                }

            }
        );

    }

});


/* ================= LIVE SEARCH ================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const searchInput =
            document.getElementById('studentSearch');

        const libraryFilter =
            document.getElementById('libraryFilter');


        if (!searchInput || !libraryFilter) {
            return;
        }


        let searchTimer;


        function searchStudents() {

            const search =
                searchInput.value;

            const libraryId =
                libraryFilter.value;


            const params =
                new URLSearchParams();


            if (search.trim() !== '') {

                params.set(
                    'search',
                    search
                );

            }


            if (libraryId !== '') {

                params.set(
                    'library_id',
                    libraryId
                );

            }


            fetch(
                '{{ route("admin.student.index") }}?' +
                params.toString(),
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            )
            .then(
                function (response) {
                    return response.text();
                }
            )
            .then(
                function (html) {

                    const parser =
                        new DOMParser();


                    const doc =
                        parser.parseFromString(
                            html,
                            'text/html'
                        );


                    /* Student Results */

                    const newResults =
                        doc.getElementById(
                            'studentResults'
                        );

                    const oldResults =
                        document.getElementById(
                            'studentResults'
                        );


                    if (newResults && oldResults) {

                        oldResults.innerHTML =
                            newResults.innerHTML;

                    }


                    /* Pagination */

                    const newPagination =
                        doc.getElementById(
                            'studentPagination'
                        );

                    const oldPagination =
                        document.getElementById(
                            'studentPagination'
                        );


                    if (newPagination && oldPagination) {

                        oldPagination.innerHTML =
                            newPagination.innerHTML;

                    }


                    /* URL */

                    const newUrl =
                        '{{ route("admin.student.index") }}' +
                        (
                            params.toString()
                                ? '?' + params.toString()
                                : ''
                        );


                    window.history.replaceState(
                        {},
                        '',
                        newUrl
                    );


                    /* Lucide */

                    if (typeof lucide !== 'undefined') {

                        lucide.createIcons();

                    }

                }
            )
            .catch(
                function (error) {

                    console.error(
                        'Search error:',
                        error
                    );

                }
            );

        }


        /* Search while typing */

        searchInput.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        function () {

                            searchStudents();

                        },
                        400
                    );

            }
        );


        /* Library filter */

        libraryFilter.addEventListener(
            'change',
            function () {

                searchStudents();

            }
        );

    }
);

</script>

@endsection
