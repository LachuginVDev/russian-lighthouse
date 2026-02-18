<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Fundraiser extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'goal',
        'raised',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'goal' => 'decimal:2',
            'raised' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class)->orderByDesc('donated_at');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function (Fundraiser $f): void {
            if (empty($f->slug) && ! empty($f->title)) {
                $f->slug = Str::slug($f->title, '-', 'ru');
            }
        });
    }
}
