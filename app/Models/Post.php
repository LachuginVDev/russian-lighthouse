<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    public const string STATUS_DRAFT = 'draft';

    public const string STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'body',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'image',
        'images',
        'video_url',
        'video_file',
        'category_id',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'images' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->whereDate('published_at', '<=', now());
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function (Post $post): void {
            if (empty($post->slug) && ! empty($post->title)) {
                $post->slug = Str::slug($post->title, '-', 'ru');
            }
            if ($post->status === self::STATUS_PUBLISHED && $post->published_at === null) {
                $post->published_at = now();
            }
        });
    }
}
