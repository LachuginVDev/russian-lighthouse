<?php

namespace App\Enums;

enum AlbumStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case ComingSoon = 'coming_soon';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Черновик',
            self::Published => 'Опубликован',
            self::ComingSoon => 'Скоро',
        };
    }
}
