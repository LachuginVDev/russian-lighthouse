<?php

declare(strict_types=1);

namespace App\Filament\Resources\PhotoAlbums\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class PhotoAlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('photos'))
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Обложка')
                    ->circular()
                    ->disk('public')
                    ->getStateUsing(fn ($record) => $record->cover_image ?: $record->photos->first()?->image),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('photos_count')
                    ->label('Фото')
                    ->counts('photos'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                Action::make('view_on_site')
                    ->label('Просмотр на сайте')
                    ->url(fn ($record) => route('albums.index') . '?album=' . $record->id)
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
