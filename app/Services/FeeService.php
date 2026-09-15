<?php

namespace App\Services;

use App\Models\FeeCycle;
use App\Models\StudentWallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class FeeService
{




/*
|--------------------------------------------------------------------------
| Automatic Fee Processing
|--------------------------------------------------------------------------
|
| Cron ki zarurat nahi.
| User/Admin request par automatically due fees check hongi.
|
*/

public function autoProcessDueFees(): int
{
    $lock = Cache::lock('automatic-fee-processing', 30);

    if (!$lock->get()) {
        return 0;
    }

    try {
        return $this->processDueFees();
    } finally {
        $lock->release();
    }
}
    /*
    |--------------------------------------------------------------------------
    | Process Due Fees
    |--------------------------------------------------------------------------
    */

    public function processDueFees(): int
    {
        $processed = 0;

        FeeCycle::with([
            'fees',
            'seatAssignment',
        ])
        ->whereHas('seatAssignment', function ($query) {
            $query->where('status', 'active');
        })
        ->whereIn('status', [
            'pending',
            'partial',
        ])
        ->whereDate(
            'period_start',
            '<=',
            Carbon::today()
        )
        ->chunkById(
            100,
            function ($feeCycles) use (&$processed) {

                foreach ($feeCycles as $feeCycle) {

                    if (!$feeCycle->fees) {
                        continue;
                    }

                    if ($this->collectFee($feeCycle)) {
                        $processed++;
                    }
                }
            }
        );

        return $processed;
    }


    /*
    |--------------------------------------------------------------------------
    | Collect Fee From Wallet
    |--------------------------------------------------------------------------
    */

    public function collectFee(FeeCycle $feeCycle): bool
    {
        return DB::transaction(
            function () use ($feeCycle) {

                /*
                |--------------------------------------------------------------------------
                | Lock Fee Cycle
                |--------------------------------------------------------------------------
                */

                $feeCycle = FeeCycle::with([
                    'fees',
                    'seatAssignment',
                ])
                ->lockForUpdate()
                ->find($feeCycle->id);

                if (!$feeCycle) {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Already Paid
                |--------------------------------------------------------------------------
                */

                if ($feeCycle->status === 'paid') {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Check Assignment
                |--------------------------------------------------------------------------
                */

                $assignment = $feeCycle->seatAssignment;

                if (!$assignment) {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Student Must Still Be Active
                |--------------------------------------------------------------------------
                */

                if ($assignment->status !== 'active') {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Calculate Remaining Amount
                |--------------------------------------------------------------------------
                */

                $remainingAmount =
                    (float) $feeCycle->amount -
                    (float) $feeCycle->paid_amount;

                if ($remainingAmount <= 0) {

                    $feeCycle->update([
                        'status' => 'paid',
                        'paid_date' => Carbon::today(),
                    ]);

                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Get Student Wallet
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
                | Wallet Does Not Exist
                |--------------------------------------------------------------------------
                */

                if (!$wallet) {
                    return false;
                }


                /*
                |--------------------------------------------------------------------------
                | Insufficient Wallet Balance
                |--------------------------------------------------------------------------
                |
                | Fee remains pending.
                | No money is deducted.
                |
                */

                if (
                    (float) $wallet->balance
                    < $remainingAmount
                ) {
                    return false;
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
                    'student_id' =>
                        $feeCycle->student_id,

                    'type' => 'debit',

                    'amount' =>
                        $remainingAmount,

                    'description' =>
                        'Automatic monthly fee payment - ' .
                        $feeCycle->period_start
                            ->format('d M Y') .
                        ' to ' .
                        $feeCycle->period_end
                            ->format('d M Y'),

                    'transaction_date' =>
                        Carbon::today(),

                    'reference_type' =>
                        FeeCycle::class,

                    'reference_id' =>
                        $feeCycle->id,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Mark Current Cycle Paid
                |--------------------------------------------------------------------------
                */

                $feeCycle->update([
                    'paid_amount' =>
                        (float) $feeCycle->paid_amount
                        + $remainingAmount,

                    'status' => 'paid',

                    'paid_date' =>
                        Carbon::today(),

                    'wallet_transaction_id' =>
                        $transaction->id,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Create Next Monthly Cycle
                |--------------------------------------------------------------------------
                */

                $this->createNextCycle(
                    $feeCycle
                );


                return true;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Create Next Monthly Fee Cycle
    |--------------------------------------------------------------------------
    */

    public function createNextCycle(
        FeeCycle $currentCycle
    ): ?FeeCycle {

        /*
        |--------------------------------------------------------------------------
        | Get Active Assignment
        |--------------------------------------------------------------------------
        */

        $assignment = $currentCycle
            ->seatAssignment()
            ->with('fees')
            ->first();

        if (!$assignment) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Student Must Still Have Active Seat
        |--------------------------------------------------------------------------
        */

        if ($assignment->status !== 'active') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Current Fee Plan
        |--------------------------------------------------------------------------
        |
        | New system:
        |
        | SeatAssignment -> fees_id -> Fees
        |
        */

        $feePlan = $assignment->fees;

        if (!$feePlan) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Make Sure It Is Monthly
        |--------------------------------------------------------------------------
        */

        if ($feePlan->fees !== 'Monthly') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Next Monthly Period
        |--------------------------------------------------------------------------
        */

        $periodStart = $currentCycle
            ->period_end
            ->copy()
            ->addDay();

        $periodEnd = $periodStart
            ->copy()
            ->addMonth()
            ->subDay();


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Cycle
        |--------------------------------------------------------------------------
        */

        $alreadyExists = FeeCycle::where(
            'seat_assignment_id',
            $currentCycle->seat_assignment_id
        )
        ->whereDate(
            'period_start',
            $periodStart
        )
        ->whereDate(
            'period_end',
            $periodEnd
        )
        ->exists();

        if ($alreadyExists) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Next Cycle
        |--------------------------------------------------------------------------
        */

        return FeeCycle::create([
            'student_id' =>
                $currentCycle->student_id,

            'seat_assignment_id' =>
                $currentCycle->seat_assignment_id,

            'fees_id' =>
                $feePlan->id,

            'period_start' =>
                $periodStart,

            'period_end' =>
                $periodEnd,

            'amount' =>
                $feePlan->amount,

            'paid_amount' => 0,

            'status' => 'pending',
        ]);
    }
}
