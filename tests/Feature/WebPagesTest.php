<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_listings_are_ok_without_demo_content(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')->assertOk()
            ->assertDontSee('админке', false)
            ->assertDontSee('Загрузите QR', false);

        $this->get('/albums')->assertOk();
        $this->get('/video')->assertOk();
        $this->get('/photos')->assertOk();
        $this->get('/news')->assertOk();
        $this->get('/concerts')->assertOk();
        $this->get('/reports')->assertOk();
        $this->get('/privacy')->assertOk()
            ->assertSee('Политика конфиденциальности', false);
        $this->get('/up')->assertOk();
    }

    public function test_detail_pages_render_seeded_content(): void
    {
        $this->seed(DemoContentSeeder::class);

        $this->get('/albums/svet-s-peredovoy')->assertOk()->assertSee('Свет с передовой', false);
        $this->get('/photos/gumanitarnyy-konvoy')->assertOk();
        $this->get('/news/gospital-rostov')->assertOk();
        $this->get('/concerts/svet-dlya-geroev')->assertOk();
        $this->get('/video')->assertOk();
    }

    public function test_unknown_page_returns_branded_404(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/not-a-page')
            ->assertNotFound()
            ->assertSee('Страница не найдена', false);
    }

    public function test_legacy_html_redirects(): void
    {
        $this->get('/privacy.html')->assertRedirect('/privacy');
        $this->get('/reports.html')->assertRedirect('/reports');
        $this->get('/index.html')->assertRedirect('/');
    }
}
