<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = News::query()->published()->orderByDesc('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        return NewsResource::collection($query->paginate((int) $request->query('per_page', 12)));
    }

    public function show(string $slug): NewsResource
    {
        $item = News::query()
            ->published()
            ->where('slug', $slug)
            ->with(['tags', 'embeddedTrack.album'])
            ->firstOrFail();

        return new NewsResource($item);
    }
}
