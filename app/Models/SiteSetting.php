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
        'stat_years',
        'stat_concerts',
        'stat_trips',
        'default_og_image',
        'card_number',
        'recipient',
        'inn',
        'bank_account',
        'bik',
        'qr_image_path',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
