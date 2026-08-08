# Этап B — домен и админка

Дата: 2026-08-08  
Ветка: `feature/stage-b`

## Что сделано

1. Миграции и Eloquent-модели сущностей (альбомы, треки, видео, фоторепортажи, новости, концерты, сборы, партнёры, страницы, отчёты, обращения, настройки).
2. Filament 5 админка: `/admin` — CRUD разделов + singleton «Настройки сайта».
3. Публичные listing/detail читают данные из PostgreSQL.
4. Мок-контент **только для local/testing** (`DemoContentSeeder`). В production не вызывается.
5. Тест `tests/Feature/StageBContentTest.php` (sqlite in-memory + демо-сид).

## Админка

| URL | Доступ |
|---|---|
| http://localhost/admin | Filament |

Тестовый пользователь (мок):

- email: `admin@russkiy-mayak.test`
- password: `password`

## Мок-данные

```bash
# только local / testing
vendor/bin/sail artisan migrate --seed
# или точечно:
vendor/bin/sail artisan db:seed --class=DemoContentSeeder
```

В `DatabaseSeeder` демо вызывается лишь при `APP_ENV=local|testing`.  
`DemoContentSeeder` дополнительно защищён от `production`.

## Критерий готовности

| Критерий | Статус |
|---|---|
| Миграции сущностей | да |
| Контент разделов из БД | да |
| Редактирование в `/admin` | да |
| Моки только для тестов/local | да |
| privacy / reports из CMS | да |

## Не входит (этап C+)

- JSON API `/api/v1`
- Реальные медиафайлы (пути-заглушки)
- Динамический sitemap
- POST формы контактов в API
