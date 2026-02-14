<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Создаёт права по ТЗ и назначает их ролям.
     * Гость: просмотр страниц, новости, сборы, пожертвования, медиа.
     * Администратор: всё выше + управление контентом, сборами, SEO, медиа, статистика пожертвований.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Просмотр страниц', 'slug' => Permission::VIEW_PAGES],
            ['name' => 'Чтение новостей', 'slug' => Permission::READ_NEWS],
            ['name' => 'Просмотр сборов', 'slug' => Permission::VIEW_FUNDRAISERS],
            ['name' => 'Совершение пожертвований', 'slug' => Permission::MAKE_DONATIONS],
            ['name' => 'Прослушивание медиа', 'slug' => Permission::LISTEN_MEDIA],
            ['name' => 'Управление контентом', 'slug' => Permission::MANAGE_CONTENT],
            ['name' => 'Управление сборами', 'slug' => Permission::MANAGE_FUNDRAISERS],
            ['name' => 'Управление SEO', 'slug' => Permission::MANAGE_SEO],
            ['name' => 'Управление медиа', 'slug' => Permission::MANAGE_MEDIA],
            ['name' => 'Просмотр статистики пожертвований', 'slug' => Permission::VIEW_DONATION_STATS],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(
                ['slug' => $p['slug']],
                ['name' => $p['name']],
            );
        }

        $userRole = Role::firstWhere('name', Role::NAME_USER);
        $adminRole = Role::firstWhere('name', Role::NAME_ADMIN);

        if ($userRole) {
            $guestSlugs = [
                Permission::VIEW_PAGES,
                Permission::READ_NEWS,
                Permission::VIEW_FUNDRAISERS,
                Permission::MAKE_DONATIONS,
                Permission::LISTEN_MEDIA,
            ];
            $userRole->permissions()->sync(
                Permission::whereIn('slug', $guestSlugs)->pluck('id'),
            );
        }

        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::pluck('id'));
        }
    }
}
