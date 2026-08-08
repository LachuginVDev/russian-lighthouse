<?php

namespace App\Filament\Resources\Tracks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TracksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('artist')
                    ->label('Исполнитель')
                    ->toggleable(),
                TextColumn::make('album.title')
                    ->label('Альбом')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('duration')
                    ->label('Длительность'),
                TextColumn::make('audio_path')
                    ->label('Файл')
                    ->formatStateUsing(fn (?string $state): string => filled($state) ? 'есть' : 'нет')
                    ->badge()
                    ->color(fn (?string $state): string => filled($state) ? 'success' : 'gray'),
                IconColumn::make('is_featured_home')
                    ->label('Главная')
                    ->boolean(),
            ])
            ->defaultSort('title')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
