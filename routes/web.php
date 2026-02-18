<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

Route::get('/', function () {
    $albums = \App\Models\PhotoAlbum::query()
        ->with(['photos'])
        ->orderBy('sort_order')
        ->orderBy('id')
        ->limit(6)
        ->get()
        ->map(function (\App\Models\PhotoAlbum $album) {
            $coverPath = $album->cover_image ?: $album->photos->first()?->image;
            $coverUrl = $coverPath ? \Illuminate\Support\Facades\Storage::disk('public')->url($coverPath) : null;
            $photos = $album->photos->map(fn ($p) => [
                'id' => $p->id,
                'image' => \Illuminate\Support\Facades\Storage::disk('public')->url($p->image),
                'caption' => $p->caption,
            ])->values()->all();

            return [
                'id' => $album->id,
                'title' => $album->title,
                'cover' => $coverUrl,
                'photos' => $photos,
            ];
        });

    $news = Post::query()
        ->published()
        ->orderByDesc('published_at')
        ->limit(12)
        ->get()
        ->map(function (Post $post) {
            $images = $post->images ?? [];
            return [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => $post->body ? \Illuminate\Support\Str::limit(strip_tags($post->body), 160) : null,
                'date' => $post->published_at?->format('d.m.Y'),
                'href' => route('news.show', $post->slug),
                'image' => $post->image ? Storage::disk('public')->url($post->image) : (count($images) ? Storage::disk('public')->url($images[0]) : null),
            ];
        });

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'albums' => $albums,
        'news' => $news,
    ]);
})->name('home');

$publicProps = fn () => ['canLogin' => Route::has('login'), 'canRegister' => Route::has('register')];

Route::get('/about', fn () => Inertia::render('About', $publicProps()))->name('about');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{idOrSlug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/fundraisers', [\App\Http\Controllers\FundraiserController::class, 'index'])->name('fundraisers.index');
Route::get('/fundraisers/{id}', fn (int $id) => app(\App\Http\Controllers\FundraiserController::class)->show(request(), $id))->name('fundraisers.show');
Route::post('/fundraisers/{id}/donate', [\App\Http\Controllers\FundraiserController::class, 'storeDonation'])->name('fundraisers.donate');
Route::get('/media', [\App\Http\Controllers\MediaController::class, 'index'])->name('media.index');
Route::get('/albums', [\App\Http\Controllers\AlbumController::class, 'index'])->name('albums.index');
Route::get('/contacts', fn () => Inertia::render('Contacts', $publicProps()))->name('contacts');
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, '__invoke'])->name('sitemap');
Route::post('/contacts', function (\Illuminate\Http\Request $request) {
    $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email', 'message' => 'required|string|max:5000']);
    // TODO: отправить письмо / в очередь
    return back()->with('status', 'Сообщение отправлено.');
})->name('contacts.send');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/export/donations', [\App\Http\Controllers\Admin\DonationExportController::class, '__invoke'])
        ->middleware('admin')
        ->name('admin.export.donations');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
