<?php

namespace App\Filament\Support;

use App\Models\Track;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

final class EmbeddedTrackSelect
{
    public static function make(string $name = 'embedded_track_id'): Select
    {
        return Select::make($name)
            ->label('Встроенный трек')
            ->relationship(
                name: 'embeddedTrack',
                titleAttribute: 'title',
                modifyQueryUsing: fn ($query) => $query->with('album')->orderBy('title'),
            )
            ->getOptionLabelFromRecordUsing(
                fn (Track $record): string => $record->album
                    ? "{$record->title} — {$record->album->title}"
                    : $record->title
            )
            ->searchable()
            ->preload()
            ->nullable()
            ->createOptionForm([
                TextInput::make('title')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                TextInput::make('artist')
                    ->label('Исполнитель')
                    ->default('Русский Маяк')
                    ->maxLength(255),
                TextInput::make('duration')
                    ->label('Длительность')
                    ->placeholder('3:42')
                    ->maxLength(255),
                TrackAudioUpload::make(),
                Toggle::make('is_featured_home')
                    ->label('На главной')
                    ->inline(false),
            ])
            ->createOptionUsing(function (array $data): int {
                return Track::query()->create([
                    'title' => $data['title'],
                    'artist' => $data['artist'] ?? 'Русский Маяк',
                    'duration' => $data['duration'] ?? null,
                    'audio_path' => $data['audio_path'] ?? null,
                    'is_featured_home' => (bool) ($data['is_featured_home'] ?? false),
                    'position' => 0,
                ])->getKey();
            })
            ->helperText('Можно выбрать существующий трек или создать новый с аудиофайлом.');
    }
}
