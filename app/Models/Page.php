<?php

namespace App\Models;

use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
