<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PhotoReportResource;
use App\Models\PhotoReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PhotoReportController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = PhotoReport::query()->published()->orderByDesc('report_date');

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        return PhotoReportResource::collection($query->paginate((int) $request->query('per_page', 12)));
    }

    public function show(string $slug): PhotoReportResource
    {
        $report = PhotoReport::query()->published()->where('slug', $slug)->with('photos')->firstOrFail();

        return new PhotoReportResource($report);
    }
}
