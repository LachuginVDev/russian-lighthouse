<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PhotoAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AlbumController extends Controller
{
    public function index(Request $request): Response
    {
        $albums = PhotoAlbum::query()
            ->with(['photos'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (PhotoAlbum $album) {
                $coverPath = $album->cover_image ?: $album->photos->first()?->image;
                $coverUrl = $coverPath ? Storage::disk('public')->url($coverPath) : null;
                $photos = $album->photos->map(fn ($p) => [
                    'id' => $p->id,
                    'image' => Storage::disk('public')->url($p->image),
                    'caption' => $p->caption,
                ])->values()->all();

                return [
                    'id' => $album->id,
                    'title' => $album->title,
                    'cover' => $coverUrl,
                    'photos' => $photos,
                ];
            });

        return Inertia::render('Albums/Index', [
            'albums' => $albums,
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ]);
    }
}
