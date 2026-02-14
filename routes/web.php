<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

$publicProps = fn () => ['canLogin' => Route::has('login'), 'canRegister' => Route::has('register')];

Route::get('/about', fn () => Inertia::render('About', $publicProps()))->name('about');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{idOrSlug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/fundraisers', fn () => Inertia::render('Fundraisers/Index', ['items' => [], ...$publicProps()]))->name('fundraisers.index');
Route::get('/fundraisers/{id}', fn ($id) => Inertia::render('Fundraisers/Show', ['id' => (int) $id, 'fundraiser' => null, ...$publicProps()]))->name('fundraisers.show');
Route::get('/media', fn () => Inertia::render('Media/Index', $publicProps()))->name('media.index');
Route::get('/contacts', fn () => Inertia::render('Contacts', $publicProps()))->name('contacts');
Route::post('/contacts', function (\Illuminate\Http\Request $request) {
    $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email', 'message' => 'required|string|max:5000']);
    // TODO: отправить письмо / в очередь
    return back()->with('status', 'Сообщение отправлено.');
})->name('contacts.send');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
