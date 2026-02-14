<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MediaPlaylist extends Model
{
    protected $fillable = ['title', 'sort_order'];

    public function items(): HasMany
    {
        return $this->hasMany(MediaItem::class)->orderBy('sort_order');
    }
}
