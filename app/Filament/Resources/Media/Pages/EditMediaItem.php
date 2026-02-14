<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMediaItem extends EditRecord
{
    protected static string $resource = MediaItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
