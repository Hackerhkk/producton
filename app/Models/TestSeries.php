<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSeries extends Model
{
    protected $fillable = [
        'name',
        'description',
        'subject',
        'status',
        'is_free',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_free' => 'boolean',
    ];

    public function tests(): HasMany
    {
        return $this->hasMany(
            Test::class
        );
    }
}
