<?php

declare(strict_types=1);

namespace App\Filament\Resources\PhotoAlbums\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Фотографии';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Фото')
                    ->image()
                    ->disk('public')
                    ->directory('albums/photos')
                    ->required(),
                TextInput::make('caption')
                    ->label('Подпись')
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Фото')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('caption')
                    ->label('Подпись')
                    ->limit(40)
                    ->placeholder('—'),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->authorizeReorder(true)
            ->headerActions([
                CreateAction::make()
                    ->label('Добавить фото'),
                Action::make('addMultiple')
                    ->label('Добавить несколько фото')
                    ->icon('heroicon-o-photo')
                    ->form([
                        FileUpload::make('images')
                            ->label('Фотографии')
                            ->image()
                            ->disk('public')
                            ->directory('albums/photos')
                            ->multiple()
                            ->required()
                            ->maxFiles(50)
                            ->helperText('Выберите несколько файлов. Подписи можно добавить позже через «Изменить».'),
                    ])
                    ->action(fn (array $data) => $this->addMultiplePhotos($data)),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public function addMultiplePhotos(array $data): void
    {
        $album = $this->getOwnerRecord();
        $lastOrder = (int) $album->photos()->max('sort_order');
        $paths = $data['images'] ?? [];
        if (! is_array($paths)) {
            $paths = $paths ? [$paths] : [];
        }
        $created = 0;
        foreach ($paths as $i => $path) {
            $album->photos()->create([
                'image' => $path,
                'caption' => null,
                'sort_order' => $lastOrder + $i + 1,
            ]);
            $created++;
        }
        Notification::make()
            ->title($created ? "Добавлено фото: {$created}" : 'Нет новых фото')
            ->success()
            ->send();
    }

    protected function getTableReorderColumn(): ?string
    {
        return 'sort_order';
    }
}
