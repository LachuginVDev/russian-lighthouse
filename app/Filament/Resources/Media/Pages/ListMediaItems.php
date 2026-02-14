<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMediaItems extends ListRecords
{
    protected static string $resource = MediaItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
