<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin(): void
    {
        $this->get('/admin')->assertRedirect();
        $this->get('/admin/login')->assertOk();
    }

    public function test_admin_can_open_panel(): void
    {
        $this->seed(AdminUserSeeder::class);

        $user = User::query()->where('email', 'admin@russkiy-mayak.test')->firstOrFail();

        $this->actingAs($user)->get('/admin')->assertOk();
    }
}
