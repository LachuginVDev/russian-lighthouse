<?php

namespace App\Enums;

enum AlbumType: string
{
    case Album = 'album';
    case Ep = 'ep';

    public function label(): string
    {
        return match ($this) {
            self::Album => 'Альбом',
            self::Ep => 'EP',
        };
    }
}
