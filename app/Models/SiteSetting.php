<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'address',
        'vk_url',
        'telegram_url',
        'youtube_url',
        'hero_eyebrow',
        'hero_title',
        'hero_subtitle',
        'about_eyebrow',
        'about_title',
        'about_lead',
        'about_body',
        'about_image_path',
        'stat_years',
        'stat_concerts',
        'stat_trips',
        'default_og_image',
        'is_development_mode',
        'card_number',
        'recipient',
        'inn',
        'bank_account',
        'bik',
        'qr_image_path',
    ];

    protected function casts(): array
    {
        return [
            'is_development_mode' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return once(fn () => static::query()->firstOrCreate([]));
    }
}
