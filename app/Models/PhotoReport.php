<?php

namespace App\Models;

use App\Enums\PhotoReportCategory;
use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoReport extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'lead',
        'category',
        'cover_path',
        'report_date',
        'is_featured_home',
        'published_at',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'category' => PhotoReportCategory::class,
            'report_date' => 'date',
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->orderBy('position');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
