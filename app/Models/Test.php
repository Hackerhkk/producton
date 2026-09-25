<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    protected $fillable = [
        'test_series_id',
        'name',
        'duration',
        'total_questions',
        'total_marks',
        'passing_marks',
        'negative_marking',
        'negative_marks',
        'starts_at',
        'ends_at',
        'status',
        'is_free',
    ];

    protected $casts = [
        'duration' => 'integer',
        'total_questions' => 'integer',
        'total_marks' => 'decimal:2',
        'passing_marks' => 'decimal:2',
        'negative_marking' => 'boolean',
        'negative_marks' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'status' => 'boolean',
        'is_free' => 'boolean',
    ];

    public function testSeries(): BelongsTo
    {
        return $this->belongsTo(
            TestSeries::class,
            'test_series_id'
        );
    }

    public function questions(): HasMany
    {
        return $this->hasMany(
            Question::class
        )->orderBy('sort_order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(
            TestAttempt::class
        );
    }
}
