<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Текст / название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->label('Ссылка')
                    ->url()
                    ->required()
                    ->maxLength(500),
                FileUpload::make('image')
                    ->label('Картинка / заглушка')
                    ->image()
                    ->directory('social')
                    ->nullable(),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
