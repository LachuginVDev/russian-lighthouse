<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
        ]);

        // DemoContentSeeder не вызывается автоматически — только вручную для локальных тестов:
        // php artisan db:seed --class=DemoContentSeeder
    }
}
