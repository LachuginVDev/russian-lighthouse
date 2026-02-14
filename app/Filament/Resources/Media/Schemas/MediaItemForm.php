<?php

declare(strict_types=1);

namespace App\Filament\Resources\Media\Schemas;

use App\Models\MediaItem;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MediaItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Элемент')
                    ->schema([
                        Select::make('media_playlist_id')
                            ->label('Плейлист')
                            ->relationship('playlist', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('type')
                            ->label('Тип')
                            ->options([
                                MediaItem::TYPE_VIDEO_URL => 'Видео по ссылке',
                                MediaItem::TYPE_VIDEO_FILE => 'Видео файл',
                                MediaItem::TYPE_IMAGE => 'Изображение',
                            ])
                            ->required()
                            ->live(),
                        TextInput::make('title')
                            ->label('Название')
                            ->maxLength(255),
                        TextInput::make('video_url')
                            ->label('Ссылка на видео (YouTube, VK)')
                            ->url()
                            ->maxLength(500)
                            ->visible(fn ($get) => $get('type') === MediaItem::TYPE_VIDEO_URL),
                        FileUpload::make('video_file')
                            ->label('Видео файл (MP4 и др.)')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->disk('public')
                            ->directory('media/videos')
                            ->visible(fn ($get) => $get('type') === MediaItem::TYPE_VIDEO_FILE),
                        FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->disk('public')
                            ->directory('media/images')
                            ->visible(fn ($get) => $get('type') === MediaItem::TYPE_IMAGE),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
