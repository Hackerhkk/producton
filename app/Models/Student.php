<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'father',
        'village',
        'mobile',
        'aadhar_no',
        'biometric_no',
        'student_photo',
        'id_front',
        'id_back',
    ];

    public function seatAssignments()
    {
        return $this->hasMany(SeatAssignment::class);
    }
    public function wallet()
{
    return $this->hasOne(StudentWallet::class);
}
}