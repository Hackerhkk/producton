<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'user_id',
    ];


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Seat Assignments
    |--------------------------------------------------------------------------
    */

    public function seatAssignments(): HasMany
    {
        return $this->hasMany(
            SeatAssignment::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Wallet
    |--------------------------------------------------------------------------
    */

    public function wallet(): HasOne
    {
        return $this->hasOne(
            StudentWallet::class
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Test Attempts
    |--------------------------------------------------------------------------
    */

    public function testAttempts(): HasMany
    {
        return $this->hasMany(
            TestAttempt::class
        );
    }
}
