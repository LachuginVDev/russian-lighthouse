# Этап A — каркас (выполнен)

Дата: 2026-08-08  
Ветка: `feature/laravel-bootstrap`

## Что сделано

1. **Laravel 13.24** в корне репозитория (PHP ≥ 8.3).  
2. **Laravel Sail + Docker**: `laravel.test`, **PostgreSQL 18**, Redis, Mailpit.  
3. Перенос утверждённой вёрстки:
   - SCSS → `resources/scss`
   - JS → `resources/js` (main + page entries)
   - HTML → Blade (`resources/views/pages/*`)
   - partials → Blade-компоненты (`x-meta`, `x-site-header`, `x-site-footer`, `x-icons`, `x-page-header`, `x-schema.music-group`)
4. ЧПУ-роуты + 301 со старых `*.html`.  
5. Страницы `/privacy` и `/reports`.  
6. Исходная HTML-вёрстка сохранена в `docs/html-reference/` (эталон).  
7. README с инструкцией «поднял и работаешь».

## Критерий готовности этапа A

| Критерий | Статус |
|---|---|
| Все 10 экранов открываются через Laravel | да (HTTP 200) |
| Анимации/JS подключены через Vite | да (`public/build`) |
| Docker Desktop: `sail up -d` | да |
| PostgreSQL вместо MySQL | да |
| Документация запуска | `README.md` |
| 301 со старых `.html` | да |

### Важно при Blade + JSON-LD

В JSON-LD поля `@type` / `@context` нужно писать как `@@type` / `@@context`, иначе Blade воспримет `@` как директиву.

## Что НЕ входит в этап A (следующие этапы)

- Filament / админка (B)
- Eloquent-модели и миграции контента (B)
- JSON API `/api/v1` (C)
- Динамический sitemap из БД (D)
- Реальные медиафайлы audio/images

## Как проверить локально

```bash
cp .env.example .env
php artisan key:generate   # если ключа ещё нет
vendor/bin/sail up -d
vendor/bin/sail npm install
vendor/bin/sail artisan migrate
vendor/bin/sail npm run build
```

Открыть http://localhost — главная и разделы из меню.
