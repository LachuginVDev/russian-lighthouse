<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PartnerController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PartnerResource::collection(
            Partner::query()->active()->orderBy('sort_order')->get()
        );
    }
}
