<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class StageDSeoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DemoContentSeeder::class);
        Cache::forget('seo.sitemap.xml');
    }

    public function test_development_mode_blocks_indexing(): void
    {
        SiteSetting::current()->update(['is_development_mode' => true]);

        $this->get('/')->assertOk()
            ->assertSee('noindex, nofollow', false)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');

        $this->get('/robots.txt')->assertOk()
            ->assertSee('Disallow: /', false);

        $this->get('/sitemap.xml')->assertOk()
            ->assertDontSee('<loc>', false);
    }

    public function test_production_mode_allows_indexing_and_sitemap(): void
    {
        SiteSetting::current()->update(['is_development_mode' => false]);
        Cache::forget('seo.sitemap.xml');

        $this->get('/')->assertOk()
            ->assertSee('index, follow', false)
            ->assertHeaderMissing('X-Robots-Tag');

        $this->get('/robots.txt')->assertOk()
            ->assertSee('Sitemap:', false)
            ->assertSee('Allow: /', false);

        $this->get('/sitemap.xml')->assertOk()
            ->assertSee(route('home'), false)
            ->assertSee(route('albums.show', 'svet-s-peredovoy'), false)
            ->assertSee(route('news.show', 'gospital-rostov'), false);
    }

    public function test_legacy_html_redirects_to_listings(): void
    {
        $this->get('/album.html')->assertRedirect('/albums');
        $this->get('/news-single.html')->assertRedirect('/news');
        $this->get('/concert-single.html')->assertRedirect('/concerts');
    }
}
