<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Enums\VideoCategory;
use App\Filament\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class VideoForm
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
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, ?string $old, Get $get): void {
                                if (filled($get('slug')) && $get('slug') !== Str::slug((string) $old)) {
                                    return;
                                }

                                $set('slug', Str::slug((string) $state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Select::make('category')
                            ->label('Категория')
                            ->options(EnumOptions::from(VideoCategory::class))
                            ->required(),
                        TextInput::make('type_label')
                            ->label('Тип (подпись)')
                            ->maxLength(255),
                        TextInput::make('duration_label')
                            ->label('Длительность')
                            ->maxLength(255),
                        TextInput::make('embed_url')
                            ->label('Embed URL')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        FileUpload::make('thumbnail_path')
                            ->label('Превью')
                            ->image()
                            ->disk('public')
                            ->directory('videos/thumbnails')
                            ->visibility('public')
                            ->columnSpanFull(),
                        DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->seconds(false),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        Toggle::make('is_featured_home')
                            ->label('На главной')
                            ->inline(false),
                    ]),
            ]);
    }
}
