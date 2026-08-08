<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\PhotoReport */
class PhotoReportResource extends JsonResource
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
            'lead' => $this->when($request->routeIs('api.v1.photo-reports.show'), $this->lead),
            'category' => $this->category?->value,
            'cover' => MediaUrl::make($this->cover_path),
            'report_date' => $this->report_date?->toDateString(),
            'published_at' => $this->published_at?->toIso8601String(),
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
            'url' => route('photos.show', $this->slug),
        ];
    }
}
