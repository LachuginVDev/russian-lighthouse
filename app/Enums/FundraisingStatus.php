<?php

namespace App\Enums;

enum FundraisingStatus: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Draft = 'draft';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Открыт',
            self::Closed => 'Закрыт',
            self::Draft => 'Черновик',
        };
    }
}
