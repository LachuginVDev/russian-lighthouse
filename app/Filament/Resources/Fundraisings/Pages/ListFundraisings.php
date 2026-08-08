<?php

namespace App\Filament\Resources\Fundraisings\Pages;

use App\Filament\Resources\Fundraisings\FundraisingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundraisings extends ListRecords
{
    protected static string $resource = FundraisingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
