<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'marks',
        'explanation',
        'sort_order',
    ];

    protected $casts = [
        'marks' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(
            Test::class
        );
    }
}
