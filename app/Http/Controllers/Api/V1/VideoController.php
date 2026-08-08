<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\VideoResource;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VideoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Video::query()->published()->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        return VideoResource::collection($query->paginate((int) $request->query('per_page', 24)));
    }
}
