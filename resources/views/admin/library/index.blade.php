@extends('admin.layouts.app')

@section('title', 'Libraries')

@section('content')

{{-- Header --}}

<div class="mb-6 flex items-center justify-between">

<div>
    <h1 class="text-2xl font-bold text-[#111827]">
        {{ $libraries->count() }} - Libraries
    </h1>

    <p class="mt-1 text-sm text-gray-500">
        Manage all libraries
    </p>
</div>

<button
    type="button"
    onclick="openLibraryModal()"
    class="rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2167a7]">

    Add Library

</button>

</div>

{{-- Success Message --}}
@if(session('success'))

<div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
    {{ session('success') }}
</div>

@endif

{{-- Error Message --}}
@if(session('error'))

<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
    {{ session('error') }}
</div>

@endif

{{-- Validation Errors --}}
@if($errors->any())

<div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

    <ul class="list-disc pl-5">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

{{-- Library Cards --}}

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

@forelse($libraries as $library)

    <div
        class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

        {{-- Card Top --}}
        <div class="flex items-start justify-between">

            {{-- Library Icon --}}
            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e7f1fb] text-[#347ec0]">

                <i
                    data-lucide="library"
                    class="h-5 w-5">
                </i>

            </div>


            {{-- Actions --}}
            <div class="flex items-center gap-1">



                {{-- Delete --}}
                <form
                    action="{{ route('admin.library.destroy', $library->id) }}"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this library?');">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        title="Delete"
                        class=" cursor-pointer flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition bg-red-50 text-red-600"  >

                        <i
                            data-lucide="trash-2"
                            class="h-4 w-4">
                        </i>

                    </button>

                </form>

            </div>

        </div>


        {{-- Library Name --}}
        <div class="mt-5">

            <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                Library #{{ $library->id }}
            </p>

            <h2 class="mt-1 truncate text-lg font-semibold text-gray-900">
                {{ $library->name }}
            </h2>

        </div>


        {{-- Location --}}
        <div class="mt-5 rounded-xl bg-gray-50 px-4 py-3">

            <p class="text-xs font-medium text-gray-500">
                Location
            </p>

            <div class="mt-1 flex items-center gap-2">

                <i
                    data-lucide="map-pin"
                    class="h-4 w-4 text-[#2874b9]">
                </i>

                <p class="truncate text-sm font-medium text-gray-700">
                    {{ $library->location }}
                </p>

            </div>

        </div>

    </div>


@empty

    {{-- Empty State --}}
    <div
        class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">

        <div
            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-gray-400">

            <i
                data-lucide="library"
                class="h-6 w-6">
            </i>

        </div>

        <h3 class="mt-4 text-base font-semibold text-gray-900">
            No libraries found
        </h3>

        <p class="mt-1 text-sm text-gray-500">
            Add your first library to get started.
        </p>

    </div>

@endforelse

</div>

{{-- ========================================================= --}}
{{-- ADD LIBRARY MODAL --}}
{{-- ========================================================= --}}

<div
    id="libraryModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 p-4">

{{-- Modal Box --}}
<div
    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">

    {{-- Modal Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h2 class="text-xl font-semibold text-gray-900">
                Add Library
            </h2>

            <p class="mt-1 text-xs text-gray-500">
                Create a new library
            </p>

        </div>


        {{-- Close --}}
        <button
            type="button"
            onclick="closeLibraryModal()"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700">

            <i
                data-lucide="x"
                class="h-4 w-4">
            </i>

        </button>

    </div>


    {{-- Form --}}
    <form
        method="POST"
        action="{{ route('admin.library.store') }}"
        class="mt-6 space-y-4">

        @csrf


        {{-- Library Name --}}
        <div>

            <label class="mb-1.5 block text-sm font-medium text-gray-700">

                Library Name

                <span class="text-red-500">*</span>

            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="e.g. Main Library"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Location --}}
        <div>

            <label class="mb-1.5 block text-sm font-medium text-gray-700">

                Location

                <span class="text-red-500">*</span>

            </label>

            <input
                type="text"
                name="location"
                value="{{ old('location') }}"
                placeholder="e.g. Jaipur"
                required
                class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm text-gray-800 outline-none transition placeholder:text-gray-400 focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20">

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3 pt-3">

            <button
                type="button"
                onclick="closeLibraryModal()"
                class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">

                Cancel

            </button>

            <button
                type="submit"
                class="rounded-lg bg-[#2874b9] px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-[#2167a7]">

                Save

            </button>

        </div>

    </form>

</div>

</div>

{{-- ========================================================= --}}
{{-- MODAL JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

function openLibraryModal()
{
    const modal = document.getElementById('libraryModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeLibraryModal()
{
    const modal = document.getElementById('libraryModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


document.addEventListener('DOMContentLoaded', function ()
{
    const modal = document.getElementById('libraryModal');

    if (modal) {

        modal.addEventListener('click', function (event)
        {
            if (event.target === modal) {
                closeLibraryModal();
            }
        });

    }


    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});

</script>

@endsection
