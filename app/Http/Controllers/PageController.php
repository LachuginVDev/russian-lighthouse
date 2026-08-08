<?php

namespace App\Http\Controllers;

use App\Enums\ConcertStatus;
use App\Enums\FundraisingStatus;
use App\Models\Album;
use App\Models\Concert;
use App\Models\Fundraising;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use App\Models\PhotoReport;
use App\Models\Report;
use App\Models\SiteSetting;
use App\Models\Track;
use App\Models\Video;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $settings = SiteSetting::current();

        return view('pages.home', [
            'settings' => $settings,
            'featuredTracks' => Track::query()
                ->where('is_featured_home', true)
                ->orderBy('position')
                ->limit(8)
                ->get(),
            'albums' => Album::query()->published()->orderBy('sort_order')->limit(6)->get(),
            'videos' => Video::query()->published()->where('is_featured_home', true)->orderBy('sort_order')->limit(8)->get(),
            'photoReports' => PhotoReport::query()->published()->where('is_featured_home', true)->orderBy('sort_order')->limit(6)->get(),
            'news' => News::query()->published()->orderByDesc('published_at')->limit(3)->get(),
            'concerts' => Concert::query()->published()->where('status', ConcertStatus::Upcoming)->orderBy('starts_at')->limit(3)->get(),
            'fundraising' => Fundraising::query()
                ->where('is_featured_home', true)
                ->where('status', FundraisingStatus::Open)
                ->latest('published_at')
                ->first(),
            'partners' => Partner::query()->active()->orderBy('sort_order')->get(),
        ]);
    }

    public function albumsIndex(): View
    {
        $albums = Album::query()->published()->orderBy('sort_order')->get();

        return view('pages.albums.index', [
            'albums' => $albums,
            'years' => $albums->pluck('year')->filter()->unique()->sortDesc()->values(),
        ]);
    }

    public function albumsShow(string $slug): View
    {
        $album = Album::query()->published()->where('slug', $slug)->with('tracks')->firstOrFail();

        return view('pages.albums.show', compact('album'));
    }

    public function videosIndex(): View
    {
        $videos = Video::query()->published()->orderBy('sort_order')->get();

        return view('pages.videos.index', compact('videos'));
    }

    public function photosIndex(): View
    {
        $reports = PhotoReport::query()->published()->orderByDesc('report_date')->get();

        return view('pages.photos.index', compact('reports'));
    }

    public function photosShow(string $slug): View
    {
        $report = PhotoReport::query()->published()->where('slug', $slug)->with('photos')->firstOrFail();

        return view('pages.photos.show', compact('report'));
    }

    public function newsIndex(): View
    {
        $news = News::query()->published()->orderByDesc('published_at')->get();

        return view('pages.news.index', compact('news'));
    }

    public function newsShow(string $slug): View
    {
        $item = News::query()->published()->where('slug', $slug)->with(['tags', 'embeddedTrack'])->firstOrFail();

        return view('pages.news.show', compact('item'));
    }

    public function concertsIndex(): View
    {
        $upcoming = Concert::query()->published()->where('status', ConcertStatus::Upcoming)->orderBy('starts_at')->get();
        $past = Concert::query()->published()->where('status', ConcertStatus::Past)->orderByDesc('starts_at')->get();

        return view('pages.concerts.index', compact('upcoming', 'past'));
    }

    public function concertsShow(string $slug): View
    {
        $concert = Concert::query()->published()->where('slug', $slug)->with(['embeddedTrack', 'fundraising'])->firstOrFail();

        return view('pages.concerts.show', compact('concert'));
    }

    public function privacy(): View
    {
        $page = Page::query()->published()->where('slug', 'privacy')->firstOrFail();

        return view('pages.static.privacy', compact('page'));
    }

    public function reports(): View
    {
        $page = Page::query()->published()->where('slug', 'reports')->first();
        $reports = Report::query()->published()->orderByDesc('published_at')->get();

        return view('pages.static.reports', compact('page', 'reports'));
    }
}
