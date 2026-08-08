<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AlbumResource;
use App\Http\Resources\Api\V1\TrackResource;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlbumController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Album::query()->published()->orderBy('sort_order');

        if ($request->filled('year')) {
            $query->where('year', (int) $request->query('year'));
        }

        return AlbumResource::collection($query->paginate((int) $request->query('per_page', 12)));
    }

    public function show(string $slug): AlbumResource
    {
        $album = Album::query()->published()->where('slug', $slug)->with('tracks')->firstOrFail();

        return new AlbumResource($album);
    }

    public function tracks(string $slug): AnonymousResourceCollection
    {
        $album = Album::query()->published()->where('slug', $slug)->firstOrFail();

        return TrackResource::collection($album->tracks()->with('album')->get());
    }
}
