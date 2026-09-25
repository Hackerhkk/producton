<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    protected $fillable = [
        'test_attempt_id',
        'question_id',
        'selected_answer',
        'correct_answer',
        'marks',
        'obtained_marks',
        'is_correct',
        'is_attempted',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
        'obtained_marks' => 'decimal:2',
        'is_correct' => 'boolean',
        'is_attempted' => 'boolean',
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(
            TestAttempt::class,
            'test_attempt_id'
        );
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(
            Question::class
        );
    }
}
