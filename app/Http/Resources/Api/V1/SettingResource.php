<?php

namespace App\Http\Resources\Api\V1;

use App\Models\SiteSetting;
use App\Support\MediaUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SiteSetting */
class SettingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'social' => [
                'vk' => $this->vk_url,
                'telegram' => $this->telegram_url,
                'youtube' => $this->youtube_url,
            ],
            'hero' => [
                'eyebrow' => $this->hero_eyebrow,
                'title' => $this->hero_title,
                'subtitle' => $this->hero_subtitle,
            ],
            'about' => [
                'eyebrow' => $this->about_eyebrow,
                'title' => $this->about_title,
                'lead' => $this->about_lead,
                'image' => MediaUrl::make($this->about_image_path),
            ],
            'stats' => [
                'years' => $this->stat_years,
                'concerts' => $this->stat_concerts,
                'trips' => $this->stat_trips,
            ],
            'requisites' => [
                'card_number' => $this->card_number,
                'recipient' => $this->recipient,
                'inn' => $this->inn,
                'bank_account' => $this->bank_account,
                'bik' => $this->bik,
                'qr_image' => MediaUrl::make($this->qr_image_path),
            ],
            'default_og_image' => MediaUrl::make($this->default_og_image),
            'is_development_mode' => (bool) $this->is_development_mode,
        ];
    }
}
