<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $fillable = [
        'library_id',
        'fees',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];


    public function library()
    {
        return $this->belongsTo(
            Library::class
        );
    }


    public function seatAssignments()
    {
        return $this->hasMany(
            SeatAssignment::class
        );
    }


    public function feeCycles()
    {
        return $this->hasMany(
            FeeCycle::class,
            'fees_id'
        );
    }
}
