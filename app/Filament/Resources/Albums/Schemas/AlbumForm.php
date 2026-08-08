<?php

namespace App\Filament\Resources\Albums\Schemas;

use App\Enums\AlbumStatus;
use App\Enums\AlbumType;
use App\Filament\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('album')
                    ->tabs([
                        Tab::make('Контент')
                            ->schema([
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
                                        TextInput::make('year')
                                            ->label('Год')
                                            ->numeric()
                                            ->minValue(1900)
                                            ->maxValue(2100),
                                        Select::make('type')
                                            ->label('Тип')
                                            ->options(EnumOptions::from(AlbumType::class))
                                            ->required(),
                                        Select::make('status')
                                            ->label('Статус')
                                            ->options(EnumOptions::from(AlbumStatus::class))
                                            ->required(),
                                        TextInput::make('genre')
                                            ->label('Жанр')
                                            ->maxLength(255),
                                        TextInput::make('duration_label')
                                            ->label('Длительность')
                                            ->maxLength(255),
                                        TextInput::make('badge_label')
                                            ->label('Бейдж')
                                            ->maxLength(255),
                                        Textarea::make('excerpt')
                                            ->label('Краткое описание')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('description')
                                            ->label('Описание')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Медиа')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        FileUpload::make('cover_path')
                                            ->label('Обложка')
                                            ->image()
                                            ->disk('public')
                                            ->directory('albums/covers')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                        TextInput::make('vk_url')
                                            ->label('VK Music')
                                            ->url()
                                            ->maxLength(255),
                                        TextInput::make('youtube_music_url')
                                            ->label('YouTube Music')
                                            ->url()
                                            ->maxLength(255),
                                    ]),
                            ]),
                        Tab::make('Публикация')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
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
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta title')
                                            ->maxLength(255),
                                        Textarea::make('meta_description')
                                            ->label('Meta description')
                                            ->rows(3),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
