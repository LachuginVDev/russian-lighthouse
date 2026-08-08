<?php

namespace App\Models;

use App\Enums\ConcertBadgeType;
use App\Enums\ConcertStatus;
use App\Models\Concerns\HasPublishState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concert extends Model
{
    use HasPublishState;

    protected $fillable = [
        'slug',
        'title',
        'starts_at',
        'ends_at',
        'venue',
        'city',
        'address',
        'badge_type',
        'status',
        'ticket_status_label',
        'ticket_url',
        'cover_path',
        'body',
        'excerpt',
        'embedded_track_id',
        'fundraising_id',
        'is_featured_home',
        'published_at',
        'sort_order',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'badge_type' => ConcertBadgeType::class,
            'status' => ConcertStatus::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_featured_home' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function embeddedTrack(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'embedded_track_id');
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
