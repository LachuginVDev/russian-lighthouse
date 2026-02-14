<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MediaItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MediaController extends Controller
{
    public function index(Request $request): Response
    {
        $playlists = \App\Models\MediaPlaylist::query()
            ->with(['items' => fn ($q) => $q->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'items' => $p->items->map(fn ($i) => self::mapItem($i))->values()->all(),
            ]);

        $standalone = MediaItem::query()
            ->whereNull('media_playlist_id')
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($i) => self::mapItem($i));

        $allVideoItems = collect();
        foreach ($playlists as $p) {
            foreach ($p['items'] as $i) {
                if ($i['type'] !== 'image') {
                    $allVideoItems->push($i);
                }
            }
        }
        $allVideoItems = $allVideoItems->concat($standalone->filter(fn ($i) => ($i['type'] ?? '') !== 'image'));

        $allImages = collect();
        foreach ($playlists as $p) {
            foreach ($p['items'] as $i) {
                if ($i['type'] === 'image') {
                    $allImages->push($i);
                }
            }
        }
        $allImages = $allImages->concat($standalone->filter(fn ($i) => ($i['type'] ?? '') === 'image'));

        return Inertia::render('Media/Index', [
            'playlists' => $playlists,
            'standalone' => $standalone->values()->all(),
            'videoItems' => $allVideoItems->values()->all(),
            'imageItems' => $allImages->values()->all(),
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ]);
    }

    private static function mapItem(MediaItem $item): array
    {
        $base = [
            'id' => $item->id,
            'type' => $item->type,
            'title' => $item->title,
        ];
        if ($item->video_url) {
            $base['video_url'] = $item->video_url;
        }
        if ($item->video_file) {
            $base['video_file'] = \Illuminate\Support\Facades\Storage::disk('public')->url($item->video_file);
        }
        if ($item->image) {
            $base['image'] = \Illuminate\Support\Facades\Storage::disk('public')->url($item->image);
        }
        return $base;
    }
}
