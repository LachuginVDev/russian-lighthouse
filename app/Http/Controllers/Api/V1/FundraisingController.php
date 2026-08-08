<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\FundraisingStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FundraisingResource;
use App\Models\Fundraising;
use Illuminate\Http\JsonResponse;

class FundraisingController extends Controller
{
    public function current(): JsonResponse
    {
        $fundraising = Fundraising::query()
            ->where('is_featured_home', true)
            ->where('status', FundraisingStatus::Open)
            ->latest('published_at')
            ->first();

        return response()->json([
            'data' => $fundraising ? (new FundraisingResource($fundraising))->resolve() : null,
        ]);
    }
}
