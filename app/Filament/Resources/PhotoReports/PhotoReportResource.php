<?php

namespace App\Filament\Resources\PhotoReports;

use App\Filament\Resources\PhotoReports\Pages\CreatePhotoReport;
use App\Filament\Resources\PhotoReports\Pages\EditPhotoReport;
use App\Filament\Resources\PhotoReports\Pages\ListPhotoReports;
use App\Filament\Resources\PhotoReports\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\PhotoReports\Schemas\PhotoReportForm;
use App\Filament\Resources\PhotoReports\Tables\PhotoReportsTable;
use App\Models\PhotoReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PhotoReportResource extends Resource
{
    protected static ?string $model = PhotoReport::class;

    protected static ?string $navigationLabel = 'Фоторепортажи';

    protected static ?string $modelLabel = 'фоторепортаж';

    protected static ?string $pluralModelLabel = 'фоторепортажи';

    protected static string|UnitEnum|null $navigationGroup = 'Медиа';

    protected static ?int $navigationSort = 21;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PhotoReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PhotoReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PhotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPhotoReports::route('/'),
            'create' => CreatePhotoReport::route('/create'),
            'edit' => EditPhotoReport::route('/{record}/edit'),
        ];
    }
}
