<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Fundraising */
class FundraisingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'lead' => $this->lead,
            'status' => $this->status?->value,
            'goal_amount' => $this->goal_amount,
            'current_amount' => $this->current_amount,
            'percent' => $this->percent(),
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
