<?php

namespace App\Filament\Pages;

use App\Models\PageSeo;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Panel;
use UnitEnum;

class PageSeoSettings extends Page
{
    use CanUseDatabaseTransactions;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-language';

    protected static ?string $navigationLabel = 'SEO страниц';

    protected static ?string $title = 'SEO страниц';

    protected static string|UnitEnum|null $navigationGroup = 'Контент';

    public ?array $data = [];

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $slugs = [
            PageSeo::SLUG_HOME,
            PageSeo::SLUG_ABOUT,
            PageSeo::SLUG_FUNDRAISERS,
            PageSeo::SLUG_MEDIA,
            PageSeo::SLUG_CONTACTS,
        ];
        $seo = PageSeo::query()->whereIn('page_slug', $slugs)->get()->keyBy('page_slug');
        $this->data = [];
        foreach ($slugs as $slug) {
            $row = $seo->get($slug);
            $this->data[$slug] = [
                'meta_title' => $row?->meta_title,
                'meta_description' => $row?->meta_description,
                'og_image' => $row?->og_image,
            ];
        }
    }

    public function save(): void
    {
        try {
            $this->beginDatabaseTransaction();
            $data = $this->form->getState();
            $labels = [
                PageSeo::SLUG_HOME => 'Главная',
                PageSeo::SLUG_ABOUT => 'О группе',
                PageSeo::SLUG_FUNDRAISERS => 'Сборы',
                PageSeo::SLUG_MEDIA => 'Медиа',
                PageSeo::SLUG_CONTACTS => 'Контакты',
            ];
            foreach ($data as $slug => $row) {
                if (! is_array($row)) {
                    continue;
                }
                PageSeo::query()->updateOrCreate(
                    ['page_slug' => $slug],
                    [
                        'meta_title' => $row['meta_title'] ?? null,
                        'meta_description' => $row['meta_description'] ?? null,
                        'og_image' => $row['og_image'] ?? null,
                    ]
                );
            }
            \Illuminate\Support\Facades\Cache::flush();
            $this->commitDatabaseTransaction();
            Notification::make()->title('SEO сохранено')->success()->send();
        } catch (\Throwable $e) {
            $this->rollBackDatabaseTransaction();
            throw $e;
        }
    }

    public function form(Schema $schema): Schema
    {
        $slugLabels = [
            PageSeo::SLUG_HOME => 'Главная',
            PageSeo::SLUG_ABOUT => 'О группе',
            PageSeo::SLUG_FUNDRAISERS => 'Сборы',
            PageSeo::SLUG_MEDIA => 'Медиа',
            PageSeo::SLUG_CONTACTS => 'Контакты',
        ];
        $sections = [];
        foreach ($slugLabels as $slug => $label) {
            $sections[] = Section::make($label)
                ->schema([
                    TextInput::make("{$slug}.meta_title")
                        ->label('Meta заголовок')
                        ->maxLength(255),
                    TextInput::make("{$slug}.meta_description")
                        ->label('Meta описание')
                        ->maxLength(500)
                        ->columnSpanFull(),
                    FileUpload::make("{$slug}.og_image")
                        ->label('Изображение для превью (OpenGraph)')
                        ->image()
                        ->disk('public')
                        ->directory('seo')
                        ->nullable(),
                ])
                ->columns(2)
                ->collapsible();
        }

        return $schema
            ->statePath('data')
            ->components($sections);
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

    public static function getSlug(?Panel $panel = null): string
    {
        return 'page-seo-settings';
    }
}