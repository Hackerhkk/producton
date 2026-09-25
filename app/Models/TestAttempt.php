<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestAttempt extends Model
{
    protected $fillable = [
        'test_id',
        'user_id',
        'question_order',
        'started_at',
        'submitted_at',
        'total_questions',
        'attempted',
        'correct',
        'wrong',
        'skipped',
        'total_marks',
        'obtained_marks',
        'percentage',
        'passed',
        'status',
        'time_taken',
    ];

    protected $casts = [
        'question_order' => 'array',

        'started_at' => 'datetime',

        'submitted_at' => 'datetime',

        'total_questions' => 'integer',

        'attempted' => 'integer',

        'correct' => 'integer',

        'wrong' => 'integer',

        'skipped' => 'integer',

        'total_marks' => 'decimal:2',

        'obtained_marks' => 'decimal:2',

        'percentage' => 'decimal:2',

        'passed' => 'boolean',

        'time_taken' => 'integer',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(TestAnswer::class);
    }
}
