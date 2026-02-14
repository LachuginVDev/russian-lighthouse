<?php

declare(strict_types=1);

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Публикация')
                    ->schema([
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('URL (slug)')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->hint('Необязательно — подставится из заголовка при сохранении'),
                        Select::make('status')
                            ->label('Статус')
                            ->options([
                                Post::STATUS_DRAFT => 'Черновик',
                                Post::STATUS_PUBLISHED => 'Опубликован',
                            ])
                            ->default(Post::STATUS_DRAFT)
                            ->required()
                            ->hint('На сайте /news отображаются только посты со статусом «Опубликован»'),
                        DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->nullable()
                            ->hint('Если пусто при статусе «Опубликован» — подставится текущая дата'),
                        RichEditor::make('body')
                            ->label('Текст')
                            ->nullable()
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('Главное изображение')
                            ->image()
                            ->disk('public')
                            ->directory('posts')
                            ->nullable(),
                        FileUpload::make('images')
                            ->label('Галерея (несколько фото)')
                            ->image()
                            ->disk('public')
                            ->directory('posts/gallery')
                            ->multiple()
                            ->reorderable()
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Видео')
                    ->schema([
                        TextInput::make('video_url')
                            ->label('Ссылка на видео (YouTube, VK и т.д.)')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->nullable(),
                        FileUpload::make('video_file')
                            ->label('Локальное видео (MP4 и др.)')
                            ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/ogg'])
                            ->disk('public')
                            ->directory('posts/videos')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
                Section::make('Категория и теги')
                    ->schema([
                        Select::make('category_id')
                            ->label('Категория')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('tags')
                            ->label('Теги')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta заголовок')
                            ->maxLength(255)
                            ->nullable(),
                        TextInput::make('meta_description')
                            ->label('Meta описание')
                            ->maxLength(500)
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
