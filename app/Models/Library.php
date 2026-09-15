<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable = [
        'name',
        'location'
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}