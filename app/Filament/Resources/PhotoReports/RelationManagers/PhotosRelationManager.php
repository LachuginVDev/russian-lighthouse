<?php

namespace App\Filament\Resources\PhotoReports\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
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
                FileUpload::make('image_path')
                    ->label('Фото')
                    ->image()
                    ->disk('public')
                    ->directory('photo-reports/photos')
                    ->visibility('public')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('alt')
                    ->label('Alt')
                    ->maxLength(255),
                Textarea::make('caption')
                    ->label('Подпись')
                    ->rows(2),
                TextInput::make('position')
                    ->label('Позиция')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_featured_home')
                    ->label('На главной')
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Фото')
                    ->disk('public'),
                TextColumn::make('caption')
                    ->label('Подпись')
                    ->limit(40),
                TextColumn::make('position')
                    ->label('#')
                    ->sortable(),
                IconColumn::make('is_featured_home')
                    ->label('Главная')
                    ->boolean(),
            ])
            ->defaultSort('position')
            ->reorderable('position')
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
