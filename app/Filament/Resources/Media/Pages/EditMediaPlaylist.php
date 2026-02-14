<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaPlaylistResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMediaPlaylist extends EditRecord
{
    protected static string $resource = MediaPlaylistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
