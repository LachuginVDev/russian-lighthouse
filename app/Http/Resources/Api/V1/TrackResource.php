<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Track */
class TrackResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'duration' => $this->duration,
            'src' => MediaUrl::make($this->audio_path),
            'cover' => MediaUrl::make($this->cover_path),
            'position' => $this->position,
            'album_title' => $this->whenLoaded('album', fn () => $this->album?->title),
        ];
    }
}
