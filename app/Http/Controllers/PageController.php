<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function albumsIndex(): View
    {
        return view('pages.albums.index');
    }

    public function albumsShow(string $slug): View
    {
        return view('pages.albums.show');
    }

    public function videosIndex(): View
    {
        return view('pages.videos.index');
    }

    public function photosIndex(): View
    {
        return view('pages.photos.index');
    }

    public function photosShow(string $slug): View
    {
        return view('pages.photos.show');
    }

    public function newsIndex(): View
    {
        return view('pages.news.index');
    }

    public function newsShow(string $slug): View
    {
        return view('pages.news.show');
    }

    public function concertsIndex(): View
    {
        return view('pages.concerts.index');
    }

    public function concertsShow(string $slug): View
    {
        return view('pages.concerts.show');
    }

    public function privacy(): View
    {
        return view('pages.static.privacy');
    }

    public function reports(): View
    {
        return view('pages.static.reports');
    }
}
