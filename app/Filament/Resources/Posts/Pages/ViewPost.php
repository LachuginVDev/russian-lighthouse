<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
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
            EditAction::make(),
        ];
    }
}
