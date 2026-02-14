<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

return function (): void {
    Route::get('/storage/{path}', function (string $path) {
        $path = urldecode($path);
        if ($path === '' || str_contains($path, '..')) {
            abort(404);
        }
        foreach (['public', 'local'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->response($path, basename($path), [
                    'Cache-Control' => 'public, max-age=31536000',
                ]);
            }
        }
        abort(404);
    })->where('path', '.*')->name('storage.serve');
};
