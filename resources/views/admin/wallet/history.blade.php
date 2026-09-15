@extends('admin.layouts.app')

@section('title', 'Wallet')

@section('content')

<div class="mb-6 flex items-center justify-between">

    <div>
        <h1 class="text-2xl font-bold text-[#111827]">
            Student Wallet
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            {{ $student->name }} wallet & transaction history
        </p>
    </div>

    <a
        href="{{ route('admin.student.index') }}"
        class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">

        <i data-lucide="arrow-left" class="h-4 w-4"></i>

        Back
    </a>

</div>


@if(session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif


@if($errors->any())
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- Wallet Summary --}}
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">

    {{-- Student --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

        <div class="flex items-center gap-3">

            @if($student->student_photo)

                <img
                    src="{{ asset('storage/' . $student->student_photo) }}"
                    alt="{{ $student->name }}"
                    class="h-12 w-12 rounded-xl object-cover border border-gray-200">

            @else

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#e7f1fb] text-lg font-bold text-[#347ec0]">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>

            @endif

            <div class="min-w-0">

                <h2 class="truncate text-base font-bold text-gray-900">
                    {{ $student->name }}
                </h2>

                <p class="text-xs text-gray-500">
                    {{ $student->mobile }}
                </p>

            </div>

        </div>

    </div>


    {{-- Balance --}}
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-xs font-medium text-green-600">
                    Wallet Balance
                </p>

                <h2 class="mt-1 text-2xl font-bold text-green-700">
                    ₹{{ number_format((float) $wallet->balance, 2) }}
                </h2>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-green-600 shadow-sm">
                <i data-lucide="wallet" class="h-5 w-5"></i>
            </div>

        </div>

    </div>


    {{-- Add Money --}}
    <div class="flex items-center justify-between rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

        <div>
            <p class="text-xs text-gray-400">
                Wallet
            </p>

            <p class="mt-1 text-sm font-semibold text-gray-800">
                Add money to wallet
            </p>
        </div>

        <button
            type="button"
            onclick="openWalletModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700">

            <i data-lucide="plus" class="h-4 w-4"></i>

            Add Money
        </button>

    </div>

</div>


{{-- Transactions --}}
<div class="mt-6 rounded-2xl border border-gray-200 bg-white shadow-sm">

    <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

        <div>
            <h2 class="text-base font-semibold text-gray-900">
                Transaction History
            </h2>

            <p class="mt-1 text-xs text-gray-500">
                All wallet deposits and deductions
            </p>
        </div>

        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
            {{ $transactions->total() }} Transactions
        </span>

    </div>


    @if($transactions->count())

        <div class="divide-y divide-gray-100">

            @foreach($transactions as $transaction)

                <div class="flex items-center justify-between gap-4 px-5 py-4">

                    <div class="flex min-w-0 items-center gap-3">

                        @if($transaction->type === 'credit')

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                                <i data-lucide="arrow-down-left" class="h-5 w-5"></i>
                            </div>

                        @else

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                <i data-lucide="arrow-up-right" class="h-5 w-5"></i>
                            </div>

                        @endif


                        <div class="min-w-0">

                            <p class="truncate text-sm font-semibold text-gray-800">
                                {{ $transaction->description ?: 'Wallet Transaction' }}
                            </p>

                            <p class="mt-0.5 text-xs text-gray-400">
                                {{ $transaction->transaction_date->format('d M Y') }}
                            </p>

                        </div>

                    </div>


                    @if($transaction->type === 'credit')

                        <span class="shrink-0 text-sm font-bold text-green-600">
                            +₹{{ number_format((float) $transaction->amount, 2) }}
                        </span>

                    @else

                        <span class="shrink-0 text-sm font-bold text-red-600">
                            -₹{{ number_format((float) $transaction->amount, 2) }}
                        </span>

                    @endif

                </div>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if($transactions->hasPages())

            <div class="border-t border-gray-100 px-5 py-4">

                {{ $transactions->links() }}

            </div>

        @endif

    @else

        <div class="px-5 py-12 text-center">

            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-50 text-gray-400">
                <i data-lucide="wallet-cards" class="h-6 w-6"></i>
            </div>

            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                No Transactions Yet
            </h3>

            <p class="mt-1 text-xs text-gray-500">
                Add money to this student's wallet to create the first transaction.
            </p>

        </div>

    @endif

</div>


{{-- Add Money Modal --}}
<div
    id="walletModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-lg font-semibold text-gray-900">
                    Add Money
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Add money to {{ $student->name }} wallet
                </p>
            </div>

            <button
                type="button"
                onclick="closeWalletModal()"
                class="text-gray-400 hover:text-gray-600">

                <i data-lucide="x"></i>

            </button>

        </div>


        <form
            method="POST"
            action="{{ route('admin.wallet.add-money', $student->id) }}"
            class="mt-6 space-y-4">

            @csrf


            <div>

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Amount
                </label>

                <div class="relative">

                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                        ₹
                    </span>

                    <input
                        type="number"
                        name="amount"
                        min="1"
                        step="0.01"
                        required
                        placeholder="Enter amount"
                        class="w-full rounded-xl border border-gray-300 py-3 pl-8 pr-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20">

                </div>

            </div>


            <div>

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Date
                </label>

                <input
                    type="date"
                    name="transaction_date"
                    value="{{ date('Y-m-d') }}"
                    required
                    class="w-full rounded-xl border border-gray-300 px-3 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20">

            </div>


            <div>

                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Description
                </label>

                <input
                    type="text"
                    name="description"
                    placeholder="Example: Cash Deposit"
                    class="w-full rounded-xl border border-gray-300 px-3 py-3 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-500/20">

            </div>


            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeWalletModal()"
                    class="rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700">
                    Add Money
                </button>

            </div>

        </form>

    </div>

</div>


<script>

function openWalletModal()
{
    const modal = document.getElementById('walletModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}


function closeWalletModal()
{
    const modal = document.getElementById('walletModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


document.getElementById('walletModal').addEventListener('click', function(event) {

    if (event.target === this) {
        closeWalletModal();
    }

});


document.addEventListener('DOMContentLoaded', function () {

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

});

</script>

@endsection