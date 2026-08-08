<?php

namespace App\Filament\Resources\Albums\Tables;

use App\Enums\AlbumStatus;
use App\Enums\AlbumType;
use App\Filament\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_path')
                    ->label('Обложка')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Год')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->formatStateUsing(fn (?AlbumType $state): ?string => $state?->label()),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (?AlbumStatus $state): ?string => $state?->label()),
                IconColumn::make('is_featured_home')
                    ->label('Главная')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Публикация')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(EnumOptions::from(AlbumStatus::class)),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(EnumOptions::from(AlbumType::class)),
            ])
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
