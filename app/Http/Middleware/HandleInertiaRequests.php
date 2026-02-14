<?php

namespace App\Http\Middleware;

use App\Models\HomeSetting;
use App\Models\Slide;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $socialLinks = SocialLink::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($link) => [
                'title' => $link->title,
                'url' => $link->url,
                'image' => $link->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($link->image) : null,
            ]);

        $slides = Slide::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($slide) => [
                'id' => $slide->id,
                'imageUrl' => \Illuminate\Support\Facades\Storage::disk('public')->url($slide->image),
                'alt' => $slide->text,
                'link' => $slide->link,
            ]);

        $homeSetting = HomeSetting::get();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'social_links' => $socialLinks,
            'slides' => $slides,
            'home' => [
                'hero_title' => $homeSetting->hero_title,
                'hero_subtitle' => $homeSetting->hero_subtitle,
                'hero_text_color' => $homeSetting->hero_text_color ?? HomeSetting::TEXT_COLOR_WHITE,
                'logo' => $homeSetting->logo
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($homeSetting->logo)
                    : null,
            ],
        ];
    }
}
