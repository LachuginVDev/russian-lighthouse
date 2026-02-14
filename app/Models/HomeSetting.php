<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    public const string TEXT_COLOR_WHITE = 'white';

    public const string TEXT_COLOR_BLACK = 'black';

    protected $fillable = ['hero_title', 'hero_subtitle', 'hero_text_color', 'logo'];

    protected $attributes = [
        'hero_text_color' => self::TEXT_COLOR_WHITE,
    ];

    public static function get(): self
    {
        return self::query()->firstOrCreate(
            ['id' => 1],
            ['hero_text_color' => self::TEXT_COLOR_WHITE]
        );
    }
}
