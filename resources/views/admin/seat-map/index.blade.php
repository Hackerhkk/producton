@extends('admin.layouts.app')

@section('title', 'Seat Map')

@section('content')

<div class="min-h-screen bg-[#f7f9fc]">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#2874b9] text-white">
                        <i data-lucide="layout-grid" class="h-5 w-5"></i>
                    </div>

                    <h1 class="text-2xl font-bold text-[#1f2937]">
                        Library Seat Map
                    </h1>
                </div>

                <p class="mt-1 text-sm text-[#667085]">
                    Visual view of the actual library seats.
                </p>
            </div>

            {{-- Library Filter --}}
            <form method="GET" action="{{ route('admin.seat-map.index') }}" class="flex items-center gap-2">

                <select
                    name="library_id"
                    onchange="this.form.submit()"
                    class="cursor-pointer rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-sm text-[#1f2937] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                >
                    <option value="">
                        All Libraries
                    </option>

                    @foreach($libraries as $library)
                        <option
                            value="{{ $library->id }}"
                            @selected((string) $selectedLibraryId === (string) $library->id)
                        >
                            {{ $library->name }}
                        </option>
                    @endforeach
                </select>

            </form>

        </div>

        {{-- Legend --}}
        <div class="mb-5 flex flex-wrap items-center gap-4 rounded-xl border border-[#e4e8ef] bg-white px-4 py-3 shadow-sm">

            <div class="flex items-center gap-2 text-xs font-medium text-[#667085]">
                <span class="h-3 w-3 rounded-full bg-green-500"></span>
                Available
            </div>

            <div class="flex items-center gap-2 text-xs font-medium text-[#667085]">
                <span class="h-3 w-3 rounded-full bg-red-500"></span>
                Occupied
            </div>

        </div>

        @php
            $groupedSeats = $seats->groupBy('library_id');
        @endphp

        {{-- Libraries --}}
        @forelse($groupedSeats as $libraryId => $librarySeats)

            @php
                $library = $librarySeats->first()->library;
                $availableCount = $librarySeats->where('status', 'available')->count();
                $occupiedCount = $librarySeats->where('status', 'occupied')->count();
            @endphp

            <div class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

                {{-- Library Header --}}
                <div class="flex flex-col gap-3 border-b border-[#e4e8ef] px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="building-2" class="h-5 w-5 text-[#2874b9]"></i>

                            <h2 class="text-base font-bold text-[#1f2937]">
                                {{ $library->name }}
                            </h2>
                        </div>

                        @if($library->location)
                            <p class="mt-1 text-xs text-[#667085]">
                                {{ $library->location }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">

                        <span class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                            {{ $availableCount }} Available
                        </span>

                        <span class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">
                            {{ $occupiedCount }} Occupied
                        </span>

                    </div>

                </div>

                {{-- Room --}}
                <div class="p-4 sm:p-6">

                    <div class="relative min-h-[420px] overflow-hidden rounded-2xl border-2 border-[#d0d5dd] bg-[#fafbfc] p-5 sm:p-8">

                        {{-- Room Label --}}
                        <div class="absolute left-1/2 top-4 -translate-x-1/2 rounded-lg border border-[#d0d5dd] bg-white px-5 py-2 shadow-sm">
                            <div class="flex items-center gap-2">
                                <i data-lucide="door-open" class="h-4 w-4 text-[#2874b9]"></i>

                                <span class="text-xs font-bold uppercase tracking-wide text-[#667085]">
                                    Study Room
                                </span>
                            </div>
                        </div>

                        {{-- Seats --}}
                        <div class="flex min-h-[350px] items-center justify-center pt-10">

                            <div class="grid w-full max-w-5xl grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">

                                @foreach($librarySeats as $seat)

                                    @php
                                        $occupied = $seat->status === 'occupied' || $seat->activeAssignment;
                                        $student = $seat->activeAssignment?->student;
                                    @endphp

                                    <div
                                        class="group relative flex cursor-pointer flex-col items-center rounded-xl border p-3 transition hover:-translate-y-1 hover:shadow-md
                                        {{ $occupied
                                            ? 'border-red-200 bg-red-50'
                                            : 'border-green-200 bg-green-50'
                                        }}"
                                        onclick="showSeatDetails(
                                            @js($seat->seat_number),
                                            @js($occupied ? 'Occupied' : 'Available'),
                                            @js($student?->name),
                                            @js($seat->activeAssignment?->fees?->amount)
                                        )"
                                    >

                                        {{-- Seat Icon --}}
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-xl shadow-sm
                                            {{ $occupied
                                                ? 'bg-red-500 text-white'
                                                : 'bg-green-500 text-white'
                                            }}"
                                        >
                                            <i data-lucide="armchair" class="h-7 w-7"></i>
                                        </div>

                                        {{-- Seat Number --}}
                                        <p class="mt-2 text-sm font-bold text-[#1f2937]">
                                            {{ $seat->seat_number }}
                                        </p>

                                        {{-- Status --}}
                                        <span
                                            class="mt-1 text-[10px] font-semibold
                                            {{ $occupied
                                                ? 'text-red-600'
                                                : 'text-green-600'
                                            }}"
                                        >
                                            {{ $occupied ? 'Occupied' : 'Available' }}
                                        </span>

                                        {{-- Student --}}
                                        @if($student)
                                            <p class="mt-1 w-full truncate text-center text-[10px] font-medium text-[#667085]">
                                                {{ $student->name }}
                                            </p>
                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-[#e4e8ef] bg-white px-5 py-16 text-center shadow-sm">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gray-100">
                    <i data-lucide="armchair" class="h-7 w-7 text-gray-400"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-[#1f2937]">
                    No seats found
                </h3>

                <p class="mt-1 text-sm text-[#667085]">
                    Add seats from the existing Seat Management page.
                </p>

            </div>

        @endforelse

    </div>

</div>

{{-- Seat Details Modal --}}
<div
    id="seatModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
>
    <div class="w-full max-w-sm rounded-2xl bg-white p-5 shadow-xl">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                <div
                    id="modalSeatIcon"
                    class="flex h-10 w-10 items-center justify-center rounded-lg"
                >
                    <i data-lucide="armchair" class="h-5 w-5 text-white"></i>
                </div>

                <div>
                    <h3 id="modalSeatNumber" class="text-base font-bold text-[#1f2937]">
                        Seat
                    </h3>

                    <p id="modalStatus" class="text-xs text-[#667085]">
                        Status
                    </p>
                </div>

            </div>

            <button
                type="button"
                onclick="closeSeatDetails()"
                class="cursor-pointer rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
            >
                <i data-lucide="x" class="h-5 w-5"></i>
            </button>

        </div>

        <div class="mt-5 space-y-3">

            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-[11px] font-medium text-gray-500">
                    Student
                </p>

                <p id="modalStudent" class="mt-1 text-sm font-semibold text-[#1f2937]">
                    -
                </p>
            </div>

            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-[11px] font-medium text-gray-500">
                    Monthly Fee
                </p>

                <p id="modalFee" class="mt-1 text-sm font-semibold text-[#1f2937]">
                    -
                </p>
            </div>

        </div>

        <button
            type="button"
            onclick="closeSeatDetails()"
            class="mt-5 w-full cursor-pointer rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#21649f]"
        >
            Close
        </button>

    </div>
</div>

@push('scripts')
<script>
    function showSeatDetails(seatNumber, status, student, fee) {
        const modal = document.getElementById('seatModal');
        const modalIcon = document.getElementById('modalSeatIcon');

        document.getElementById('modalSeatNumber').textContent = 'Seat ' + seatNumber;
        document.getElementById('modalStatus').textContent = status;
        document.getElementById('modalStudent').textContent = student || 'No student assigned';
        document.getElementById('modalFee').textContent = fee
            ? '₹' + Number(fee).toLocaleString('en-IN')
            : '—';

        modalIcon.className =
            'flex h-10 w-10 items-center justify-center rounded-lg ' +
            (status === 'Occupied' ? 'bg-red-500' : 'bg-green-500');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function closeSeatDetails() {
        const modal = document.getElementById('seatModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSeatDetails();
        }
    });

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
</script>
@endpush

@endsection