<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ConcertStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ConcertResource;
use App\Models\Concert;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConcertController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Concert::query()->published()->orderBy('starts_at');

        $status = $request->query('status');
        if ($status === 'upcoming') {
            $query->where('status', ConcertStatus::Upcoming)->orderBy('starts_at');
        } elseif ($status === 'past') {
            $query->where('status', ConcertStatus::Past)->orderByDesc('starts_at');
        }

        return ConcertResource::collection($query->paginate((int) $request->query('per_page', 12)));
    }

    public function show(string $slug): ConcertResource
    {
        $concert = Concert::query()->published()->where('slug', $slug)->firstOrFail();

        return new ConcertResource($concert);
    }
}
