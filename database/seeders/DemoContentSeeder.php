<?php

namespace Database\Seeders;

use App\Enums\AlbumStatus;
use App\Enums\AlbumType;
use App\Enums\ConcertBadgeType;
use App\Enums\ConcertStatus;
use App\Enums\FundraisingStatus;
use App\Enums\NewsCategory;
use App\Enums\PhotoReportCategory;
use App\Enums\VideoCategory;
use App\Models\Album;
use App\Models\Concert;
use App\Models\Fundraising;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Photo;
use App\Models\PhotoReport;
use App\Models\Report;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\Track;
use App\Models\Video;
use Illuminate\Database\Seeder;

/**
 * Мок-данные из утверждённой вёрстки — только для local/testing.
 * Не вызывается в production.
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command?->warn('DemoContentSeeder пропущен: production.');

            return;
        }

        SiteSetting::query()->updateOrCreate(['id' => 1], [
            'phone' => '+7 (900) 000-00-00',
            'email' => 'hello@russkiy-mayak.ru',
            'address' => 'Россия',
            'vk_url' => 'https://vk.com/russkiy_mayak',
            'telegram_url' => 'https://t.me/russkiy_mayak',
            'youtube_url' => 'https://youtube.com/@russkiy_mayak',
            'hero_eyebrow' => 'Музыка. Память. Единство.',
            'hero_title' => 'Русский Маяк',
            'hero_subtitle' => 'Мы пишем песни о силе духа и едем туда, где эта сила нужна больше всего — в госпитали и в зону проведения СВО.',
            'about_eyebrow' => 'О группе',
            'about_title' => 'История, рождённая в поездках к тем, кто защищает страну',
            'about_lead' => '«Русский Маяк» начинался как небольшой музыкальный проект друзей — но после первой поездки с концертом в военный госпиталь всё изменилось.',
            'about_body' => 'Сегодня группа сочетает концертную деятельность с постоянной волонтёрской работой: мы ездим в зону СВО, выступаем перед военнослужащими, помогаем госпиталям и организуем благотворительные сборы.',
            'stat_years' => 9,
            'stat_concerts' => 128,
            'stat_trips' => 46,
            'card_number' => '2200 0000 0000 0000',
            'recipient' => 'Иванов Иван Иванович',
            'inn' => '000000000000',
            'bank_account' => '40817810000000000000',
            'bik' => '044525225',
        ]);

        $albumComing = Album::query()->updateOrCreate(
            ['slug' => 'vozvrashchenie'],
            [
                'title' => 'Возвращение',
                'year' => 2026,
                'type' => AlbumType::Album,
                'status' => AlbumStatus::ComingSoon,
                'excerpt' => 'Новая работа группы о тех, кто ждёт дома, и о тех, кто обязательно вернётся.',
                'badge_label' => 'Скоро',
                'is_featured_home' => true,
                'published_at' => now()->subDay(),
                'sort_order' => 1,
            ],
        );

        $albumMain = Album::query()->updateOrCreate(
            ['slug' => 'svet-s-peredovoy'],
            [
                'title' => 'Свет с передовой',
                'year' => 2025,
                'type' => AlbumType::Album,
                'status' => AlbumStatus::Published,
                'excerpt' => 'Восемь песен, записанных после серии поездок к бойцам — о надежде, доме и возвращении.',
                'description' => '<p>Альбом вырос из историй, услышанных в госпиталях и у блиндажей.</p>',
                'genre' => 'Патриотическая музыка',
                'duration_label' => '≈ 32 минуты',
                'vk_url' => 'https://vk.com/russkiy_mayak',
                'youtube_music_url' => 'https://youtube.com/@russkiy_mayak',
                'badge_label' => 'Новый альбом',
                'is_featured_home' => true,
                'published_at' => now()->subMonths(2),
                'sort_order' => 2,
                'meta_title' => 'Альбом «Свет с передовой» — Русский Маяк',
                'meta_description' => '«Свет с передовой» — альбом группы «Русский Маяк», записанный после поездок в госпитали и зону СВО.',
            ],
        );

        Album::query()->updateOrCreate(
            ['slug' => 'pozyvnoy-nadezhda'],
            [
                'title' => 'Позывной Надежда',
                'year' => 2023,
                'type' => AlbumType::Album,
                'status' => AlbumStatus::Published,
                'excerpt' => 'Песни о доме, письмах и людях, которые ждут.',
                'is_featured_home' => true,
                'published_at' => now()->subYears(2),
                'sort_order' => 3,
            ],
        );

        $tracks = [
            ['title' => 'Свет', 'duration' => '3:42', 'position' => 1, 'featured' => true],
            ['title' => 'Позывной Надежда', 'duration' => '4:05', 'position' => 2, 'featured' => true],
            ['title' => 'Дорога домой', 'duration' => '3:58', 'position' => 3, 'featured' => true],
            ['title' => 'Письмо', 'duration' => '4:12', 'position' => 4, 'featured' => false],
        ];

        foreach ($tracks as $track) {
            Track::query()->updateOrCreate(
                [
                    'album_id' => $albumMain->id,
                    'title' => $track['title'],
                ],
                [
                    'artist' => 'Русский Маяк',
                    'duration' => $track['duration'],
                    'audio_path' => '/audio/demo-silence.mp3',
                    'position' => $track['position'],
                    'is_featured_home' => $track['featured'],
                ],
            );
        }

        unset($albumComing);

        Video::query()->updateOrCreate(
            ['slug' => 'koncert-gospital'],
            [
                'title' => 'Концерт в госпитале',
                'category' => VideoCategory::Trips,
                'type_label' => 'Документальный',
                'duration_label' => '6:24',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_featured_home' => true,
                'published_at' => now()->subDays(10),
                'sort_order' => 1,
            ],
        );

        Video::query()->updateOrCreate(
            ['slug' => 'svet-clip'],
            [
                'title' => 'Клип «Свет»',
                'category' => VideoCategory::Concerts,
                'type_label' => 'Клип',
                'duration_label' => '3:42',
                'embed_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_featured_home' => true,
                'published_at' => now()->subDays(20),
                'sort_order' => 2,
            ],
        );

        $report = PhotoReport::query()->updateOrCreate(
            ['slug' => 'gumanitarnyy-konvoy'],
            [
                'title' => 'Гуманитарный конвой',
                'excerpt' => 'Фоторепортаж о поездке с гуманитарным грузом и концертами.',
                'lead' => 'Несколько дней пути, встречи с бойцами и минуты тишины после песен.',
                'category' => PhotoReportCategory::Trips,
                'report_date' => now()->subMonths(1)->toDateString(),
                'is_featured_home' => true,
                'published_at' => now()->subMonths(1),
                'sort_order' => 1,
                'meta_title' => 'Гуманитарный конвой — фоторепортаж',
            ],
        );

        foreach (range(1, 6) as $i) {
            Photo::query()->updateOrCreate(
                [
                    'photo_report_id' => $report->id,
                    'position' => $i,
                ],
                [
                    'alt' => "Кадр {$i} репортажа «Гуманитарный конвой»",
                    'caption' => "Кадр {$i}",
                    'is_featured_home' => $i <= 3,
                ],
            );
        }

        $tagHospital = Tag::query()->updateOrCreate(
            ['slug' => 'gospital'],
            ['name' => 'Госпиталь'],
        );
        $tagTrip = Tag::query()->updateOrCreate(
            ['slug' => 'poezdka'],
            ['name' => 'Поездка'],
        );

        $news = News::query()->updateOrCreate(
            ['slug' => 'gospital-rostov'],
            [
                'title' => 'Новая поездка в госпиталь Ростова',
                'excerpt' => 'Отчёт о поездке группы «Русский Маяк» в военный госпиталь Ростова: концерт для бойцов, передача медицинского оборудования и разговоры о том, что помогает восстанавливаться.',
                'category' => NewsCategory::Trips,
                'body' => <<<'HTML'
<h2 id="nachalo">Как всё начиналось</h2>
<p>В начале июля группа «Русский Маяк» вновь отправилась в Ростов-на-Дону — на этот раз в военный госпиталь, где проходят реабилитацию бойцы после ранений. Это уже седьмая подобная поездка коллектива в этом году: концерты в госпиталях стали такой же частью работы группы, как студийные записи и большие сцены.</p>
<blockquote>«Когда играешь в палате, а не в зале на десять тысяч человек, музыка звучит иначе — честнее. Здесь нет места для показухи», — поделился лидер группы после концерта.</blockquote>
<figure class="article__figure">
  <div class="article__figure-media" aria-hidden="true"></div>
  <figcaption class="article__figure-caption">Концерт в холле госпиталя собрал более 40 бойцов и медицинского персонала.</figcaption>
</figure>
<h2 id="chto-privezli">Что мы привезли</h2>
<p>Помимо концертной программы, группа передала госпиталю партию медицинского оборудования для реабилитации, приобретённого на средства благотворительного сбора.</p>
<ul>
  <li>3 тренажёра для восстановления мелкой моторики</li>
  <li>Комплект расходных материалов для физиотерапевтического кабинета</li>
  <li>Партия аудиоустройств для палат долгосрочного лечения</li>
</ul>
<h2 id="koncert">Запись концерта</h2>
<p>Один из моментов концерта — акустическое исполнение песни «Позывной Надежда» — мы записали и публикуем здесь: именно эту версию бойцы попросили сыграть на бис.</p>
<!-- embedded-player -->
<h2 id="chto-dalshe">Что дальше</h2>
<p>Следующая поездка запланирована на конец августа. Поддержать закупку оборудования можно через <a href="/#fundraising">действующий благотворительный сбор</a>.</p>
HTML,
                'author_name' => 'Дарья Соколова',
                'author_role' => 'Автор новостей',
                'author_initials' => 'ДС',
                'reading_time' => '4 минуты',
                'embedded_track_id' => Track::query()->where('title', 'Позывной Надежда')->value('id')
                    ?: Track::query()->where('title', 'Свет')->value('id'),
                'is_featured_home' => true,
                'published_at' => now()->subDays(5),
                'sort_order' => 1,
                'meta_title' => 'Новая поездка в госпиталь Ростова — новости «Русского Маяка»',
                'meta_description' => 'Отчёт о поездке группы «Русский Маяк» в военный госпиталь Ростова.',
            ],
        );
        $news->tags()->sync([$tagHospital->id, $tagTrip->id]);

        News::query()->updateOrCreate(
            ['slug' => 'reliz-svet'],
            [
                'title' => 'Релиз альбома «Свет с передовой»',
                'excerpt' => 'Альбом доступен на площадках — часть средств направим в текущий сбор.',
                'category' => NewsCategory::Releases,
                'body' => '<p>Слушайте альбом и поддержите сбор.</p>',
                'author_name' => 'Редакция',
                'author_role' => 'Пресс-служба',
                'author_initials' => 'РМ',
                'reading_time' => '2 мин',
                'is_featured_home' => true,
                'published_at' => now()->subDays(15),
                'sort_order' => 2,
            ],
        );

        $fundraising = Fundraising::query()->updateOrCreate(
            ['title' => 'Сбор на оборудование для госпиталя'],
            [
                'lead' => 'Собираем средства на медтехнику и расходные материалы.',
                'status' => FundraisingStatus::Open,
                'goal_amount' => 1500000,
                'current_amount' => 870000,
                'is_featured_home' => true,
                'published_at' => now()->subMonths(1),
            ],
        );

        Concert::query()->updateOrCreate(
            ['slug' => 'svet-dlya-geroev'],
            [
                'title' => 'Свет для героев',
                'starts_at' => now()->addWeeks(3)->setTime(19, 0),
                'venue' => 'ДК «Победа»',
                'city' => 'Ростов-на-Дону',
                'address' => 'ул. Примерная, 1',
                'badge_type' => ConcertBadgeType::Charity,
                'status' => ConcertStatus::Upcoming,
                'ticket_status_label' => 'Билеты в продаже',
                'ticket_url' => '#',
                'excerpt' => 'Благотворительный концерт в поддержку текущего сбора.',
                'body' => '<p>Вечер песен и встреч. Часть средств — в открытый сбор.</p>',
                'fundraising_id' => $fundraising->id,
                'is_featured_home' => true,
                'published_at' => now()->subDay(),
                'sort_order' => 1,
                'meta_title' => 'Концерт «Свет для героев»',
            ],
        );

        Concert::query()->updateOrCreate(
            ['slug' => 'akustika-2024'],
            [
                'title' => 'Акустика в госпитале',
                'starts_at' => now()->subMonths(4)->setTime(15, 0),
                'venue' => 'Госпиталь',
                'city' => 'Ростов-на-Дону',
                'badge_type' => ConcertBadgeType::Acoustic,
                'status' => ConcertStatus::Past,
                'excerpt' => 'Закрытый акустический сет для бойцов.',
                'is_featured_home' => false,
                'published_at' => now()->subMonths(4),
                'sort_order' => 2,
            ],
        );

        foreach (['Фонд помощи', 'Волонтёры Юга', 'Медиапартнёр', 'Культурный центр'] as $i => $name) {
            Partner::query()->updateOrCreate(
                ['name' => $name],
                [
                    'url' => '#',
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ],
            );
        }

        Page::query()->updateOrCreate(
            ['slug' => 'privacy'],
            [
                'title' => 'Политика конфиденциальности',
                'body' => '<p>Настоящая политика описывает порядок обработки персональных данных на сайте группы «Русский Маяк».</p><p>Оставляя заявку через форму, вы соглашаетесь на обработку указанных данных для ответа на обращение.</p>',
                'meta_title' => 'Политика конфиденциальности — Русский Маяк',
                'published_at' => now()->subYear(),
            ],
        );

        Page::query()->updateOrCreate(
            ['slug' => 'reports'],
            [
                'title' => 'Отчёты о помощи',
                'body' => '<p>Публикуем отчёты по завершённым сборам и поездкам.</p>',
                'meta_title' => 'Отчёты о помощи — Русский Маяк',
                'published_at' => now()->subYear(),
            ],
        );

        Report::query()->updateOrCreate(
            ['slug' => 'otchet-2025-q1'],
            [
                'title' => 'Отчёт за I квартал 2025',
                'body' => '<p>Закуплены расходные материалы и переданы в госпиталь. Спасибо всем, кто поддержал сбор.</p>',
                'fundraising_id' => $fundraising->id,
                'published_at' => now()->subMonths(3),
            ],
        );
    }
}
