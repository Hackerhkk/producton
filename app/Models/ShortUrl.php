<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShortUrl extends Model
{
    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'clicks',
        'status',
        'starts_at',
        'expires_at',
        'click_limit',
        'password',
        'qr_enabled',
    ];

    protected $casts = [
        'status' => 'boolean',
        'clicks' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'click_limit' => 'integer',
        'qr_enabled' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(
            ShortUrlClick::class,
            'short_url_id'
        );
    }
}
