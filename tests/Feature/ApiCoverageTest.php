<?php

namespace Tests\Feature;

use App\Enums\NewsCategory;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiCoverageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DemoContentSeeder::class);
    }

    public function test_all_read_endpoints_return_ok(): void
    {
        $this->getJson('/api/v1/videos')->assertOk();
        $this->getJson('/api/v1/photo-reports')->assertOk();
        $this->getJson('/api/v1/photo-reports/gumanitarnyy-konvoy')->assertOk()
            ->assertJsonPath('data.slug', 'gumanitarnyy-konvoy');
        $this->getJson('/api/v1/news/gospital-rostov')->assertOk();
        $this->getJson('/api/v1/concerts/svet-dlya-geroev')->assertOk();
        $this->getJson('/api/v1/albums/svet-s-peredovoy/tracks')->assertOk()
            ->assertJsonStructure(['data']);
    }

    public function test_albums_can_be_filtered_by_year(): void
    {
        $this->getJson('/api/v1/albums?year=2025')
            ->assertOk()
            ->assertJsonPath('data.0.year', 2025);

        $this->getJson('/api/v1/albums?year=1999')
            ->assertOk()
            ->assertJsonPath('data', []);
    }

    public function test_concerts_can_be_filtered_by_status(): void
    {
        $upcoming = $this->getJson('/api/v1/concerts?status=upcoming')->assertOk();
        $this->assertNotEmpty($upcoming->json('data'));
        $this->assertSame('upcoming', $upcoming->json('data.0.status'));

        $past = $this->getJson('/api/v1/concerts?status=past')->assertOk();
        $this->assertNotEmpty($past->json('data'));
        $this->assertSame('past', $past->json('data.0.status'));
    }

    public function test_news_can_be_filtered_by_category(): void
    {
        $categories = collect(
            $this->getJson('/api/v1/news?category='.NewsCategory::Trips->value)
                ->assertOk()
                ->json('data')
        )->pluck('category');

        $this->assertNotEmpty($categories);
        $this->assertTrue($categories->every(fn ($category) => $category === NewsCategory::Trips->value));
    }

    public function test_home_api_only_includes_featured_albums(): void
    {
        $response = $this->getJson('/api/v1/home')->assertOk();

        $slugs = collect($response->json('data.albums'))->pluck('slug');

        $this->assertTrue($slugs->contains('svet-s-peredovoy'));
        $this->assertArrayHasKey('about', $response->json('data.settings'));
    }
}
