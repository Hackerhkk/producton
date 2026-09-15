<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCycle extends Model
{
    protected $fillable = [
        'student_id',
        'seat_assignment_id',
        'fees_id',
        'period_start',
        'period_end',
        'amount',
        'paid_amount',
        'status',
        'paid_date',
        'wallet_transaction_id',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function seatAssignment()
    {
        return $this->belongsTo(SeatAssignment::class);
    }

    public function fees()
    {
        return $this->belongsTo(Fees::class);
    }

    public function walletTransaction()
    {
        return $this->belongsTo(
            WalletTransaction::class,
            'wallet_transaction_id'
        );
    }
}