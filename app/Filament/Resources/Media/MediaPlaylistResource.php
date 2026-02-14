<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\CreateMediaPlaylist;
use App\Filament\Resources\Media\Pages\EditMediaPlaylist;
use App\Filament\Resources\Media\Pages\ListMediaPlaylists;
use App\Filament\Resources\Media\Schemas\MediaPlaylistForm;
use App\Filament\Resources\Media\Tables\MediaPlaylistsTable;
use App\Models\MediaPlaylist;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class MediaPlaylistResource extends Resource
{
    protected static ?string $model = MediaPlaylist::class;

    protected static ?string $navigationLabel = 'Плейлисты';

    protected static ?string $modelLabel = 'плейлист';

    protected static ?string $pluralModelLabel = 'плейлисты';

    protected static string|UnitEnum|BackedEnum|null $navigationGroup = 'Контент';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    public static function form(Schema $schema): Schema
    {
        return MediaPlaylistForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MediaPlaylistsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMediaPlaylists::route('/'),
            'create' => CreateMediaPlaylist::route('/create'),
            'edit' => EditMediaPlaylist::route('/{record}/edit'),
        ];
    }
}
