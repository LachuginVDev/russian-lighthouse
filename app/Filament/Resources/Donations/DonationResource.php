<?php

namespace App\Filament\Resources\Donations;

use App\Filament\Resources\Donations\Pages\ListDonations;
use App\Filament\Resources\Donations\Tables\DonationsTable;
use App\Models\Donation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationLabel = 'Пожертвования';

    protected static ?string $modelLabel = 'пожертвование';

    protected static ?string $pluralModelLabel = 'пожертвования';

    protected static string|UnitEnum|BackedEnum|null $navigationGroup = 'Контент';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static bool $shouldRegisterNavigation = true;

    public static function table(Table $table): Table
    {
        return DonationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDonations::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
