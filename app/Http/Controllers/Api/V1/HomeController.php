<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ConcertStatus;
use App\Enums\FundraisingStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\AlbumResource;
use App\Http\Resources\Api\V1\ConcertResource;
use App\Http\Resources\Api\V1\FundraisingResource;
use App\Http\Resources\Api\V1\NewsResource;
use App\Http\Resources\Api\V1\PartnerResource;
use App\Http\Resources\Api\V1\PhotoReportResource;
use App\Http\Resources\Api\V1\SettingResource;
use App\Http\Resources\Api\V1\TrackResource;
use App\Http\Resources\Api\V1\VideoResource;
use App\Models\Album;
use App\Models\Concert;
use App\Models\Fundraising;
use App\Models\News;
use App\Models\Partner;
use App\Models\PhotoReport;
use App\Models\SiteSetting;
use App\Models\Track;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $fundraising = Fundraising::query()
            ->where('is_featured_home', true)
            ->where('status', FundraisingStatus::Open)
            ->latest('published_at')
            ->first();

        return response()->json([
            'data' => [
                'settings' => (new SettingResource(SiteSetting::current()))->resolve(),
                'tracks' => TrackResource::collection(
                    Track::query()->where('is_featured_home', true)->orderBy('position')->limit(8)->get()
                )->resolve(),
                'albums' => AlbumResource::collection(
                    Album::query()->published()->orderBy('sort_order')->limit(6)->get()
                )->resolve(),
                'videos' => VideoResource::collection(
                    Video::query()->published()->where('is_featured_home', true)->orderBy('sort_order')->limit(8)->get()
                )->resolve(),
                'photo_reports' => PhotoReportResource::collection(
                    PhotoReport::query()->published()->where('is_featured_home', true)->orderBy('sort_order')->limit(6)->get()
                )->resolve(),
                'news' => NewsResource::collection(
                    News::query()->published()->orderByDesc('published_at')->limit(3)->get()
                )->resolve(),
                'concerts' => ConcertResource::collection(
                    Concert::query()->published()->where('status', ConcertStatus::Upcoming)->orderBy('starts_at')->limit(3)->get()
                )->resolve(),
                'fundraising' => $fundraising ? (new FundraisingResource($fundraising))->resolve() : null,
                'partners' => PartnerResource::collection(
                    Partner::query()->active()->orderBy('sort_order')->get()
                )->resolve(),
            ],
        ]);
    }
}
