<?php

namespace App\Models;

use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'file_path',
        'fundraising_id',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function fundraising(): BelongsTo
    {
        return $this->belongsTo(Fundraising::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
