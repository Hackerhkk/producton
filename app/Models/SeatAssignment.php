<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatAssignment extends Model
{
    protected $fillable = [
        'seat_id',
        'student_id',
        'fees_id',
        'assign_date',
        'status',
    ];

    protected $casts = [
        'assign_date' => 'date',
    ];

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fees()
    {
        return $this->belongsTo(Fees::class);
    }
}

