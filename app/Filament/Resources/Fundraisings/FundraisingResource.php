<?php

namespace App\Filament\Resources\Fundraisings;

use App\Filament\Resources\Fundraisings\Pages\CreateFundraising;
use App\Filament\Resources\Fundraisings\Pages\EditFundraising;
use App\Filament\Resources\Fundraisings\Pages\ListFundraisings;
use App\Filament\Resources\Fundraisings\Schemas\FundraisingForm;
use App\Filament\Resources\Fundraisings\Tables\FundraisingsTable;
use App\Models\Fundraising;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FundraisingResource extends Resource
{
    protected static ?string $model = Fundraising::class;

    protected static ?string $navigationLabel = 'Сборы';

    protected static ?string $modelLabel = 'сбор';

    protected static ?string $pluralModelLabel = 'сборы';

    protected static string|UnitEnum|null $navigationGroup = 'Помощь';

    protected static ?int $navigationSort = 50;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FundraisingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FundraisingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFundraisings::route('/'),
            'create' => CreateFundraising::route('/create'),
            'edit' => EditFundraising::route('/{record}/edit'),
        ];
    }
}
