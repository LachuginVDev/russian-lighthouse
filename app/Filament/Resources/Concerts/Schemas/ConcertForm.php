<?php

namespace App\Filament\Resources\Concerts\Schemas;

use App\Enums\ConcertBadgeType;
use App\Enums\ConcertStatus;
use App\Filament\Support\EmbeddedTrackSelect;
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

class ConcertForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('concert')
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
                                        DateTimePicker::make('starts_at')
                                            ->label('Начало')
                                            ->seconds(false)
                                            ->required(),
                                        DateTimePicker::make('ends_at')
                                            ->label('Окончание')
                                            ->seconds(false),
                                        TextInput::make('venue')
                                            ->label('Площадка')
                                            ->maxLength(255),
                                        TextInput::make('city')
                                            ->label('Город')
                                            ->maxLength(255),
                                        TextInput::make('address')
                                            ->label('Адрес')
                                            ->maxLength(255)
                                            ->columnSpanFull(),
                                        Select::make('badge_type')
                                            ->label('Тип бейджа')
                                            ->options(EnumOptions::from(ConcertBadgeType::class)),
                                        Select::make('status')
                                            ->label('Статус')
                                            ->options(EnumOptions::from(ConcertStatus::class))
                                            ->required(),
                                        TextInput::make('ticket_status_label')
                                            ->label('Статус билетов')
                                            ->maxLength(255),
                                        TextInput::make('ticket_url')
                                            ->label('Ссылка на билеты')
                                            ->url()
                                            ->maxLength(255),
                                        Textarea::make('excerpt')
                                            ->label('Анонс')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('body')
                                            ->label('Описание')
                                            ->columnSpanFull(),
                                        EmbeddedTrackSelect::make()
                                            ->columnSpanFull(),
                                        Select::make('fundraising_id')
                                            ->label('Сбор')
                                            ->relationship('fundraising', 'title')
                                            ->searchable()
                                            ->preload(),
                                    ]),
                            ]),
                        Tab::make('Медиа')
                            ->schema([
                                FileUpload::make('cover_path')
                                    ->label('Обложка')
                                    ->image()
                                    ->disk('public')
                                    ->directory('concerts/covers')
                                    ->visibility('public')
                                    ->imageEditor(),
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
                                TextInput::make('meta_title')
                                    ->label('Meta title')
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->label('Meta description')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
