<?php

namespace App\Enums;

enum PhotoReportCategory: string
{
    case Concerts = 'concerts';
    case Trips = 'trips';
    case Hospitals = 'hospitals';
    case Backstage = 'backstage';

    public function label(): string
    {
        return match ($this) {
            self::Concerts => 'Концерты',
            self::Trips => 'Поездки',
            self::Hospitals => 'Госпитали',
            self::Backstage => 'Закулисье',
        };
    }
}
