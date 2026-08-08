<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class MediaUrl
{
    public static function make(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return url($path);
        }

        return Storage::disk('public')->url($path);
    }
}
