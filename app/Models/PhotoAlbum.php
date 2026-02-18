<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PhotoAlbum extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'cover_image',
        'sort_order',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(AlbumPhoto::class)->orderBy('sort_order');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function (PhotoAlbum $album): void {
            if (empty($album->slug) && ! empty($album->title)) {
                $album->slug = Str::slug($album->title, '-', 'ru');
            }
        });
    }
}
