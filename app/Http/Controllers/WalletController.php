<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentWallet;
use App\Models\WalletTransaction;
use App\Models\FeeCycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Add Money
    |--------------------------------------------------------------------------
    */

    public function addMoney(Request $request, Student $student)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        DB::transaction(function () use ($data, $student) {

            $wallet = StudentWallet::firstOrCreate(
                [
                    'student_id' => $student->id,
                ],
                [
                    'balance' => 0,
                ]
            );

            $wallet->increment(
                'balance',
                $data['amount']
            );

            WalletTransaction::create([
                'student_id' => $student->id,
                'type' => 'credit',
                'amount' => $data['amount'],
                'description' => $data['description']
                    ?? 'Wallet Deposit',
                'transaction_date' => $data['transaction_date'],
            ]);
        });

        return back()->with(
            'success',
            '₹' .
            number_format($data['amount'], 2) .
            ' added to wallet successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Debit Fee From Wallet
    |--------------------------------------------------------------------------
    */

    public function debitForFee(FeeCycle $feeCycle)
    {
        /*
        |--------------------------------------------------------------------------
        | Already Paid
        |--------------------------------------------------------------------------
        */

        if ($feeCycle->status === 'paid') {

            return back()->with(
                'error',
                'This fee cycle is already paid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Calculate Remaining Amount
        |--------------------------------------------------------------------------
        */

        $remainingAmount =
            (float) $feeCycle->amount -
            (float) $feeCycle->paid_amount;


        /*
        |--------------------------------------------------------------------------
        | Nothing Remaining
        |--------------------------------------------------------------------------
        */

        if ($remainingAmount <= 0) {

            $feeCycle->update([
                'status' => 'paid',
                'paid_date' => now()->toDateString(),
            ]);

            return back()->with(
                'success',
                'This fee cycle is already fully paid.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Process Payment
        |--------------------------------------------------------------------------
        */

        $result = DB::transaction(function () use (
            $feeCycle,
            $remainingAmount
        ) {

            /*
            |--------------------------------------------------------------------------
            | Get Wallet
            |--------------------------------------------------------------------------
            */

            $wallet = StudentWallet::where(
                'student_id',
                $feeCycle->student_id
            )
            ->lockForUpdate()
            ->first();


            /*
            |--------------------------------------------------------------------------
            | Wallet Not Found
            |--------------------------------------------------------------------------
            */

            if (!$wallet) {

                return [
                    'success' => false,
                    'message' =>
                        'Student wallet not found. Please add money to the wallet first.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Check Balance
            |--------------------------------------------------------------------------
            */

            $walletBalance = (float) $wallet->balance;

            if ($walletBalance < $remainingAmount) {

                return [
                    'success' => false,
                    'message' =>
                        'Insufficient wallet balance. Required ₹' .
                        number_format(
                            $remainingAmount,
                            2
                        ) .
                        ', available ₹' .
                        number_format(
                            $walletBalance,
                            2
                        ) .
                        '. Please add money to the wallet first.',
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Deduct Wallet
            |--------------------------------------------------------------------------
            */

            $wallet->decrement(
                'balance',
                $remainingAmount
            );


            /*
            |--------------------------------------------------------------------------
            | Create Wallet Transaction
            |--------------------------------------------------------------------------
            */

            $transaction = WalletTransaction::create([
                'student_id' => $feeCycle->student_id,

                'type' => 'debit',

                'amount' => $remainingAmount,

                'description' =>
                    'Fee payment - ' .
                    $feeCycle->period_start->format('d M Y') .
                    ' to ' .
                    $feeCycle->period_end->format('d M Y'),

                'transaction_date' =>
                    now()->toDateString(),

                'reference_type' =>
                    FeeCycle::class,

                'reference_id' =>
                    $feeCycle->id,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Mark Fee As Paid
            |--------------------------------------------------------------------------
            */

            $feeCycle->update([
                'paid_amount' =>
                    (float) $feeCycle->paid_amount +
                    $remainingAmount,

                'status' => 'paid',

                'paid_date' =>
                    now()->toDateString(),

                'wallet_transaction_id' =>
                    $transaction->id,
            ]);


            return [
                'success' => true,
                'message' =>
                    'Fee of ₹' .
                    number_format(
                        $remainingAmount,
                        2
                    ) .
                    ' deducted from wallet successfully.',
            ];
        });


        /*
        |--------------------------------------------------------------------------
        | Failed Payment
        |--------------------------------------------------------------------------
        */

        if (!$result['success']) {

            return back()->with(
                'error',
                $result['message']
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Successful Payment
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            $result['message']
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Wallet History
    |--------------------------------------------------------------------------
    */

    public function history(Student $student)
    {
        $wallet = StudentWallet::firstOrCreate(
            [
                'student_id' => $student->id,
            ],
            [
                'balance' => 0,
            ]
        );

        $transactions = WalletTransaction::where(
            'student_id',
            $student->id
        )
        ->latest('transaction_date')
        ->latest('id')
        ->paginate(20);

        return view(
            'admin.wallet.history',
            compact(
                'student',
                'wallet',
                'transactions'
            )
        );
    }
}

