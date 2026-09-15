@extends('admin.layouts.app')

@section('title', 'Edit Student')

@section('content')

<div class="mx-auto max-w-4xl">

{{-- Header --}}
<div class="mb-6">

    <a
        href="{{ route('admin.student.index') }}"
        class="mb-4 inline-flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-[#2874b9]">

        <i data-lucide="arrow-left" class="h-4 w-4"></i>

        Back to Students

    </a>

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-[#111827]">
                Edit Student
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Update student personal and document information
            </p>
        </div>

        <div class="hidden rounded-xl bg-blue-50 px-4 py-2 text-sm font-medium text-[#2874b9] sm:block">
            Student #{{ $student->id }}
        </div>

    </div>

</div>


{{-- Success --}}
@if(session('success'))

    <div class="mb-5 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

        <i data-lucide="circle-check" class="h-5 w-5"></i>

        <span>{{ session('success') }}</span>

    </div>

@endif


{{-- Errors --}}
@if($errors->any())

    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

        <div class="mb-2 flex items-center gap-2 font-semibold">

            <i data-lucide="circle-alert" class="h-4 w-4"></i>

            Please fix the following errors:

        </div>

        <ul class="list-disc space-y-1 pl-5">

            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

@endif


{{-- Main Card --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <form
        method="POST"
        action="{{ route('student.update', $student->id) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')


        {{-- Personal Information --}}
        <div class="border-b border-gray-100 p-6">

            <div class="mb-5">

                <div class="flex items-center gap-2">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-[#2874b9]">

                        <i data-lucide="user-round" class="h-4 w-4"></i>

                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-gray-900">
                            Personal Information
                        </h2>

                        <p class="text-xs text-gray-500">
                            Basic student details
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Name --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Student Name
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $student->name) }}"
                        required
                        placeholder="Enter student name"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                </div>


                {{-- Father --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Father Name
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="father"
                        value="{{ old('father', $student->father) }}"
                        required
                        placeholder="Enter father name"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                </div>


                {{-- Village --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Village / Address
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="village"
                        value="{{ old('village', $student->village) }}"
                        required
                        placeholder="Enter village name"
                        class="w-full rounded-xl border border-gray-300 bg-white px-3.5 py-2.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                </div>


                {{-- Mobile --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Mobile Number
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="phone"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                        </i>

                        <input
                            type="text"
                            name="mobile"
                            value="{{ old('mobile', $student->mobile) }}"
                            maxlength="10"
                            inputmode="numeric"
                            required
                            placeholder="10 digit mobile number"
                            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-3.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                    </div>

                </div>


                {{-- Aadhaar --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Aadhaar Number
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="credit-card"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                        </i>

                        <input
                            type="text"
                            name="aadhar_no"
                            value="{{ old('aadhar_no', $student->aadhar_no) }}"
                            maxlength="12"
                            inputmode="numeric"
                            required
                            placeholder="12 digit Aadhaar number"
                            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-3.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                    </div>

                </div>


                {{-- Biometric --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-gray-700">
                        Biometric Number
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="fingerprint"
                            class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400">
                        </i>

                        <input
                            type="text"
                            name="biometric_no"
                            value="{{ old('biometric_no', $student->biometric_no) }}"
                            placeholder="Enter biometric number"
                            class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-3.5 text-sm outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

                    </div>

                </div>

            </div>

        </div>


        {{-- Documents --}}
        <div class="p-6">

            <div class="mb-5">

                <div class="flex items-center gap-2">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50 text-purple-600">

                        <i data-lucide="file-image" class="h-4 w-4"></i>

                    </div>

                    <div>
                        <h2 class="text-base font-semibold text-gray-900">
                            Documents & Photo
                        </h2>

                        <p class="text-xs text-gray-500">
                            Upload new files only if you want to replace existing ones
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">


                {{-- Student Photo --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Student Photo
                    </label>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">

                        @if($student->student_photo)

                            <img
                                src="{{ asset('storage/' . $student->student_photo) }}"
                                alt="Student Photo"
                                class="mb-3 h-28 w-full rounded-lg object-cover">

                            <p class="mb-2 text-xs text-green-600">
                                ✓ Current photo available
                            </p>

                        @else

                            <div class="mb-3 flex h-28 items-center justify-center rounded-lg bg-gray-100 text-gray-400">

                                <i data-lucide="user-round" class="h-10 w-10"></i>

                            </div>

                            <p class="mb-2 text-xs text-gray-500">
                                No photo uploaded
                            </p>

                        @endif

                        <input
                            type="file"
                            name="student_photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-2 file:text-xs file:font-medium file:text-gray-700 file:shadow-sm">

                    </div>

                </div>


                {{-- ID Front --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        ID Proof Front
                    </label>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">

                        @if($student->id_front)

                            <a
                                href="{{ asset('storage/' . $student->id_front) }}"
                                target="_blank"
                                class="mb-3 flex h-28 items-center justify-center overflow-hidden rounded-lg bg-white">

                                <img
                                    src="{{ asset('storage/' . $student->id_front) }}"
                                    alt="ID Front"
                                    class="h-full w-full object-contain">

                            </a>

                            <p class="mb-2 text-xs text-green-600">
                                ✓ Current front available
                            </p>

                        @else

                            <div class="mb-3 flex h-28 items-center justify-center rounded-lg bg-gray-100 text-gray-400">

                                <i data-lucide="image" class="h-10 w-10"></i>

                            </div>

                            <p class="mb-2 text-xs text-gray-500">
                                No front uploaded
                            </p>

                        @endif

                        <input
                            type="file"
                            name="id_front"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-2 file:text-xs file:font-medium file:text-gray-700 file:shadow-sm">

                    </div>

                </div>


                {{-- ID Back --}}
                <div>

                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        ID Proof Back
                    </label>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">

                        @if($student->id_back)

                            <a
                                href="{{ asset('storage/' . $student->id_back) }}"
                                target="_blank"
                                class="mb-3 flex h-28 items-center justify-center overflow-hidden rounded-lg bg-white">

                                <img
                                    src="{{ asset('storage/' . $student->id_back) }}"
                                    alt="ID Back"
                                    class="h-full w-full object-contain">

                            </a>

                            <p class="mb-2 text-xs text-green-600">
                                ✓ Current back available
                            </p>

                        @else

                            <div class="mb-3 flex h-28 items-center justify-center rounded-lg bg-gray-100 text-gray-400">

                                <i data-lucide="image" class="h-10 w-10"></i>

                            </div>

                            <p class="mb-2 text-xs text-gray-500">
                                No back uploaded
                            </p>

                        @endif

                        <input
                            type="file"
                            name="id_back"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-gray-500 file:mr-2 file:rounded-lg file:border-0 file:bg-white file:px-3 file:py-2 file:text-xs file:font-medium file:text-gray-700 file:shadow-sm">

                    </div>

                </div>

            </div>

        </div>


        {{-- Footer Buttons --}}
        <div class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.student.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

                <i data-lucide="x" class="h-4 w-4"></i>

                Cancel

            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#2167a7]">

                <i data-lucide="save" class="h-4 w-4"></i>

                Update Student

            </button>

        </div>

    </form>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});

</script>

@endsection
