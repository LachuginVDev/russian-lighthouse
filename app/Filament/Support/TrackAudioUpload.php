<?php

namespace App\Filament\Support;

use Filament\Forms\Components\FileUpload;

final class TrackAudioUpload
{
    public static function make(string $name = 'audio_path'): FileUpload
    {
        return FileUpload::make($name)
            ->label('Аудиофайл')
            ->disk('public')
            ->directory('tracks/audio')
            ->visibility('public')
            ->acceptedFileTypes([
                'audio/mpeg',
                'audio/mp3',
                'audio/mp4',
                'audio/x-m4a',
                'audio/m4a',
                'audio/wav',
                'audio/x-wav',
                'audio/wave',
                'audio/ogg',
                'audio/aac',
                'audio/flac',
                'audio/x-flac',
                // часть браузеров/ОС отдаёт mp3/m4a так:
                'video/mp4',
                'application/octet-stream',
            ])
            ->rules(['nullable', 'file', 'max:102400'])
            ->maxSize(102400)
            ->helperText('MP3, WAV, OGG, M4A, AAC, FLAC — до 100 МБ.')
            ->downloadable()
            ->openable()
            ->columnSpanFull();
    }
}
