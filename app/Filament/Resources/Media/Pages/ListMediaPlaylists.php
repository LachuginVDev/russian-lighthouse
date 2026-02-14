<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaPlaylistResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMediaPlaylists extends ListRecords
{
    protected static string $resource = MediaPlaylistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
