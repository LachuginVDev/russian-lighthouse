<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_on_site')
                ->label('Просмотр на сайте')
                ->url(fn (Post $record): string => route('news.show', $record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-arrow-top-right-on-square'),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
