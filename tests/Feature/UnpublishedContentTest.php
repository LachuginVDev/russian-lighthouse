<?php

namespace Tests\Feature;

use App\Enums\AlbumStatus;
use App\Enums\AlbumType;
use App\Enums\ConcertBadgeType;
use App\Enums\ConcertStatus;
use App\Enums\NewsCategory;
use App\Enums\PhotoReportCategory;
use App\Enums\VideoCategory;
use App\Models\Album;
use App\Models\Concert;
use App\Models\News;
use App\Models\PhotoReport;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnpublishedContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_unpublished_and_draft_records_are_hidden(): void
    {
        News::query()->create([
            'slug' => 'draft-news',
            'title' => 'Черновик новости',
            'category' => NewsCategory::Trips,
            'body' => '<p>Скрыто</p>',
            'published_at' => null,
        ]);

        $liveNews = News::query()->create([
            'slug' => 'live-news',
            'title' => 'Опубликованная новость',
            'category' => NewsCategory::Trips,
            'body' => '<p>Видно</p>',
            'published_at' => now()->subHour(),
        ]);

        Album::query()->create([
            'slug' => 'draft-album',
            'title' => 'Черновик альбома',
            'type' => AlbumType::Album,
            'status' => AlbumStatus::Draft,
            'published_at' => now(),
        ]);

        Album::query()->create([
            'slug' => 'live-album',
            'title' => 'Боевой альбом',
            'type' => AlbumType::Album,
            'status' => AlbumStatus::Published,
            'published_at' => now()->subDay(),
        ]);

        Album::query()->create([
            'slug' => 'soon-album',
            'title' => 'Скоро выйдет',
            'type' => AlbumType::Album,
            'status' => AlbumStatus::ComingSoon,
            'published_at' => now()->subDay(),
        ]);

        Concert::query()->create([
            'slug' => 'hidden-concert',
            'title' => 'Скрытый концерт',
            'starts_at' => now()->addWeek(),
            'badge_type' => ConcertBadgeType::Other,
            'status' => ConcertStatus::Upcoming,
            'published_at' => null,
        ]);

        Video::query()->create([
            'slug' => 'hidden-video',
            'title' => 'Скрытое видео',
            'category' => VideoCategory::Concerts,
            'embed_url' => 'https://www.youtube.com/embed/test',
            'published_at' => now()->addDay(),
        ]);

        PhotoReport::query()->create([
            'slug' => 'hidden-photos',
            'title' => 'Скрытый репортаж',
            'category' => PhotoReportCategory::Trips,
            'published_at' => null,
        ]);

        $this->get('/news/draft-news')->assertNotFound();
        $this->getJson('/api/v1/news/draft-news')->assertNotFound();
        $this->get('/news/'.$liveNews->slug)->assertOk()->assertSee('Опубликованная новость', false);

        $this->get('/albums/draft-album')->assertNotFound();
        $this->getJson('/api/v1/albums/draft-album')->assertNotFound();
        $this->get('/albums/live-album')->assertOk();
        $this->get('/albums/soon-album')->assertOk()->assertSee('Скоро выйдет', false);

        $this->get('/concerts/hidden-concert')->assertNotFound();
        $this->get('/photos/hidden-photos')->assertNotFound();
        $this->get('/video')->assertOk()->assertDontSee('Скрытое видео', false);
    }
}
