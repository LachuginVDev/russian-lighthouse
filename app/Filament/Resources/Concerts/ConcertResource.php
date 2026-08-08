<?php

namespace App\Filament\Resources\Concerts;

use App\Filament\Resources\Concerts\Pages\CreateConcert;
use App\Filament\Resources\Concerts\Pages\EditConcert;
use App\Filament\Resources\Concerts\Pages\ListConcerts;
use App\Filament\Resources\Concerts\Schemas\ConcertForm;
use App\Filament\Resources\Concerts\Tables\ConcertsTable;
use App\Models\Concert;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ConcertResource extends Resource
{
    protected static ?string $model = Concert::class;

    protected static ?string $navigationLabel = 'Концерты';

    protected static ?string $modelLabel = 'концерт';

    protected static ?string $pluralModelLabel = 'концерты';

    protected static string|UnitEnum|null $navigationGroup = 'Концерты';

    protected static ?int $navigationSort = 40;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ConcertForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConcertsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConcerts::route('/'),
            'create' => CreateConcert::route('/create'),
            'edit' => EditConcert::route('/{record}/edit'),
        ];
    }
}
