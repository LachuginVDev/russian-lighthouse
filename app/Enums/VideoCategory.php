<?php

namespace App\Enums;

enum VideoCategory: string
{
    case Concerts = 'concerts';
    case Trips = 'trips';
    case Interviews = 'interviews';
    case Backstage = 'backstage';

    public function label(): string
    {
        return match ($this) {
            self::Concerts => 'Концерты',
            self::Trips => 'Поездки',
            self::Interviews => 'Интервью',
            self::Backstage => 'Закулисье',
        };
    }
}
