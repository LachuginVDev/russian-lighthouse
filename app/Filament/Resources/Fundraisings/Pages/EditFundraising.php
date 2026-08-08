<?php

namespace App\Filament\Resources\Fundraisings\Pages;

use App\Filament\Resources\Fundraisings\FundraisingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFundraising extends EditRecord
{
    protected static string $resource = FundraisingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
