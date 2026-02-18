<?php

declare(strict_types=1);

namespace App\Filament\Resources\PhotoAlbums\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PhotoAlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Альбом')
                    ->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('URL (slug)')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->hint('Необязательно — подставится из названия'),
                        FileUpload::make('cover_image')
                            ->label('Обложка (если пусто — первое фото альбома)')
                            ->image()
                            ->disk('public')
                            ->directory('albums/covers')
                            ->nullable(),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }
}
