<?php

namespace App\Http\Middleware;

use App\Models\HomeSetting;
use App\Models\PageSeo;
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

        $pageSeo = PageSeo::query()
            ->get()
            ->keyBy('page_slug')
            ->map(fn (PageSeo $p) => [
                'meta_title' => $p->meta_title,
                'meta_description' => $p->meta_description,
                'og_image' => $p->og_image
                    ? \Illuminate\Support\Facades\Storage::disk('public')->url($p->og_image)
                    : null,
            ])
            ->toArray();

        return [
            ...parent::share($request),
            'app_url' => config('app.url'),
            'auth' => [
                'user' => $request->user(),
            ],
            'social_links' => $socialLinks,
            'slides' => $slides,
            'page_seo' => $pageSeo,
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
