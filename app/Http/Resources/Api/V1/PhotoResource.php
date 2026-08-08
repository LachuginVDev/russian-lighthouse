<?php

namespace App\Http\Resources\Api\V1;

use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Photo */
class PhotoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'src' => MediaUrl::make($this->image_path),
            'alt' => $this->alt,
            'caption' => $this->caption,
            'position' => $this->position,
        ];
    }
}
