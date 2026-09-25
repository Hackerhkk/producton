<?php

namespace App\Services;

use App\Models\FeeCycle;
use App\Models\SeatAssignment;
use App\Models\StudentWallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FeeService
{
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

    public function processDueFees(): int
    {
        $processed = 0;

        $this->createMissingCycles();

        FeeCycle::query()
            ->with(['fees', 'seatAssignment'])
            ->whereIn('status', ['pending', 'partial'])
            ->whereDate('period_start', '<=', Carbon::today())
            ->orderBy('period_start')
            ->orderBy('id')
            ->chunkById(100, function ($feeCycles) use (&$processed) {
                foreach ($feeCycles as $feeCycle) {
                    if ($this->collectFee($feeCycle)) {
                        $processed++;
                    }
                }
            });

        return $processed;
    }

    public function createMissingCycles(): int
    {
        $created = 0;

        SeatAssignment::query()
            ->with('fees')
            ->where('status', 'active')
            ->whereDate('assign_date', '<=', Carbon::today())
            ->chunkById(100, function ($assignments) use (&$created) {
                foreach ($assignments as $assignment) {
                    $created += $this->createCyclesForAssignment($assignment);
                }
            });

        return $created;
    }

    public function createCyclesForAssignment(SeatAssignment $assignment): int
    {
        $feePlan = $assignment->fees;

        if (!$feePlan) {
            return 0;
        }

        if (
            isset($feePlan->fees) &&
            strtolower(trim($feePlan->fees)) !== 'monthly'
        ) {
            return 0;
        }

        $assignDate = Carbon::parse($assignment->assign_date)->startOfDay();
        $today = Carbon::today();

        if ($assignDate->greaterThan($today)) {
            return 0;
        }

        $created = 0;

        $latestCycle = FeeCycle::query()
            ->where('seat_assignment_id', $assignment->id)
            ->orderByDesc('period_end')
            ->first();

        /*
         * First cycle:
         * Assignment date -> month end
         * This cycle is prorated.
         */
        if (!$latestCycle) {
            $periodStart = $assignDate->copy()->startOfDay();
            $periodEnd = $assignDate->copy()
                ->endOfMonth()
                ->startOfDay();

            $daysInMonth = $periodStart->daysInMonth;

            $applicableDays = $periodStart->diffInDays($periodEnd) + 1;

            $amount = round(
                ((float) $feePlan->amount / $daysInMonth) * $applicableDays,
                2
            );

            FeeCycle::create([
                'student_id' => $assignment->student_id,
                'seat_assignment_id' => $assignment->id,
                'fees_id' => $feePlan->id,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'amount' => $amount,
                'paid_amount' => 0,
                'status' => 'pending',
            ]);

            $created++;
        }

        $latestCycle = FeeCycle::query()
            ->where('seat_assignment_id', $assignment->id)
            ->orderByDesc('period_end')
            ->first();

        if (!$latestCycle) {
            return $created;
        }

        /*
         * Future months:
         * Every complete month gets full monthly fee.
         */
        $nextStart = Carbon::parse($latestCycle->period_end)
            ->startOfDay()
            ->addDay();

        while ($nextStart->lessThanOrEqualTo($today)) {
            $nextEnd = $nextStart->copy()
                ->endOfMonth()
                ->startOfDay();

            $exists = FeeCycle::query()
                ->where('seat_assignment_id', $assignment->id)
                ->whereDate('period_start', $nextStart->toDateString())
                ->whereDate('period_end', $nextEnd->toDateString())
                ->exists();

            if (!$exists) {
                FeeCycle::create([
                    'student_id' => $assignment->student_id,
                    'seat_assignment_id' => $assignment->id,
                    'fees_id' => $feePlan->id,
                    'period_start' => $nextStart,
                    'period_end' => $nextEnd,
                    'amount' => round((float) $feePlan->amount, 2),
                    'paid_amount' => 0,
                    'status' => 'pending',
                ]);

                $created++;
            }

            $nextStart = $nextEnd->copy()
                ->addDay()
                ->startOfDay();
        }

        return $created;
    }

    /**
     * Apply a new monthly plan from the current calendar month.
     *
     * Previous months are never modified.
     */
    public function changePlanFromCurrentMonth(
        SeatAssignment $assignment,
        $newFeePlan
    ): void {
        DB::transaction(function () use ($assignment, $newFeePlan) {
            $today = Carbon::today();

            $monthStart = $today->copy()
                ->startOfMonth()
                ->startOfDay();

            $monthEnd = $today->copy()
                ->endOfMonth()
                ->startOfDay();

            $currentCycle = FeeCycle::query()
                ->where('seat_assignment_id', $assignment->id)
                ->whereDate('period_start', '>=', $monthStart->toDateString())
                ->whereDate('period_start', '<=', $monthEnd->toDateString())
                ->orderBy('period_start')
                ->first();

            if ($currentCycle) {
                $cycleStart = Carbon::parse($currentCycle->period_start)
                    ->startOfDay();

                /*
                 * If assignment started during current month,
                 * current month remains prorated.
                 */
                if (
                    $cycleStart->year === $today->year &&
                    $cycleStart->month === $today->month &&
                    $cycleStart->day > 1
                ) {
                    $daysInMonth = $cycleStart->daysInMonth;

                    $applicableDays = $cycleStart->diffInDays($monthEnd) + 1;

                    $newAmount = round(
                        ((float) $newFeePlan->amount / $daysInMonth) *
                        $applicableDays,
                        2
                    );
                } else {
                    /*
                     * If current month started on/before 1st,
                     * full monthly amount applies.
                     */
                    $newAmount = round(
                        (float) $newFeePlan->amount,
                        2
                    );
                }

                $paidAmount = round(
                    (float) $currentCycle->paid_amount,
                    2
                );

                /*
                 * If old paid amount is greater than new fee,
                 * refund extra amount into wallet.
                 */
                if ($paidAmount > $newAmount) {
                    $refundAmount = round(
                        $paidAmount - $newAmount,
                        2
                    );

                    $wallet = StudentWallet::firstOrCreate(
                        ['student_id' => $assignment->student_id],
                        ['balance' => 0]
                    );

                    $wallet->increment(
                        'balance',
                        $refundAmount
                    );

                    WalletTransaction::create([
                        'student_id' => $assignment->student_id,
                        'type' => 'credit',
                        'amount' => $refundAmount,
                        'description' => 'Fee plan change adjustment',
                        'transaction_date' => $today,
                        'reference_type' => FeeCycle::class,
                        'reference_id' => $currentCycle->id,
                    ]);

                    $paidAmount = $newAmount;
                }

                $remaining = round(
                    $newAmount - $paidAmount,
                    2
                );

                $currentCycle->update([
                    'fees_id' => $newFeePlan->id,
                    'amount' => $newAmount,
                    'paid_amount' => $paidAmount,
                    'status' => $remaining <= 0
                        ? 'paid'
                        : ($paidAmount > 0 ? 'partial' : 'pending'),
                    'paid_date' => $remaining <= 0
                        ? ($currentCycle->paid_date ?: $today)
                        : null,
                ]);
            } else {
                /*
                 * Current month cycle doesn't exist.
                 * Create full monthly cycle.
                 */
                FeeCycle::create([
                    'student_id' => $assignment->student_id,
                    'seat_assignment_id' => $assignment->id,
                    'fees_id' => $newFeePlan->id,
                    'period_start' => $monthStart,
                    'period_end' => $monthEnd,
                    'amount' => round((float) $newFeePlan->amount, 2),
                    'paid_amount' => 0,
                    'status' => 'pending',
                ]);
            }

            /*
             * Assignment now uses new plan.
             */
            $assignment->update([
                'fees_id' => $newFeePlan->id,
            ]);

            /*
             * Future unpaid cycles use new plan.
             * Previous cycles remain untouched.
             */
            FeeCycle::query()
                ->where('seat_assignment_id', $assignment->id)
                ->whereDate(
                    'period_start',
                    '>',
                    $monthEnd->toDateString()
                )
                ->whereIn('status', ['pending', 'partial'])
                ->update([
                    'fees_id' => $newFeePlan->id,
                    'amount' => round((float) $newFeePlan->amount, 2),
                ]);
        });
    }

    public function collectFee(FeeCycle $feeCycle): bool
    {
        return DB::transaction(function () use ($feeCycle) {
            $feeCycle = FeeCycle::query()
                ->lockForUpdate()
                ->find($feeCycle->id);

            if (!$feeCycle || $feeCycle->status === 'paid') {
                return false;
            }

            $remainingAmount = round(
                (float) $feeCycle->amount -
                (float) $feeCycle->paid_amount,
                2
            );

            if ($remainingAmount <= 0) {
                $feeCycle->update([
                    'status' => 'paid',
                    'paid_date' => Carbon::today(),
                ]);

                return false;
            }

            $wallet = StudentWallet::query()
                ->where('student_id', $feeCycle->student_id)
                ->lockForUpdate()
                ->first();

            if (!$wallet) {
                return false;
            }

            $walletBalance = round(
                (float) $wallet->balance,
                2
            );

            if ($walletBalance <= 0) {
                return false;
            }

            /*
             * FIFO + partial payment:
             * Whatever is available gets applied to oldest due.
             */
            $paymentAmount = round(
                min($walletBalance, $remainingAmount),
                2
            );

            if ($paymentAmount <= 0) {
                return false;
            }

            $wallet->decrement(
                'balance',
                $paymentAmount
            );

            $transaction = WalletTransaction::create([
                'student_id' => $feeCycle->student_id,
                'type' => 'debit',
                'amount' => $paymentAmount,
                'description' => 'Automatic fee payment - ' .
                    $feeCycle->period_start->format('d M Y') .
                    ' to ' .
                    $feeCycle->period_end->format('d M Y'),
                'transaction_date' => Carbon::today(),
                'reference_type' => FeeCycle::class,
                'reference_id' => $feeCycle->id,
            ]);

            $paidAmount = round(
                (float) $feeCycle->paid_amount +
                $paymentAmount,
                2
            );

            $newRemaining = round(
                (float) $feeCycle->amount -
                $paidAmount,
                2
            );

            $feeCycle->update([
                'paid_amount' => $paidAmount,
                'status' => $newRemaining <= 0
                    ? 'paid'
                    : 'partial',
                'paid_date' => $newRemaining <= 0
                    ? Carbon::today()
                    : null,
                'wallet_transaction_id' => $transaction->id,
            ]);

            return true;
        });
    }

    public function autoProcessStudentFees(int $studentId): int
    {
        $processed = 0;

        $assignments = SeatAssignment::query()
            ->with('fees')
            ->where('student_id', $studentId)
            ->where('status', 'active')
            ->get();

        foreach ($assignments as $assignment) {
            $this->createCyclesForAssignment($assignment);
        }

        /*
         * FIFO:
         * Oldest pending/partial cycle gets wallet money first.
         */
        FeeCycle::query()
            ->where('student_id', $studentId)
            ->whereIn('status', ['pending', 'partial'])
            ->whereDate('period_start', '<=', Carbon::today())
            ->orderBy('period_start')
            ->orderBy('id')
            ->get()
            ->each(function ($feeCycle) use (&$processed) {
                if ($this->collectFee($feeCycle)) {
                    $processed++;
                }
            });

        return $processed;
    }
}
