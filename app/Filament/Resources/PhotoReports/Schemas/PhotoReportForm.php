<?php

namespace App\Filament\Resources\PhotoReports\Schemas;

use App\Enums\PhotoReportCategory;
use App\Filament\Support\EnumOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
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

class PhotoReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('photoReport')
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
                                        Select::make('category')
                                            ->label('Категория')
                                            ->options(EnumOptions::from(PhotoReportCategory::class))
                                            ->required(),
                                        DatePicker::make('report_date')
                                            ->label('Дата репортажа'),
                                        Textarea::make('excerpt')
                                            ->label('Краткое описание')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Textarea::make('lead')
                                            ->label('Лид')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Медиа')
                            ->schema([
                                FileUpload::make('cover_path')
                                    ->label('Обложка')
                                    ->image()
                                    ->disk('public')
                                    ->directory('photo-reports/covers')
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
