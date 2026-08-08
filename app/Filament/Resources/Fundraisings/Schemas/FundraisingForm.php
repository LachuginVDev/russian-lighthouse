<?php

namespace App\Filament\Resources\Fundraisings\Schemas;

use App\Enums\FundraisingStatus;
use App\Filament\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FundraisingForm
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
                            ->columnSpanFull(),
                        Textarea::make('lead')
                            ->label('Лид')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('status')
                            ->label('Статус')
                            ->options(EnumOptions::from(FundraisingStatus::class))
                            ->required(),
                        TextInput::make('goal_amount')
                            ->label('Цель')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('current_amount')
                            ->label('Собрано')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->seconds(false),
                        Toggle::make('is_featured_home')
                            ->label('На главной')
                            ->inline(false),
                    ]),
            ]);
    }
}
