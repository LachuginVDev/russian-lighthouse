<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Concert */
class ConcertResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'venue' => $this->venue,
            'city' => $this->city,
            'address' => $this->address,
            'badge_type' => $this->badge_type?->value,
            'status' => $this->status?->value,
            'ticket_status_label' => $this->ticket_status_label,
            'ticket_url' => $this->ticket_url,
            'cover' => MediaUrl::make($this->cover_path),
            'excerpt' => $this->excerpt,
            'body' => $this->when($request->routeIs('api.v1.concerts.show'), $this->body),
            'published_at' => $this->published_at?->toIso8601String(),
            'url' => route('concerts.show', $this->slug),
        ];
    }
}
