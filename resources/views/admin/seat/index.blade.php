@extends('admin.layouts.app')

@section('title', 'Seats')

@section('content')

{{-- Header --}}

<div class="mb-6 flex items-center justify-between">

<div>

    <h1 class="text-2xl font-bold text-[#111827]">
        {{ $seats->count() }}-Seats
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Manage all library seats
    </p>

    {{-- Library Filter --}}
    <form
        method="GET"
        action="{{ route('admin.seat.index') }}"
        class="mt-4">

        <select
            name="library_id"
            onchange="this.form.submit()"
            class="rounded-xl border w-40 border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

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

</div>

{{-- Header Buttons --}}
<div class="flex items-center gap-3">

    <button
        type="button"
        onclick="openBulkPlanModal()"
        class="rounded-xl border border-[#2874b9] bg-white px-5 py-3 text-sm font-semibold text-[#2874b9] hover:bg-[#e7f1fb]">

        Change Plans

    </button>

    <button
        type="button"
        onclick="openSeatModal()"
        class="rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white hover:bg-[#2167a7]">


            <i data-lucide="armchair"></i>

        

    </button>

</div>

</div>

{{-- Success Message --}}
@if(session('success'))

<div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

    {{ session('success') }}

</div>

@endif

{{-- Error Message --}}
@if(session('error'))

<div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

    {{ session('error') }}

</div>

@endif

{{-- Validation Errors --}}
@if($errors->any())

<div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

    <ul class="list-disc pl-5">

        @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

        @endforeach

    </ul>

</div>

@endif

{{-- ========================================================= --}}
{{-- SEAT CARDS --}}
{{-- ========================================================= --}}

<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-6">

@forelse($seats as $seat)


<div class="stat-card">

    {{-- Card Top --}}
    <div class="kaki flex justify-between gap-6">

        <div class="icon-box bg-[#e7f1fb] text-[#347ec0]">

            <i data-lucide="armchair"></i>

        </div>


        {{-- Actions --}}
        <div class="icon-box flex gap-3 text-2xl">  
            {{-- Delete --}}
            <form
                action="{{ route('admin.seat.destroy', $seat->id) }}"
                method="POST"
                class="inline"
                onsubmit="return confirm('Are you sure you want to delete this seat?');">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="text-red-600"
                    title="Delete Seat">

                    <i data-lucide="trash"></i>

                </button>

            </form>

        </div>

    </div>


    {{-- Library --}}
    <h4 class="mt-5 text-xs text-gray-500">

        {{ $seat->library->name }}

    </h4>


    {{-- Seat Number --}}
    <h2>

        {{ $seat->seat_number }}

    </h2>


    {{-- Status --}}
    <div class="mt-4">

        @if($seat->activeAssignment)

            {{-- Assigned Student --}}
            <div class="mb-3 rounded-xl bg-gray-50 px-3 py-2">

                <div class="flex items-center gap-2">

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#e7f1fb] text-[#2874b9]">

                        <i
                            data-lucide="user"
                            class="h-4 w-4">
                        </i>

                    </div>


                    <div class="min-w-0">

                        <p class="truncate text-xs font-semibold text-gray-800">

                            {{ $seat->activeAssignment->student?->name ?? 'Student' }}

                        </p>


                        <p class="text-[10px] text-gray-400">

                            {{ $seat->activeAssignment->fees?->fees ?? 'Monthly' }}

                            @if($seat->activeAssignment->fees)

                                ·

                                ₹{{ number_format(
                                    (float) $seat->activeAssignment->fees->amount,
                                    2
                                ) }}

                            @endif

                        </p>

                    </div>

                </div>


                <div class="mt-2 flex items-center gap-1.5 text-[10px] text-gray-400">

                    <i
                        data-lucide="calendar-days"
                        class="h-3 w-3">
                    </i>

                    From

                    {{ $seat->activeAssignment->assign_date?->format('d M Y') }}

                </div>

            </div>


            {{-- Occupied --}}
            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">

                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                Occupied

            </span>

        @else

            {{-- Available --}}
            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">

                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                Available

            </span>

        @endif

    </div>

</div>


@empty


{{-- ================================================= --}}
{{-- EMPTY STATE --}}
{{-- ================================================= --}}

<div
    class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

    <div
        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

        <i
            data-lucide="armchair"
            class="h-6 w-6">
        </i>

    </div>

    <h3 class="mt-4 text-base font-semibold text-gray-900">

        No seats found

    </h3>

    <p class="mt-1 text-sm text-gray-500">

        Add your first seat to get started.

    </p>

</div>


@endforelse

</div>

