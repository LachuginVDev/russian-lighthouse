<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignFirstAdminSeeder extends Seeder
{
    /**
     * Назначает роль администратора первому пользователю по email.
     * Запуск: php artisan db:seed --class=AssignFirstAdminSeeder
     * Или задать email: ADMIN_EMAIL=admin@example.com php artisan db:seed --class=AssignFirstAdminSeeder
     */
    public function run(): void
    {
        $adminRoleId = Role::firstWhere('name', Role::NAME_ADMIN)?->id;
        if (! $adminRoleId) {
            return;
        }

        $email = env('ADMIN_EMAIL');
        $user = $email
            ? User::firstWhere('email', $email)
            : User::orderBy('id')->first();
        if ($user) {
            $user->update(['role_id' => $adminRoleId]);
            $this->command->info("Роль администратора назначена: {$user->email}");
        }
    }
}
