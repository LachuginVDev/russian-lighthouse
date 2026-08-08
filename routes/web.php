<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/albums', [PageController::class, 'albumsIndex'])->name('albums.index');
Route::get('/albums/{slug}', [PageController::class, 'albumsShow'])->name('albums.show');

Route::get('/video', [PageController::class, 'videosIndex'])->name('videos.index');

Route::get('/photos', [PageController::class, 'photosIndex'])->name('photos.index');
Route::get('/photos/{slug}', [PageController::class, 'photosShow'])->name('photos.show');

Route::get('/news', [PageController::class, 'newsIndex'])->name('news.index');
Route::get('/news/{slug}', [PageController::class, 'newsShow'])->name('news.show');

Route::get('/concerts', [PageController::class, 'concertsIndex'])->name('concerts.index');
Route::get('/concerts/{slug}', [PageController::class, 'concertsShow'])->name('concerts.show');

Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/reports', [PageController::class, 'reports'])->name('pages.reports');

// Совместимость со старыми .html URL — на листинги, без демо-slug
Route::redirect('/index.html', '/', 301);
Route::redirect('/albums.html', '/albums', 301);
Route::redirect('/album.html', '/albums', 301);
Route::redirect('/video.html', '/video', 301);
Route::redirect('/photos.html', '/photos', 301);
Route::redirect('/photo-report.html', '/photos', 301);
Route::redirect('/news.html', '/news', 301);
Route::redirect('/news-single.html', '/news', 301);
Route::redirect('/concerts.html', '/concerts', 301);
Route::redirect('/concert-single.html', '/concerts', 301);
Route::redirect('/privacy.html', '/privacy', 301);
Route::redirect('/reports.html', '/reports', 301);
