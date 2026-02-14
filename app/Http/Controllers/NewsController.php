<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = Post::query()
            ->published()
            ->with('category')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->through(function (Post $post) {
                $images = $post->images ?? [];
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => $post->body ? \Illuminate\Support\Str::limit(strip_tags($post->body), 160) : null,
                    'date' => $post->published_at?->format('d.m.Y'),
                    'href' => route('news.show', $post->slug),
                    'image' => $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : (count($images) ? \Illuminate\Support\Facades\Storage::url($images[0]) : null),
                ];
            });

        return Inertia::render('News/Index', [
            'posts' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ],
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ]);
    }

    public function show(Request $request, string $idOrSlug): Response
    {
        $post = Post::query()
            ->published()
            ->where(fn ($q) => is_numeric($idOrSlug)
                ? $q->where('id', (int) $idOrSlug)
                : $q->where('slug', $idOrSlug))
            ->with('category', 'tags')
            ->first();

        $publicProps = [
            'canLogin' => \Illuminate\Support\Facades\Route::has('login'),
            'canRegister' => \Illuminate\Support\Facades\Route::has('register'),
        ];

        if (! $post) {
            return Inertia::render('News/Show', [
                'id' => is_numeric($idOrSlug) ? (int) $idOrSlug : 0,
                'post' => null,
                ...$publicProps,
            ]);
        }

        $images = $post->images ?? [];
        $imageUrls = array_map(fn ($path) => \Illuminate\Support\Facades\Storage::url($path), $images);

        return Inertia::render('News/Show', [
            'id' => $post->id,
            'post' => [
                'title' => $post->title,
                'body' => $post->body,
                'date' => $post->published_at?->format('d.m.Y'),
                'image' => $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : (count($imageUrls) ? $imageUrls[0] : null),
                'images' => $imageUrls,
                'video_url' => $post->video_url,
                'video_file' => $post->video_file ? \Illuminate\Support\Facades\Storage::url($post->video_file) : null,
                'meta_title' => $post->meta_title,
                'meta_description' => $post->meta_description,
            ],
            ...$publicProps,
        ]);
    }
}
