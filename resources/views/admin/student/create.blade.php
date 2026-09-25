@extends('admin.layouts.app')

@section('title', 'Add Student')

@section('content')

<div class="min-h-screen w-full pb-10">
    <div class="mx-auto w-full max-w-6xl">

    {{-- ================= HEADER ================= --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">
            <a
                href="{{ route('admin.student.index') }}"
                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-xl border border-[#e4e8ef] bg-white text-[#667085] transition hover:bg-gray-50 hover:text-[#2874b9]"
                title="Back"
            >
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
            </a>

            <div>
                <h1 class="text-xl font-bold text-[#111827] sm:text-2xl">
                    Add Student
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Add a new student to the library.
                </p>
            </div>
        </div>

        <a
            href="{{ route('admin.student.index') }}"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-gray-50"
        >
            <i data-lucide="users" class="h-4 w-4"></i>
            Students
        </a>

    </div>

    {{-- ================= VALIDATION ERRORS ================= --}}
    @if($errors->any())
        <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex gap-3">

                <i
                    data-lucide="circle-alert"
                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                ></i>

                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Please fix the following errors
                    </h3>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif

    {{-- ================= FORM CARD ================= --}}
    <div class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

        {{-- Card Header --}}
        <div class="border-b border-[#e4e8ef] px-5 py-4 sm:px-6">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#2874b9]/10 text-[#2874b9]">
                    <i data-lucide="user-plus" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-base font-bold text-[#1f2937]">
                        Student Information
                    </h2>

                    <p class="text-xs text-[#667085]">
                        Enter the student's personal and identification details.
                    </p>
                </div>

            </div>

        </div>

        {{-- Form --}}
        <form
            id="studentForm"
            method="POST"
            action="{{ route('student.store') }}"
            enctype="multipart/form-data"
            class="p-5 sm:p-6"
        >

            @csrf

            {{-- ================= BASIC INFORMATION ================= --}}
            <div class="mb-7">

                <div class="mb-4 flex items-center gap-2">
                    <i
                        data-lucide="user-round"
                        class="h-4 w-4 text-[#2874b9]"
                    ></i>

                    <h3 class="text-sm font-bold text-[#1f2937]">
                        Basic Information
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    {{-- Student Name --}}
                    <div>
                        <label
                            for="name"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Student Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            placeholder="Enter student name"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    {{-- Father's Name --}}
                    <div>
                        <label
                            for="father"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Father's Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="father"
                            type="text"
                            name="father"
                            value="{{ old('father') }}"
                            required
                            placeholder="Enter father's name"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    {{-- Village --}}
                    <div>
                        <label
                            for="village"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Village / Address
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="village"
                            type="text"
                            name="village"
                            value="{{ old('village') }}"
                            required
                            placeholder="Enter village or address"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    {{-- Mobile --}}
                    <div>
                        <label
                            for="mobile"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Mobile Number
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="mobile"
                            type="tel"
                            name="mobile"
                            value="{{ old('mobile') }}"
                            required
                            inputmode="numeric"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            placeholder="10 digit mobile number"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >
                    </div>

                    {{-- Aadhaar --}}
                    <div>

                        <label
                            for="aadharInput"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Aadhaar Number
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">

                            <input
                                id="aadharInput"
                                type="text"
                                name="aadhar_no"
                                value="{{ old('aadhar_no') }}"
                                required
                                inputmode="numeric"
                                maxlength="12"
                                autocomplete="off"
                                placeholder="12 digit Aadhaar number"
                                class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 pr-11 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                            <div
                                id="aadharIcon"
                                class="absolute right-3 top-1/2 hidden -translate-y-1/2"
                            ></div>

                        </div>

                        <p
                            id="aadharMessage"
                            class="mt-1.5 hidden text-xs"
                        ></p>

                    </div>

                    {{-- Biometric --}}
                    <div>

                        <label
                            for="biometric_no"
                            class="mb-1.5 block text-sm font-semibold text-[#344054]"
                        >
                            Biometric Number

                            <span class="text-xs font-normal text-[#98a2b3]">
                                (Optional)
                            </span>
                        </label>

                        <input
                            id="biometric_no"
                            type="text"
                            name="biometric_no"
                            value="{{ old('biometric_no') }}"
                            placeholder="Enter biometric number"
                            class="w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>

                </div>
            </div>

            {{-- ================= DOCUMENTS ================= --}}
            <div>

                <div class="mb-4 flex items-center gap-2">

                    <i
                        data-lucide="file-image"
                        class="h-4 w-4 text-[#2874b9]"
                    ></i>

                    <h3 class="text-sm font-bold text-[#1f2937]">
                        Documents & Photo
                    </h3>

                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                    {{-- Student Photo --}}
                    <div class="rounded-xl border border-dashed border-[#d0d5dd] bg-[#f9fafb] p-4">

                        <label
                            for="student_photo"
                            class="mb-2 block text-sm font-semibold text-[#344054]"
                        >
                            Student Photo
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="student_photo"
                            type="file"
                            name="student_photo"
                            capture="environment"
                            required
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white text-sm text-[#667085] file:mr-3 file:cursor-pointer file:border-0 file:bg-[#2874b9]/10 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#2874b9]"
                        >

                        <p class="mt-2 text-xs text-[#98a2b3]">
                            JPG, PNG or WEBP · Max 2MB
                        </p>

                    </div>

                    {{-- ID Front --}}
                    <div class="rounded-xl border border-dashed border-[#d0d5dd] bg-[#f9fafb] p-4">

                        <label
                            for="id_front"
                            class="mb-2 block text-sm font-semibold text-[#344054]"
                        >
                            ID Proof Front
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="id_front"
                            type="file"
                            name="id_front"
                            capture="environment"
                            required
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white text-sm text-[#667085] file:mr-3 file:cursor-pointer file:border-0 file:bg-[#2874b9]/10 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#2874b9]"
                        >

                        <p class="mt-2 text-xs text-[#98a2b3]">
                            JPG, PNG or WEBP · Max 2MB
                        </p>

                    </div>

                    {{-- ID Back --}}
                    <div class="rounded-xl border border-dashed border-[#d0d5dd] bg-[#f9fafb] p-4">

                        <label
                            for="id_back"
                            class="mb-2 block text-sm font-semibold text-[#344054]"
                        >
                            ID Proof Back
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="id_back"
                            type="file"
                            name="id_back"
                            capture="environment"
                            required
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full cursor-pointer rounded-lg border border-[#d0d5dd] bg-white text-sm text-[#667085] file:mr-3 file:cursor-pointer file:border-0 file:bg-[#2874b9]/10 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#2874b9]"
                        >

                        <p class="mt-2 text-xs text-[#98a2b3]">
                            JPG, PNG or WEBP · Max 2MB
                        </p>

                    </div>

                </div>
            </div>

            {{-- ================= ACTIONS ================= --}}
            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-[#e4e8ef] pt-5 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('admin.student.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-5 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-gray-50"
                >
                    Cancel
                </a>

                <button
                    id="saveStudentButton"
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2167a7] disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <i data-lucide="user-plus" class="h-4 w-4"></i>
                    Save Student
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.lucide) {
        lucide.createIcons();
    }

    const form = document.getElementById('studentForm');
    const aadharInput = document.getElementById('aadharInput');
    const aadharIcon = document.getElementById('aadharIcon');
    const aadharMessage = document.getElementById('aadharMessage');
    const saveButton = document.getElementById('saveStudentButton');
    const mobileInput = document.getElementById('mobile');

    let aadharExists = false;
    let aadharChecking = false;
    let checkedAadhar = '';
    let aadharTimer = null;
    let requestNumber = 0;

    function updateSaveButton() {

        if (!saveButton) {
            return;
        }

        saveButton.disabled =
            aadharChecking ||
            aadharExists ||
            checkedAadhar !== getAadhar();

    }

    function getAadhar() {

        return aadharInput
            ? aadharInput.value.replace(/\D/g, '').slice(0, 12)
            : '';
    }

    function showAadharState(type, message = '') {

        if (!aadharIcon || !aadharMessage) {
            return;
        }

        aadharIcon.innerHTML = '';

        aadharIcon.classList.remove(
            'hidden',
            'text-red-600',
            'text-green-600',
            'text-gray-400'
        );

        aadharMessage.classList.add('hidden');

        aadharMessage.classList.remove(
            'text-red-600',
            'text-green-600',
            'text-gray-500'
        );

        if (type === 'checking') {

            aadharIcon.classList.add('text-gray-400');

            aadharIcon.innerHTML = `
                <i
                    data-lucide="loader-circle"
                    class="h-4 w-4 animate-spin"
                ></i>
            `;

            aadharMessage.textContent = 'Checking Aadhaar...';
            aadharMessage.classList.remove('hidden');
            aadharMessage.classList.add('text-gray-500');
        }

        if (type === 'available') {

            aadharIcon.classList.add('text-green-600');

            aadharIcon.innerHTML = `
                <i
                    data-lucide="circle-check"
                    class="h-4 w-4"
                ></i>
            `;

            aadharMessage.textContent =
                'Aadhaar number is available.';

            aadharMessage.classList.remove('hidden');
            aadharMessage.classList.add('text-green-600');
        }

        if (type === 'exists') {

            aadharIcon.classList.add('text-red-600');

            aadharIcon.innerHTML = `
                <i
                    data-lucide="circle-x"
                    class="h-4 w-4"
                ></i>
            `;

            aadharMessage.textContent =
                message || 'This Aadhaar number is already registered.';

            aadharMessage.classList.remove('hidden');
            aadharMessage.classList.add('text-red-600');
        }

        if (type === 'clear') {

            aadharIcon.classList.add('hidden');
            aadharMessage.classList.add('hidden');
        }

        if (window.lucide) {
            lucide.createIcons();
        }
    }

    async function checkAadhar() {

        const aadhar = getAadhar();

        if (aadhar.length !== 12) {
            return;
        }

        const currentRequest = ++requestNumber;

        aadharChecking = true;
        aadharExists = false;
        checkedAadhar = '';

        showAadharState('checking');
        updateSaveButton();

        try {

            const url =
                "{{ route('student.check-aadhar') }}" +
                '?aadhar_no=' +
                encodeURIComponent(aadhar);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error('Aadhaar request failed.');
            }

            const data = await response.json();

            /*
             * Agar is request ke baad user ne Aadhaar change
             * kar diya ho to purana response ignore hoga.
             */
            if (currentRequest !== requestNumber) {
                return;
            }

            if (getAadhar() !== aadhar) {
                return;
            }

            aadharChecking = false;
            aadharExists = Boolean(data.exists);
            checkedAadhar = aadhar;

            if (aadharExists) {

                showAadharState(
                    'exists',
                    'This Aadhaar number is already registered.'
                );

            } else {

                showAadharState('available');
            }

        } catch (error) {

            if (currentRequest !== requestNumber) {
                return;
            }

            aadharChecking = false;
            aadharExists = false;
            checkedAadhar = '';

            showAadharState(
                'exists',
                'Unable to check Aadhaar. Please try again.'
            );
        }

        updateSaveButton();
    }

    /*
     * ==========================================
     * LIVE AADHAAR CHECK
     * ==========================================
     *
     * User 12th digit type karega.
     * 300ms baad automatic AJAX request jayegi.
     */

    if (aadharInput) {

        aadharInput.addEventListener('input', function () {

            const value = this.value
                .replace(/\D/g, '')
                .slice(0, 12);

            this.value = value;

            clearTimeout(aadharTimer);

            requestNumber++;

            aadharExists = false;
            aadharChecking = false;
            checkedAadhar = '';

            /*
             * 12 digits se kam hai
             */
            if (value.length < 12) {

                showAadharState('clear');
                updateSaveButton();

                return;
            }

            /*
             * 12th digit complete hote hi
             * 300ms baad check
             */
            showAadharState('checking');

            aadharTimer = setTimeout(function () {
                checkAadhar();
            }, 300);

            updateSaveButton();
        });
    }

    /*
     * ==========================================
     * FORM SUBMIT
     * ==========================================
     */

    if (form) {

        form.addEventListener('submit', function (event) {

            const aadhar = getAadhar();

            /*
             * Aadhaar 12 digit nahi hai
             */
            if (aadhar.length !== 12) {

                event.preventDefault();

                showAadharState(
                    'exists',
                    'Aadhaar number must contain exactly 12 digits.'
                );

                aadharInput.focus();

                return;
            }

            /*
             * Check abhi chal raha hai
             */
            if (aadharChecking) {

                event.preventDefault();

                aadharInput.focus();

                return;
            }

            /*
             * Duplicate Aadhaar
             */
            if (aadharExists) {

                event.preventDefault();

                aadharInput.focus();

                return;
            }

            /*
             * Aadhaar check complete nahi hua
             */
            if (checkedAadhar !== aadhar) {

                event.preventDefault();

                showAadharState(
                    'checking'
                );

                checkAadhar();

                return;
            }

            /*
             * Aadhaar OK
             * Form submit hone do.
             */

            saveButton.disabled = true;

            saveButton.innerHTML = `
                <i
                    data-lucide="loader-circle"
                    class="h-4 w-4 animate-spin"
                ></i>
                Saving...
            `;

            if (window.lucide) {
                lucide.createIcons();
            }
        });
    }

    /*
     * ==========================================
     * MOBILE NUMBER
     * ==========================================
     */

    if (mobileInput) {

        mobileInput.addEventListener('input', function () {

            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 10);
        });
    }

});
</script>

@endpush
