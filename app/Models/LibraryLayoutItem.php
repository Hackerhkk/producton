<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryLayoutItem extends Model
{
    protected $fillable = [
        'library_layout_id',
        'type',
        'seat_id',
        'x',
        'y',
        'width',
        'height',
        'rotation',
    ];

    protected $casts = [
        'x' => 'float',
        'y' => 'float',
        'width' => 'float',
        'height' => 'float',
        'rotation' => 'float',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(
            LibraryLayout::class,
            'library_layout_id'
        );
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }
}