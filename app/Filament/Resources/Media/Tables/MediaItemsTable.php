<?php

declare(strict_types=1);

namespace App\Filament\Resources\Media\Tables;

use App\Models\MediaItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Превью')
                    ->circular()
                    ->visible(fn ($record) => $record?->type === MediaItem::TYPE_IMAGE),
                TextColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        MediaItem::TYPE_VIDEO_URL => 'Видео (ссылка)',
                        MediaItem::TYPE_VIDEO_FILE => 'Видео (файл)',
                        MediaItem::TYPE_IMAGE => 'Изображение',
                        default => $state,
                    }),
                TextColumn::make('title')
                    ->label('Название')
                    ->limit(40),
                TextColumn::make('playlist.title')
                    ->label('Плейлист')
                    ->placeholder('—'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
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
