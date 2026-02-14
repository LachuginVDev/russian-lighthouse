<?php

namespace App\Filament\Pages;

use App\Models\HomeSetting;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use UnitEnum;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class PageSettings extends Page
{
    use CanUseDatabaseTransactions;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Настройки страниц';

    protected static ?string $title = 'Настройки страниц';

    protected static string|UnitEnum|null $navigationGroup = 'Контент';


    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $setting = HomeSetting::get();
        $this->data = [
            'hero_title' => $setting->hero_title,
            'hero_subtitle' => $setting->hero_subtitle,
            'hero_text_color' => $setting->hero_text_color ?? HomeSetting::TEXT_COLOR_WHITE,
            'logo' => $setting->logo,
        ];
    }

    public function save(): void
    {
        try {
            $this->beginDatabaseTransaction();

            $data = $this->form->getState();

            $setting = HomeSetting::get();
            $setting->hero_title = $data['hero_title'] ?? null;
            $setting->hero_subtitle = $data['hero_subtitle'] ?? null;
            $setting->hero_text_color = $data['hero_text_color'] ?? HomeSetting::TEXT_COLOR_WHITE;
            $setting->logo = $data['logo'] ?? null;
            $setting->save();

            $this->commitDatabaseTransaction();

            Notification::make()
                ->title('Настройки сохранены')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            $this->rollBackDatabaseTransaction();
            throw $e;
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Логотип сайта')
                    ->description('Отображается в шапке на всех публичных страницах.')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Логотип')
                            ->image()
                            ->disk('public')
                            ->directory('home')
                            ->maxSize(1024),
                    ])
                    ->columns(1),
                Section::make('Главная — слайдер')
                    ->description('Заголовок и подзаголовок в блоке слайдера на главной странице.')
                    ->schema([
                        TextInput::make('hero_title')
                            ->label('Заголовок (H1)')
                            ->maxLength(255)
                            ->placeholder('Russian Lighthouse'),
                        TextInput::make('hero_subtitle')
                            ->label('Подзаголовок')
                            ->maxLength(500)
                            ->placeholder('Краткое описание или слоган'),
                        Select::make('hero_text_color')
                            ->label('Цвет текста')
                            ->options([
                                HomeSetting::TEXT_COLOR_WHITE => 'Белый',
                                HomeSetting::TEXT_COLOR_BLACK => 'Чёрный',
                            ])
                            ->required(),
                    ])
                    ->columns(1),
            ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Сохранить')
                ->submit('save')
                ->keyBindings(['mod+s']),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make($this->getFormActions())
                            ->alignment(\Filament\Support\Enums\Alignment::Start)
                            ->key('form-actions'),
                    ]),
            ]);
    }
}