{{-- ========================================================= --}}
{{-- RELEASE STUDENT MODAL --}}
{{-- ========================================================= --}}

<div
    id="releaseModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">


<div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">

    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-orange-500">

        <i
            data-lucide="user-round-minus"
            class="h-6 w-6">
        </i>

    </div>


    <h2 class="mt-4 text-lg font-semibold text-gray-900">

        Release Student?

    </h2>


    <p class="mt-2 text-sm text-gray-500">

        Are you sure you want to release

        <span
            id="releaseStudentName"
            class="font-semibold text-gray-800">
        </span>

        from this seat?

    </p>


    <p class="mt-2 text-xs text-gray-400">

        The assignment history will be preserved.

    </p>


    <form
        id="releaseForm"
        method="POST"
        class="mt-6 flex justify-end gap-3">

        @csrf

        <button
            type="button"
            onclick="closeReleaseModal()"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

            Cancel

        </button>


        <button
            type="submit"
            class="inline-flex items-center gap-2 rounded-lg bg-orange-500 px-4 py-2 text-sm font-medium text-white hover:bg-orange-600">

            <i
                data-lucide="user-round-minus"
                class="h-4 w-4">
            </i>

            Release

        </button>

    </form>

</div>


</div>

{{-- ========================================================= --}}
{{-- ADD SEAT MODAL --}}
{{-- ========================================================= --}}

<div
    id="seatModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">


