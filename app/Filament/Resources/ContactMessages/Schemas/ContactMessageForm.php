<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use App\Enums\ContactMessageStatus;
use App\Filament\Support\EnumOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Обращение')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Имя')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('ip')
                            ->label('IP')
                            ->disabled()
                            ->dehydrated(false),
                        Toggle::make('consent')
                            ->label('Согласие')
                            ->disabled()
                            ->dehydrated(false)
                            ->inline(false),
                        Textarea::make('message')
                            ->label('Сообщение')
                            ->rows(6)
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull(),
                        Select::make('status')
                            ->label('Статус')
                            ->options(EnumOptions::from(ContactMessageStatus::class))
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
