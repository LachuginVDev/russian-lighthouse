<?php

namespace App\Models;

use App\Enums\AlbumStatus;
use App\Enums\AlbumType;
use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'year',
        'type',
        'status',
        'cover_path',
        'excerpt',
        'description',
        'genre',
        'duration_label',
        'vk_url',
        'youtube_music_url',
        'badge_label',
        'is_featured_home',
        'published_at',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'type' => AlbumType::class,
            'status' => AlbumStatus::class,
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('status', '!=', AlbumStatus::Draft);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class)->orderBy('position');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
