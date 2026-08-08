<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\News */
class NewsResource extends JsonResource
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
            'excerpt' => $this->excerpt,
            'category' => $this->category?->value,
            'body' => $this->when($request->routeIs('api.v1.news.show'), $this->body),
            'cover' => MediaUrl::make($this->cover_path),
            'author_name' => $this->author_name,
            'author_role' => $this->author_role,
            'author_initials' => $this->author_initials,
            'reading_time' => $this->reading_time,
            'published_at' => $this->published_at?->toIso8601String(),
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')),
            'embedded_track' => new TrackResource($this->whenLoaded('embeddedTrack')),
            'url' => route('news.show', $this->slug),
        ];
    }
}
