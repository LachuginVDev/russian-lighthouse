<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        if (Category::query()->exists()) {
            return;
        }
        Category::query()->insert([
            ['name' => 'Новости', 'slug' => 'novosti', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Анонсы', 'slug' => 'anonsy', 'created_at' => now(), 'updated_at' => now()],
        ]);

        if (Tag::query()->exists()) {
            return;
        }
        Tag::query()->insert([
            ['name' => 'Концерт', 'slug' => 'kontsert', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Релиз', 'slug' => 'reliz', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
