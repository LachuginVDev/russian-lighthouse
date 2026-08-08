# Этап C — API

Дата: 2026-08-08  
Ветка: `feature/stage-b`

## Что сделано

1. Публичное JSON API `/api/v1/*` (home, albums, tracks, videos, photo-reports, news, concerts, fundraisings/current, partners, settings).
2. `POST /api/v1/contact` — валидация, сохранение `contact_messages`, очередь письма, throttle 5/min по IP.
3. Форма контактов на главной отправляет через `fetch` на API.
4. Мок (`DemoContentSeeder`) убран из `DatabaseSeeder` — только вручную / в тестах.

## Основные URL

| Method | Path |
|---|---|
| GET | `/api/v1/home` |
| GET | `/api/v1/settings` |
| GET | `/api/v1/albums`, `/api/v1/albums/{slug}`, `/api/v1/albums/{slug}/tracks` |
| GET | `/api/v1/videos` |
| GET | `/api/v1/photo-reports`, `/api/v1/photo-reports/{slug}` |
| GET | `/api/v1/news`, `/api/v1/news/{slug}` |
| GET | `/api/v1/concerts?status=upcoming\|past`, `/api/v1/concerts/{slug}` |
| GET | `/api/v1/fundraisings/current` |
| GET | `/api/v1/partners` |
| POST | `/api/v1/contact` |

## Локальный мок (опционально)

```bash
php artisan db:seed --class=DemoContentSeeder
```

## Критерий готовности

| Критерий | Статус |
|---|---|
| Read API ключевых сущностей | да |
| POST contact + mail | да |
| JS формы на fetch | да |
| Мок не в дефолтном seed | да |
