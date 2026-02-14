<?php

namespace App\Http\Middleware;

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
                'image' => $link->image ? \Illuminate\Support\Facades\Storage::url($link->image) : null,
            ]);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'social_links' => $socialLinks,
        ];
    }
}
