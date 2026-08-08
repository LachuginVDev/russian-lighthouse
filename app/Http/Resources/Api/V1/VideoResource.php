<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Video */
class VideoResource extends JsonResource
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
            'category' => $this->category?->value,
            'type_label' => $this->type_label,
            'duration_label' => $this->duration_label,
            'embed_url' => $this->embed_url,
            'thumbnail' => MediaUrl::make($this->thumbnail_path),
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
