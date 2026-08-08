<?php

namespace App\Models;

use App\Enums\VideoCategory;
use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'category',
        'type_label',
        'duration_label',
        'embed_url',
        'thumbnail_path',
        'is_featured_home',
        'published_at',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'category' => VideoCategory::class,
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
