<?php

namespace App\Enums;

enum ConcertBadgeType: string
{
    case Charity = 'charity';
    case Trip = 'trip';
    case Acoustic = 'acoustic';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Charity => 'Благотворительный',
            self::Trip => 'Поездка',
            self::Acoustic => 'Акустика',
            self::Other => 'Другое',
        };
    }
}
