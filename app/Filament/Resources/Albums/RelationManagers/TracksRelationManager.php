<?php

namespace App\Filament\Resources\Albums\RelationManagers;

use App\Filament\Support\TrackAudioUpload;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TracksRelationManager extends RelationManager
{
    protected static string $relationship = 'tracks';

    protected static ?string $title = 'Треки';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('artist')
                    ->label('Исполнитель')
                    ->maxLength(255),
                TextInput::make('duration')
                    ->label('Длительность')
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Позиция')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TrackAudioUpload::make(),
                FileUpload::make('cover_path')
                    ->label('Обложка трека')
                    ->image()
                    ->disk('public')
                    ->directory('tracks/covers')
                    ->visibility('public')
                    ->columnSpanFull(),
                Toggle::make('is_featured_home')
                    ->label('На главной')
                    ->inline(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('position')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('artist')
                    ->label('Исполнитель')
                    ->toggleable(),
                TextColumn::make('duration')
                    ->label('Длительность'),
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
