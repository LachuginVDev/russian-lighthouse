<?php

namespace App\Filament\Resources\Concerts\Pages;

use App\Filament\Resources\Concerts\ConcertResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConcerts extends ListRecords
{
    protected static string $resource = ConcertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
