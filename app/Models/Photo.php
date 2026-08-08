<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    protected $fillable = [
        'photo_report_id',
        'image_path',
        'alt',
        'caption',
        'position',
        'is_featured_home',
    ];

    protected function casts(): array
    {
        return [
            'is_featured_home' => 'boolean',
        ];
    }

    public function photoReport(): BelongsTo
    {
        return $this->belongsTo(PhotoReport::class);
    }
}
