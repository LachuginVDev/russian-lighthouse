<?php

namespace App\Enums;

enum ConcertStatus: string
{
    case Upcoming = 'upcoming';
    case Past = 'past';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Upcoming => 'Предстоит',
            self::Past => 'Прошедший',
            self::Cancelled => 'Отменён',
        };
    }
}
