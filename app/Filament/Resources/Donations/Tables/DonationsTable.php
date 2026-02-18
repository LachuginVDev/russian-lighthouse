<?php

declare(strict_types=1);

namespace App\Filament\Resources\Donations\Tables;

use App\Models\Donation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('fundraiser.title')
                    ->label('Сбор')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable(),
                TextColumn::make('donor_name')
                    ->label('Имя')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('donor_email')
                    ->label('Email')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('is_anonymous')
                    ->label('Анонимно')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Да' : 'Нет')
                    ->color(fn (bool $state): string => $state ? 'gray' : 'success'),
                TextColumn::make('donated_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('donated_at', 'desc')
            ->filters([
                SelectFilter::make('fundraiser_id')
                    ->label('Сбор')
                    ->relationship('fundraiser', 'title')
                    ->searchable()
                    ->preload(),
                Filter::make('donated_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('donated_from')
                            ->label('Дата от'),
                        \Filament\Forms\Components\DatePicker::make('donated_until')
                            ->label('Дата до'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (! empty($data['donated_from'])) {
                            $query->whereDate('donated_at', '>=', $data['donated_from']);
                        }
                        if (! empty($data['donated_until'])) {
                            $query->whereDate('donated_at', '<=', $data['donated_until']);
                        }
                        return $query;
                    }),
            ]);
    }
}
