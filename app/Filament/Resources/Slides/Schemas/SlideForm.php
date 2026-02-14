<?php

declare(strict_types=1);

namespace App\Filament\Resources\Slides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->disk('public')
                    ->directory('slides')
                    ->required(),
                TextInput::make('text')
                    ->label('Текст / подпись')
                    ->maxLength(255),
                TextInput::make('link')
                    ->label('Ссылка на страницу')
                    ->url()
                    ->maxLength(500),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
