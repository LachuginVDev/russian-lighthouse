# Этап D — SEO и продакшен-контур

Дата: 2026-08-08  
Ветка: `feature/stage-b`

## Что сделано

1. Динамические `/robots.txt` и `/sitemap.xml` (только published URL).
2. В настройках сайта: **Режим разработки** (`is_development_mode`) — при включении:
   - `<meta name="robots" content="noindex, nofollow">`
   - заголовок `X-Robots-Tag: noindex, nofollow`
   - `robots.txt` → `Disallow: /`
   - пустой sitemap
3. OG-изображение из `default_og_image` (fallback `images/og-cover.jpg`).
4. Schema MusicGroup из контактов/соцсетей настроек.
5. 301 со старых `.html` на листинги (без демо-slug).
6. Кэш sitemap 1 час, сброс при сохранении настроек.

## Перед продакшеном

1. В `/admin/site-settings` → SEO: **выключить** «Режим разработки».
2. `php artisan storage:link`
3. `php artisan config:cache && php artisan route:cache && php artisan view:cache`
4. Очередь: `QUEUE_CONNECTION=database` + worker/supervisor (письма с формы).
5. Заполнить реальный контент в админке (мок не сидится автоматически).

## Критерий готовности

| Критерий | Статус |
|---|---|
| Динамический sitemap/robots | да |
| Режим разработки → noindex | да |
| 301 с `.html` | да |
| Schema / OG из данных | да |
