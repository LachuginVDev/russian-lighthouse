<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Database\Seeders\DemoContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageReceived;
use Tests\TestCase;

class StageCApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DemoContentSeeder::class);
    }

    public function test_home_and_settings_endpoints(): void
    {
        $this->getJson('/api/v1/home')->assertOk()->assertJsonStructure(['data' => ['settings', 'albums', 'news']]);
        $this->getJson('/api/v1/settings')->assertOk()->assertJsonPath('data.is_development_mode', true);
        $this->getJson('/api/v1/albums')->assertOk()->assertJsonStructure(['data', 'meta', 'links']);
        $this->getJson('/api/v1/albums/svet-s-peredovoy')->assertOk()->assertJsonPath('data.slug', 'svet-s-peredovoy');
        $this->getJson('/api/v1/news')->assertOk();
        $this->getJson('/api/v1/partners')->assertOk();
        $this->getJson('/api/v1/fundraisings/current')->assertOk();
    }

    public function test_contact_stores_message_and_queues_mail(): void
    {
        Mail::fake();

        SiteSetting::current()->update(['email' => 'inbox@example.test']);

        $this->postJson('/api/v1/contact', [
            'name' => 'Иван',
            'email' => 'ivan@example.test',
            'message' => 'Здравствуйте, хочу помочь проекту.',
            'consent' => true,
        ])
            ->assertCreated()
            ->assertJsonPath('data.message', fn ($value) => is_string($value) && $value !== '');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'ivan@example.test',
            'name' => 'Иван',
        ]);

        Mail::assertQueued(ContactMessageReceived::class);
        $this->assertSame(1, ContactMessage::query()->count());
    }

    public function test_contact_validation(): void
    {
        $this->postJson('/api/v1/contact', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'message', 'consent']);
    }
}
