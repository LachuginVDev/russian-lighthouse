<?php

use App\Http\Controllers\Api\V1\AlbumController;
use App\Http\Controllers\Api\V1\ConcertController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\FundraisingController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\PartnerController;
use App\Http\Controllers\Api\V1\PhotoReportController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('home', HomeController::class)->name('home');
    Route::get('settings', SettingController::class)->name('settings');

    Route::get('albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
    Route::get('albums/{slug}/tracks', [AlbumController::class, 'tracks'])->name('albums.tracks');

    Route::get('videos', [VideoController::class, 'index'])->name('videos.index');

    Route::get('photo-reports', [PhotoReportController::class, 'index'])->name('photo-reports.index');
    Route::get('photo-reports/{slug}', [PhotoReportController::class, 'show'])->name('photo-reports.show');

    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/{slug}', [NewsController::class, 'show'])->name('news.show');

    Route::get('concerts', [ConcertController::class, 'index'])->name('concerts.index');
    Route::get('concerts/{slug}', [ConcertController::class, 'show'])->name('concerts.show');

    Route::get('fundraisings/current', [FundraisingController::class, 'current'])->name('fundraisings.current');
    Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');

    Route::post('contact', [ContactController::class, 'store'])
        ->middleware('throttle:contact')
        ->name('contact');
});
