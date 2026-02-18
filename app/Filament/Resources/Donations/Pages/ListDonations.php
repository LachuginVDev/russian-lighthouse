<?php

namespace App\Filament\Resources\Donations\Pages;

use App\Filament\Resources\Donations\DonationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListDonations extends ListRecords
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_csv')
                ->label('Экспорт CSV')
                ->url(route('admin.export.donations'))
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-down-tray'),
        ];
    }
}
