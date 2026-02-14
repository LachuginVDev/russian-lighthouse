<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\CreateMediaItem;
use App\Filament\Resources\Media\Pages\EditMediaItem;
use App\Filament\Resources\Media\Pages\ListMediaItems;
use App\Filament\Resources\Media\Schemas\MediaItemForm;
use App\Filament\Resources\Media\Tables\MediaItemsTable;
use App\Models\MediaItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class MediaItemResource extends Resource
{
    protected static ?string $model = MediaItem::class;

    protected static ?string $navigationLabel = 'Элементы медиа';

    protected static ?string $modelLabel = 'элемент';

    protected static ?string $pluralModelLabel = 'элементы медиа';

    protected static string|UnitEnum|BackedEnum|null $navigationGroup = 'Контент';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFilm;

    public static function form(Schema $schema): Schema
    {
        return MediaItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MediaItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMediaItems::route('/'),
            'create' => CreateMediaItem::route('/create'),
            'edit' => EditMediaItem::route('/{record}/edit'),
        ];
    }
}
