<?php

namespace App\Filament\Resources\Tracks\Schemas;

use App\Filament\Support\TrackAudioUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('artist')
                            ->label('Исполнитель')
                            ->default('Русский Маяк')
                            ->maxLength(255),
                        Select::make('album_id')
                            ->label('Альбом')
                            ->relationship('album', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('duration')
                            ->label('Длительность')
                            ->placeholder('3:42')
                            ->maxLength(255),
                        TextInput::make('position')
                            ->label('Позиция')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_featured_home')
                            ->label('На главной')
                            ->inline(false),
                        TrackAudioUpload::make(),
                        FileUpload::make('cover_path')
                            ->label('Обложка трека')
                            ->image()
                            ->disk('public')
                            ->directory('tracks/covers')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