<div
    class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white p-6 shadow-xl">

    {{-- Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">

                Add Seat

            </h2>

            <p class="mt-0.5 text-xs text-gray-500">

                Add a new seat to a library

            </p>

        </div>


        <button
            type="button"
            onclick="closeSeatModal()"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">

            <i data-lucide="x" class="h-4 w-4"></i>

        </button>

    </div>


    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('admin.seat.store') }}"
        class="mt-6 space-y-4">

        @csrf


        {{-- Library --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">

                Library

                <span class="text-red-500">*</span>

            </label>


            <select
                name="library_id"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <option value="">
                    Select Library
                </option>

                @foreach($libraries as $library)

                    <option value="{{ $library->id }}">

                        {{ $library->name }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Seat Number --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">

                Seat Number

                <span class="text-red-500">*</span>

            </label>


            <input
                type="text"
                name="seat_number"
                placeholder="e.g. 1"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 placeholder-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end space-x-3 pt-4">

            <button
                type="button"
                onclick="closeSeatModal()"
                class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

                Cancel

            </button>


            <button
                type="submit"
                class="rounded-lg bg-blue-500 px-5 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-600">

                Save Seat

            </button>

        </div>

    </form>

</div>


</div>

{{-- ========================================================= --}}
{{-- ASSIGN STUDENT MODAL --}}
{{-- ========================================================= --}}

<div
    id="assignModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

<div
    class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white p-6 shadow-xl">

    {{-- Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">

                Assign Student

            </h2>

            <p class="mt-0.5 text-xs text-gray-500">

                Assign a student to this seat

            </p>

        </div>


        <button
            type="button"
            onclick="closeAssignModal()"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600">

            <i data-lucide="x" class="h-4 w-4"></i>

        </button>

    </div>


    {{-- Form --}}
    <form
        id="assignForm"
        method="POST"
        class="mt-6 space-y-4">

        @csrf


        {{-- Student --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">

                Student

                <span class="text-red-500">*</span>

            </label>


            <select
                name="student_id"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <option value="">
                    Select Student
                </option>

                @forelse($availableStudents as $student)

    <option value="{{ $student->id }}">
        {{ $student->name }} - {{ $student->mobile }}
    </option>

@empty

    <option value="" disabled>
        No available students
    </option>

@endforelse

            </select>

        </div>


        {{-- Assign Date --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">

                Assign Date

                <span class="text-red-500">*</span>

            </label>


            <input
                type="date"
                name="assign_date"
                value="{{ date('Y-m-d') }}"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

            <p class="text-[11px] text-gray-400">

                Fee calculation will start from this date.

            </p>

        </div>


        {{-- Fee Plan --}}
        <div class="space-y-1.5">

            <label class="block text-sm font-medium text-gray-700">

                Monthly Fee

                <span class="text-red-500">*</span>

            </label>


            <select
                name="fees_id"
                id="feesPlan"
                required
                disabled
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">

                <option value="">
                    Select Monthly Fee
                </option>

            </select>


            <p
                id="feePlanMessage"
                class="text-[11px] text-gray-400">

                Select a seat to view its library's monthly fee.

            </p>

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-4">

            <button
                type="button"
                onclick="closeAssignModal()"
                class="rounded-lg border border-gray-300 bg-white px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

                Cancel

            </button>


            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-5 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#2167a7]">

                <i
                    data-lucide="user-plus"
                    class="h-4 w-4">
                </i>

                Assign Student

            </button>

        </div>

    </form>

</div>


</div>

{{-- ========================================================= --}}
{{-- BULK CHANGE FEE PLAN MODAL --}}
{{-- ========================================================= --}}

<div
    id="bulkPlanModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">


<div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

    {{-- Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">

                Change Monthly Fee

            </h2>

            <p class="mt-1 text-xs text-gray-500">

                Change monthly fee for all assigned students

            </p>

        </div>


        <button
            type="button"
            onclick="closeBulkPlanModal()"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100">

            <i data-lucide="x" class="h-4 w-4"></i>

        </button>

    </div>


    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('admin.seat.bulk-change-plan') }}"
        class="mt-6 space-y-4">

        @csrf


        {{-- Library --}}
        <div>

            <label class="mb-1.5 block text-sm font-medium text-gray-700">

                Library

                <span class="text-red-500">*</span>

            </label>


            <select
                name="library_id"
                id="bulkLibrary"
                onchange="loadBulkPlans()"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm">

                <option value="">
                    Select Library
                </option>

                @foreach($libraries as $library)

                    <option value="{{ $library->id }}">

                        {{ $library->name }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- Monthly Fee --}}
        <div>

            <label class="mb-1.5 block text-sm font-medium text-gray-700">

                New Monthly Fee

                <span class="text-red-500">*</span>

            </label>


            <select
                name="fees_id"
                id="bulkFeePlan"
                required
                disabled
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm">

                <option value="">
                    Select Library First
                </option>

            </select>


            <p
                id="bulkPlanMessage"
                class="mt-1 text-[11px] text-gray-400">

                Select a library to view its monthly fee.

            </p>

        </div>


        {{-- Warning --}}
        <div class="rounded-xl bg-orange-50 p-3 text-xs text-orange-700">

            This will change the monthly fee for all currently assigned
            students in this library.

        </div>


        {{-- Buttons --}}
        <div class="flex justify-end gap-3 pt-3">

            <button
                type="button"
                onclick="closeBulkPlanModal()"
                class="rounded-lg border border-gray-300 px-5 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">

                Cancel

            </button>


            <button
                type="submit"
                onclick="return confirm('Are you sure you want to change the monthly fee for all assigned students?');"
                class="rounded-lg bg-[#2874b9] px-5 py-2 text-sm font-medium text-white hover:bg-[#2167a7]">

                Change Fee

            </button>

        </div>

    </form>

</div>


</div>

{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

/*
|--------------------------------------------------------------------------
| NEW SIMPLE FEE SYSTEM
|--------------------------------------------------------------------------
| Only Fees records are used.
|
| Example:
| Library A -> Monthly -> ₹900
| Library B -> Monthly -> ₹1000
|
|
| No duration
| No duration_type
|--------------------------------------------------------------------------
*/

const fees = @json($fees);


/*
|--------------------------------------------------------------------------
| Seat Modal
|--------------------------------------------------------------------------
*/

function openSeatModal()
{
    const modal = document.getElementById('seatModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeSeatModal()
{
    const modal = document.getElementById('seatModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Release Modal
|--------------------------------------------------------------------------
*/

function openReleaseModal(seatId, studentName)
{
    const modal = document.getElementById('releaseModal');
    const form = document.getElementById('releaseForm');
    const name = document.getElementById('releaseStudentName');

    form.action = '/seats/' + seatId + '/release';

    name.textContent = studentName;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeReleaseModal()
{
    const modal = document.getElementById('releaseModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Assign Student Modal
|--------------------------------------------------------------------------
*/

function openAssignModal(seatId, libraryId)
{
    const modal = document.getElementById('assignModal');
    const form = document.getElementById('assignForm');

    const feeSelect =
        document.getElementById('feesPlan');

    const message =
        document.getElementById('feePlanMessage');


    /*
    |--------------------------------------------------------------------------
    | Form Action
    |--------------------------------------------------------------------------
    */

    form.action = '/seats/' + seatId + '/assign';


    /*
    |--------------------------------------------------------------------------
    | Reset Fee Select
    |--------------------------------------------------------------------------
    */

    feeSelect.innerHTML = `
        <option value="">
            Select Monthly Fee
        </option>
    `;

    feeSelect.disabled = true;


    /*
    |--------------------------------------------------------------------------
    | Find Monthly Fees For Selected Library
    |--------------------------------------------------------------------------
    */

    const libraryFees = fees.filter(function (fee) {

        return Number(fee.library_id) === Number(libraryId)
            && fee.fees === 'Monthly';

    });


    /*
    |--------------------------------------------------------------------------
    | No Fee Found
    |--------------------------------------------------------------------------
    */

    if (libraryFees.length === 0) {

        message.textContent =
            'No monthly fee plan found for this library.';

        message.classList.remove('text-gray-400');

        message.classList.add('text-red-500');

    }


    /*
    |--------------------------------------------------------------------------
    | Fee Found
    |--------------------------------------------------------------------------
    */

    else {

        message.textContent =
            libraryFees.length +
            ' monthly fee option(s) available.';

        message.classList.remove('text-red-500');

        message.classList.add('text-gray-400');

        feeSelect.disabled = false;


        libraryFees.forEach(function (fee) {

            const option =
                document.createElement('option');


            option.value = fee.id;


            option.textContent =
                'Monthly - ₹' +
                Number(fee.amount).toLocaleString('en-IN');


            feeSelect.appendChild(option);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Open Modal
    |--------------------------------------------------------------------------
    */

    modal.classList.remove('hidden');
    modal.classList.add('flex');


    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeAssignModal()
{
    const modal =
        document.getElementById('assignModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Bulk Change Monthly Fee
|--------------------------------------------------------------------------
*/

function openBulkPlanModal()
{
    const modal =
        document.getElementById('bulkPlanModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');


    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeBulkPlanModal()
{
    const modal =
        document.getElementById('bulkPlanModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


/*
|--------------------------------------------------------------------------
| Load Bulk Monthly Fees
|--------------------------------------------------------------------------
*/

function loadBulkPlans()
{
    const libraryId =
        document.getElementById('bulkLibrary').value;

    const planSelect =
        document.getElementById('bulkFeePlan');

    const message =
        document.getElementById('bulkPlanMessage');


    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    */

    planSelect.innerHTML = `
        <option value="">
            Select Monthly Fee
        </option>
    `;

    planSelect.disabled = true;


    /*
    |--------------------------------------------------------------------------
    | No Library
    |--------------------------------------------------------------------------
    */

    if (!libraryId) {

        message.textContent =
            'Select a library to view its monthly fee.';

        message.classList.remove('text-red-500');

        message.classList.add('text-gray-400');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Find Monthly Fees
    |--------------------------------------------------------------------------
    */

    const libraryFees =
        fees.filter(function (fee) {

            return Number(fee.library_id) === Number(libraryId)
                && fee.fees === 'Monthly';

        });


    /*
    |--------------------------------------------------------------------------
    | No Fees
    |--------------------------------------------------------------------------
    */

    if (libraryFees.length === 0) {

        message.textContent =
            'No monthly fee found for this library.';

        message.classList.remove('text-gray-400');

        message.classList.add('text-red-500');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Fees Found
    |--------------------------------------------------------------------------
    */

    message.textContent =
        libraryFees.length +
        ' monthly fee option(s) available.';

    message.classList.remove('text-red-500');

    message.classList.add('text-gray-400');

    planSelect.disabled = false;


    /*
    |--------------------------------------------------------------------------
    | Add Options
    |--------------------------------------------------------------------------
    */

    libraryFees.forEach(function (fee) {

        const option =
            document.createElement('option');


        option.value = fee.id;


        option.textContent =
            'Monthly - ₹' +
            Number(fee.amount).toLocaleString('en-IN');


        planSelect.appendChild(option);

    });
}


/*
|--------------------------------------------------------------------------
| Close Modal On Outside Click
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function ()
{

    const releaseModal =
        document.getElementById('releaseModal');

    const seatModal =
        document.getElementById('seatModal');

    const assignModal =
        document.getElementById('assignModal');

    const bulkPlanModal =
        document.getElementById('bulkPlanModal');


    if (releaseModal) {

        releaseModal.addEventListener('click', function (event) {

            if (event.target === this) {

                closeReleaseModal();

            }

        });

    }


    if (seatModal) {

        seatModal.addEventListener('click', function (event) {

            if (event.target === this) {

                closeSeatModal();

            }

        });

    }


    if (assignModal) {

        assignModal.addEventListener('click', function (event) {

            if (event.target === this) {

                closeAssignModal();

            }

        });

    }


    if (bulkPlanModal) {

        bulkPlanModal.addEventListener('click', function (event) {

            if (event.target === this) {

                closeBulkPlanModal();

            }

        });

    }


    if (typeof lucide !== 'undefined') {

        lucide.createIcons();

    }

});

</script>

@endsection
