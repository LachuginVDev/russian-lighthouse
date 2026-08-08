<?php

namespace App\Filament\Resources\Fundraisings\Tables;

use App\Enums\FundraisingStatus;
use App\Filament\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FundraisingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->formatStateUsing(fn (?FundraisingStatus $state): ?string => $state?->label()),
                TextColumn::make('current_amount')
                    ->label('Собрано')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goal_amount')
                    ->label('Цель')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_featured_home')
                    ->label('Главная')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Публикация')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(EnumOptions::from(FundraisingStatus::class)),
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
