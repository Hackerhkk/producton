@extends('admin.layouts.app')

@section('title', 'Student Fees')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Student Fees
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ $student->name }} fee history
        </p>
    </div>

    <a
        href="{{ route('admin.student.index')}}"
        class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">

        <i data-lucide="arrow-left" class="h-4 w-4"></i>

        Back
    </a>
</div>


{{-- Student Summary --}}
<div class="mb-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

    <div class="flex items-center gap-4">

        @if($student->student_photo)

            <img
                src="{{ asset('storage/' . $student->student_photo) }}"
                class="h-14 w-14 rounded-xl border border-gray-200 object-cover"
                alt="{{ $student->name }}">

        @else

            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-50 text-xl font-bold text-blue-600">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>

        @endif


        <div>

            <h2 class="text-lg font-bold text-gray-900">
                {{ $student->name }}
            </h2>

            <p class="text-sm text-gray-500">
                {{ $student->mobile }}
            </p>

        </div>

    </div>

</div>


@if(session('success'))

    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>

@endif


@if($errors->any())

    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

        @foreach($errors->all() as $error)

            <div>{{ $error }}</div>

        @endforeach

    </div>

@endif


{{-- Fee Cycles --}}
<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="border-b border-gray-100 px-5 py-4">

        <h2 class="text-base font-semibold text-gray-900">
            Fee History
        </h2>

        <p class="mt-1 text-xs text-gray-500">
            All generated fee cycles
        </p>

    </div>


    @if($feeCycles->count())

        <div class="divide-y divide-gray-100">

            @foreach($feeCycles as $cycle)

                @php
                    $remaining = (float) $cycle->amount - (float) $cycle->paid_amount;
                @endphp

                <div class="p-5">

                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                        {{-- Left --}}
                        <div>

                            <div class="flex items-center gap-2">

                                <h3 class="text-sm font-semibold text-gray-900">
                                    {{ $cycle->fees->fees ?? 'Fee' }}
                                </h3>


                                @if($cycle->status === 'paid')

                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Paid
                                    </span>

                                @elseif($cycle->status === 'partial')

                                    <span class="rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700">
                                        Partial
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700">
                                        Pending
                                    </span>

                                @endif

                            </div>


                            <p class="mt-1 text-xs text-gray-500">

                                {{ $cycle->period_start->format('d M Y') }}

                                -

                                {{ $cycle->period_end->format('d M Y') }}

                            </p>

                        </div>


                        {{-- Amounts --}}
                        <div class="grid grid-cols-3 gap-5 text-right">

                            <div>

                                <p class="text-[11px] text-gray-400">
                                    Fee
                                </p>

                                <p class="text-sm font-semibold text-gray-900">
                                    ₹{{ number_format((float) $cycle->amount, 2) }}
                                </p>

                            </div>


                            <div>

                                <p class="text-[11px] text-gray-400">
                                    Paid
                                </p>

                                <p class="text-sm font-semibold text-green-600">
                                    ₹{{ number_format((float) $cycle->paid_amount, 2) }}
                                </p>

                            </div>


                            <div>

                                <p class="text-[11px] text-gray-400">
                                    Due
                                </p>

                                <p class="text-sm font-semibold text-red-600">
                                    ₹{{ number_format($remaining, 2) }}
                                </p>

                            </div>

                        </div>


                        {{-- Pay --}}
                        @if($cycle->status !== 'paid')

                            <form
                                method="POST"
                                action="{{ route('admin.fee-cycle.debit', $cycle->id) }}">

                                @csrf

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">

                                    <i data-lucide="wallet" class="h-4 w-4"></i>

                                    Pay Fee

                                </button>

                            </form>

                        @else

                            <div class="flex items-center gap-2 text-sm font-medium text-green-600">

                                <i data-lucide="circle-check" class="h-5 w-5"></i>

                                Paid

                            </div>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>


        @if($feeCycles->hasPages())

            <div class="border-t border-gray-100 px-5 py-4">

                {{ $feeCycles->links() }}

            </div>

        @endif

    @else

        <div class="px-5 py-12 text-center">

            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-50 text-gray-400">

                <i data-lucide="receipt" class="h-6 w-6"></i>

            </div>

            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                No Fee Cycles
            </h3>

            <p class="mt-1 text-xs text-gray-500">
                Fee cycle will appear after assigning a student to a seat.
            </p>

        </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});
</script>

@endsection