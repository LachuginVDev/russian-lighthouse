<?php

namespace App\Filament\Resources\Reports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('report')
                    ->tabs([
                        Tab::make('Контент')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Заголовок')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Set $set, ?string $state, ?string $old, Get $get): void {
                                                if (filled($get('slug')) && $get('slug') !== Str::slug((string) $old)) {
                                                    return;
                                                }

                                                $set('slug', Str::slug((string) $state));
                                            }),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true),
                                        Select::make('fundraising_id')
                                            ->label('Сбор')
                                            ->relationship('fundraising', 'title')
                                            ->searchable()
                                            ->preload(),
                                        DateTimePicker::make('published_at')
                                            ->label('Дата публикации')
                                            ->seconds(false),
                                        RichEditor::make('body')
                                            ->label('Текст')
                                            ->columnSpanFull(),
                                        FileUpload::make('file_path')
                                            ->label('Файл (PDF)')
                                            ->disk('public')
                                            ->directory('reports/files')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('SEO')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->label('Meta title')
                                    ->maxLength(255),
                                Textarea::make('meta_description')
                                    ->label('Meta description')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
