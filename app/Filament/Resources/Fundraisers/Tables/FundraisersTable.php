<?php

declare(strict_types=1);

namespace App\Filament\Resources\Fundraisers\Tables;

use App\Models\Fundraiser;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FundraisersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('goal')
                    ->label('Цель')
                    ->money('RUB')
                    ->sortable(),
                TextColumn::make('raised')
                    ->label('Собрано')
                    ->money('RUB')
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Активен')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Да' : 'Нет')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                Action::make('view_on_site')
                    ->label('Просмотр на сайте')
                    ->url(fn (Fundraiser $record): string => route('fundraisers.show', $record->id))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-arrow-top-right-on-square'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
