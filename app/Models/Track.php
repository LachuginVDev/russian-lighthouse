<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Track extends Model
{
    protected $fillable = [
        'album_id',
        'title',
        'artist',
        'duration',
        'audio_path',
        'cover_path',
        'position',
        'is_featured_home',
    ];

    protected function casts(): array
    {
        return [
            'is_featured_home' => 'boolean',
        ];
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }
}
