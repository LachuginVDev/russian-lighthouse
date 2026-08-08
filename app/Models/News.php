<?php

namespace App\Models;

use App\Enums\NewsCategory;
use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    use HasPublishState;

    protected $table = 'news';

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'category',
        'body',
        'cover_path',
        'author_name',
        'author_role',
        'author_initials',
        'reading_time',
        'embedded_track_id',
        'is_featured_home',
        'published_at',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'category' => NewsCategory::class,
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function embeddedTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'embedded_track_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
