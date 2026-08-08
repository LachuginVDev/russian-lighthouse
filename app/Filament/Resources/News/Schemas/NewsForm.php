<?php

namespace App\Filament\Resources\News\Schemas;

use App\Enums\NewsCategory;
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

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('news')
                    ->tabs([
                        Tab::make('Контент')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Заголовок')
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
                                            ->options(EnumOptions::from(NewsCategory::class))
                                            ->required(),
                                        TextInput::make('reading_time')
                                            ->label('Время чтения')
                                            ->maxLength(255),
                                        Textarea::make('excerpt')
                                            ->label('Анонс')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('body')
                                            ->label('Текст статьи')
                                            ->required()
                                            ->helperText('Этот текст показывается на странице новости. Анонс — только в карточках.')
                                            ->columnSpanFull(),
                                        Select::make('tags')
                                            ->label('Теги')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->columnSpanFull(),
                                        EmbeddedTrackSelect::make()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Автор и медиа')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('author_name')
                                            ->label('Автор')
                                            ->maxLength(255),
                                        TextInput::make('author_role')
                                            ->label('Роль автора')
                                            ->maxLength(255),
                                        TextInput::make('author_initials')
                                            ->label('Инициалы')
                                            ->maxLength(10),
                                        FileUpload::make('cover_path')
                                            ->label('Обложка')
                                            ->image()
                                            ->disk('public')
                                            ->directory('news/covers')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Публикация')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        DateTimePicker::make('published_at')
                                            ->label('Дата публикации')
                                            ->default(now())
                                            ->seconds(false)
                                            ->helperText('Пустое поле = черновик (не показывается на сайте).'),
                                        TextInput::make('sort_order')
                                            ->label('Порядок')
                                            ->numeric()
                                            ->default(0)
                                            ->required(),
                                        Toggle::make('is_featured_home')
                                            ->label('На главной')
                                            ->default(true)
                                            ->inline(false)
                                            ->helperText('Показывать карточку в блоке новостей на главной странице.'),
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
