<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'library_id',
        'seat_number',
        'status',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class);
    }

    public function seatAssignments()
    {
        return $this->hasMany(SeatAssignment::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(SeatAssignment::class)
            ->where('status', 'active')
            ->latestOfMany();
    }
}