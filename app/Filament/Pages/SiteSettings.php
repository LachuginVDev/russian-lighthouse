<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    protected static ?string $slug = 'site-settings';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?string $title = 'Настройки сайта';

    protected static string|UnitEnum|null $navigationGroup = 'Сайт';

    protected static ?int $navigationSort = 90;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->getRecord()->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('settings')
                    ->tabs([
                        Tab::make('Контакты')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('phone')
                                            ->label('Телефон')
                                            ->maxLength(255),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->maxLength(255),
                                        Textarea::make('address')
                                            ->label('Адрес')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                        TextInput::make('vk_url')
                                            ->label('VK')
                                            ->url()
                                            ->maxLength(255),
                                        TextInput::make('telegram_url')
                                            ->label('Telegram')
                                            ->url()
                                            ->maxLength(255),
                                        TextInput::make('youtube_url')
                                            ->label('YouTube')
                                            ->url()
                                            ->maxLength(255),
                                    ]),
                            ]),
                        Tab::make('Главная')
                            ->schema([
                                Section::make('Hero')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('hero_eyebrow')
                                            ->label('Надзаголовок')
                                            ->maxLength(255),
                                        TextInput::make('hero_title')
                                            ->label('Заголовок')
                                            ->maxLength(255),
                                        Textarea::make('hero_subtitle')
                                            ->label('Подзаголовок')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('О проекте')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('about_eyebrow')
                                            ->label('Надзаголовок')
                                            ->maxLength(255),
                                        TextInput::make('about_title')
                                            ->label('Заголовок')
                                            ->maxLength(255),
                                        Textarea::make('about_lead')
                                            ->label('Лид')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('about_body')
                                            ->label('Текст')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Статистика')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('stat_years')
                                            ->label('Лет')
                                            ->maxLength(255),
                                        TextInput::make('stat_concerts')
                                            ->label('Концертов')
                                            ->maxLength(255),
                                        TextInput::make('stat_trips')
                                            ->label('Поездок')
                                            ->maxLength(255),
                                    ]),
                            ]),
                        Tab::make('Реквизиты')
                            ->schema([
                                Section::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('card_number')
                                            ->label('Номер карты')
                                            ->maxLength(255),
                                        TextInput::make('recipient')
                                            ->label('Получатель')
                                            ->maxLength(255),
                                        TextInput::make('inn')
                                            ->label('ИНН')
                                            ->maxLength(255),
                                        TextInput::make('bank_account')
                                            ->label('Расчётный счёт')
                                            ->maxLength(255),
                                        TextInput::make('bik')
                                            ->label('БИК')
                                            ->maxLength(255),
                                        FileUpload::make('qr_image_path')
                                            ->label('QR-код')
                                            ->image()
                                            ->disk('public')
                                            ->directory('settings/qr')
                                            ->visibility('public')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('SEO / OG')
                            ->schema([
                                FileUpload::make('default_og_image')
                                    ->label('OG-изображение по умолчанию')
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings/og')
                                    ->visibility('public'),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ])
            ->statePath('data')
            ->record($this->getRecord());
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    EmbeddedSchema::make('form'),
                ])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Сохранить')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();
        $record->fill($data);
        $record->save();

        Notification::make()
            ->success()
            ->title('Настройки сохранены')
            ->send();
    }

    public function getRecord(): SiteSetting
    {
        return SiteSetting::current();
    }
}
