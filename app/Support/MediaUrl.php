<?php

namespace App\Support;

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
            return $path;
        }

        // Относительный URL — работает и на localhost, и на 127.0.0.1
        return '/storage/'.ltrim($path, '/');
    }
}
