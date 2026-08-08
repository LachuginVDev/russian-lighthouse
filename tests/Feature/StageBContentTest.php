<?php

namespace Tests\Feature;

use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StageBContentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DemoContentSeeder::class);
    }

    public function test_listings_and_details_return_ok(): void
    {
        $this->get('/')->assertOk();
        $this->get('/albums')->assertOk()->assertSee('Свет с передовой');
        $this->get('/albums/svet-s-peredovoy')->assertOk()->assertSee('Свет');
        $this->get('/news')->assertOk()->assertSee('Новая поездка в госпиталь Ростова');
        $this->get('/news/gospital-rostov')->assertOk();
        $this->get('/photos/gumanitarnyy-konvoy')->assertOk();
        $this->get('/concerts/svet-dlya-geroev')->assertOk();
        $this->get('/privacy')->assertOk();
        $this->get('/reports')->assertOk();
        $this->get('/video')->assertOk();
    }

}
