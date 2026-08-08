<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Album */
class AlbumResource extends JsonResource
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
            'year' => $this->year,
            'type' => $this->type?->value,
            'status' => $this->status?->value,
            'cover' => MediaUrl::make($this->cover_path),
            'excerpt' => $this->excerpt,
            'description' => $this->when($request->routeIs('api.v1.albums.show'), $this->description),
            'genre' => $this->genre,
            'duration_label' => $this->duration_label,
            'vk_url' => $this->vk_url,
            'youtube_music_url' => $this->youtube_music_url,
            'badge_label' => $this->badge_label,
            'published_at' => $this->published_at?->toIso8601String(),
            'tracks' => TrackResource::collection($this->whenLoaded('tracks')),
            'url' => route('albums.show', $this->slug),
        ];
    }
}
