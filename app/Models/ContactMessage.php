<?php

namespace App\Models;

use App\Enums\ContactMessageStatus;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
        'consent',
        'ip',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
            'status' => ContactMessageStatus::class,
        ];
    }
}
