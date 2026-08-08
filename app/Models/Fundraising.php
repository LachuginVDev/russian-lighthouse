<?php

namespace App\Models;

use App\Enums\FundraisingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fundraising extends Model
{
    protected $fillable = [
        'title',
        'lead',
        'status',
        'goal_amount',
        'current_amount',
        'is_featured_home',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => FundraisingStatus::class,
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function percent(): int
    {
        if ($this->goal_amount <= 0) {
            return 0;
        }

        return (int) min(100, round(($this->current_amount / $this->goal_amount) * 100));
    }
}
