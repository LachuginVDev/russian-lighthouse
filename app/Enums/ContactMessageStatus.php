<?php

namespace App\Enums;

enum ContactMessageStatus: string
{
    case New = 'new';
    case Read = 'read';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новое',
            self::Read => 'Прочитано',
            self::Archived => 'В архиве',
        };
    }
}
