<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShortUrlClick extends Model
{
    protected $fillable = [
        'short_url_id',
        'ip_address',
        'user_agent',
        'device',
        'browser',
        'os',
        'referer',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function shortUrl(): BelongsTo
    {
        return $this->belongsTo(
            ShortUrl::class,
            'short_url_id'
        );
    }
}