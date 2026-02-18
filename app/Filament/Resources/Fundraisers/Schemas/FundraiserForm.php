<?php

declare(strict_types=1);

namespace App\Filament\Resources\Fundraisers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FundraiserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Сбор')
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
                        RichEditor::make('description')
                            ->label('Описание')
                            ->nullable()
                            ->columnSpanFull(),
                        TextInput::make('goal')
                            ->label('Цель (₽)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                        TextInput::make('raised')
                            ->label('Собрано (₽)')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->required(),
                        TextInput::make('sort_order')
                            ->label('Порядок')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label('Активен')
                            ->default(true),
                    ])
                    ->columns(2),
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
                        FileUpload::make('og_image')
                            ->label('Изображение для превью (OpenGraph)')
                            ->image()
                            ->disk('public')
                            ->directory('fundraisers/og')
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }
}
