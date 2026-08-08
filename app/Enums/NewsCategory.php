<?php

namespace App\Enums;

enum NewsCategory: string
{
    case Trips = 'trips';
    case Releases = 'releases';
    case Charity = 'charity';
    case Concerts = 'concerts';
    case Media = 'media';

    public function label(): string
    {
        return match ($this) {
            self::Trips => 'Поездки',
            self::Releases => 'Релизы',
            self::Charity => 'Благотворительность',
            self::Concerts => 'Концерты',
            self::Media => 'СМИ',
        };
    }
}
