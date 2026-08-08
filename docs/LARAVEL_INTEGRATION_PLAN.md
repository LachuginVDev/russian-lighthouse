# Технический план интеграции Laravel — «Русский Маяк»

**Статус вёрстки:** утверждена  
**Текущий стек фронтенда:** Vite 8 MPA, Sass, GSAP, Lenis, Splitting.js, Swiper  
**Цель этапа 2:** Laravel 13 + PostgreSQL + Docker Desktop + API + SEO + удобная админка  
**Принцип:** все элементы утверждённой вёрстки должны быть интегрированы без потери дизайна и анимаций.

---

## 1. Исходное состояние фронтенда (инвентарь)

### 1.1 Страницы (10 HTML)

| Файл | Тип | Назначение | JS entry |
|---|---|---|---|
| `index.html` | landing | Главная со всеми блоками | `src/scripts/main.js` |
| `albums.html` | listing | Дискография | `src/scripts/pages/albums.js` |
| `album.html` | detail | Альбом: обложка, описание, плеер | `src/scripts/pages/album.js` |
| `video.html` | listing | Видеогалерея (модалка, без detail) | `src/scripts/pages/video.js` |
| `photos.html` | listing | Фоторепортажи | `src/scripts/pages/photos.js` |
| `photo-report.html` | detail | Репортаж + lightbox | `src/scripts/pages/photo-report.js` |
| `news.html` | listing | Новости + load more | `src/scripts/pages/news.js` |
| `news-single.html` | detail | Статья: теги, автор, TOC, плеер | `src/scripts/pages/news-single.js` |
| `concerts.html` | listing | Афиша upcoming/past | `src/scripts/pages/concerts.js` |
| `concert-single.html` | detail | Концерт на структуре новости | `src/scripts/pages/concert-single.js` |

**Отсутствуют, но есть ссылки:** `privacy.html`, `reports.html`.

### 1.2 Блоки главной (все обязательны к интеграции)

1. Hero  
2. О группе (+ счётчики)  
3. Музыкальный плеер  
4. Последние альбомы  
5. Видеогалерея (Swiper + modal)  
6. Фотогалерея (фильтры + lightbox)  
7. Новости  
8. Анонсы мероприятий  
9. Благотворительный сбор (прогресс)  
10. Реквизиты (копирование + QR)  
11. Партнёры (marquee)  
12. Контакты + форма обратной связи  

### 1.3 Partials → будущие Blade-компоненты

| Partial | Назначение |
|---|---|
| `src/partials/meta.html` | SEO / OG / Twitter |
| `src/partials/header.html` | Шапка + mobile nav |
| `src/partials/footer.html` | Подвал |
| `src/partials/icons.html` | SVG-спрайт |
| `src/partials/page-header-2.html` | Заголовок listing + breadcrumbs |
| `src/partials/schema-musicgroup.html` | JSON-LD MusicGroup |

### 1.4 SEO, уже заложенное во вёрстке

- Title / description / canonical / robots / theme-color  
- Open Graph + Twitter Cards  
- Schema.org: `MusicGroup`, `MusicAlbum`, `NewsArticle`, `Event`, `BreadcrumbList`  
- Хлебные крошки  
- `public/robots.txt`, `public/sitemap.xml`  

### 1.5 Интерактив (сохранить как есть)

| Механика | Data-атрибуты / компоненты |
|---|---|
| Аудиоплеер | `data-player`, `data-track`, `data-src`, `data-title`, `data-duration` |
| Видеомодалка | `data-video-trigger`, `data-video-embed`, `data-video-title` |
| Фильтры listing | `data-filter`, `data-category`, `.listing-count` |
| Load more | `data-load-more`, `data-step`, `data-visible` |
| Lightbox фото | `data-gallery`, `.photo-gallery__item` |
| Прогресс сбора | `data-progress`, `data-goal`, `data-current` |
| Копирование реквизитов | `data-copy` |
| TOC статьи | `data-toc` + `h2[id]` |
| Форма контактов | `data-contact-form` (сейчас без API) |
| Reveal / Lenis / GSAP | `data-reveal`, `data-split-text`, `data-count` |

---

## 2. Целевая архитектура

### 2.1 Почему hybrid SSR + API (не чистый SPA)

Требования одновременно: **SEO**, **утверждённая вёрстка**, **фронт через API**, **развитие проекта**.

| Подход | SEO | Сохранение вёрстки | API для развития | Рекомендация |
|---|---|---|---|---|
| Чистый SPA (React/Vue) | слабо без SSR | много переписывания | да | нет |
| Headless + Nuxt/Next SSR | да | переписывание | да | избыточно |
| **Laravel Blade SSR + JSON API + Filament** | **да** | **прямая миграция HTML→Blade** | **да** | **да** |

**Выбранная схема:**

```
┌─────────────────────────────────────────────────────────────┐
│                     Docker Desktop                          │
│  nginx → php-fpm (Laravel 13) → PostgreSQL / Redis / Mailpit │
│  node (Vite build assets)                                   │
└─────────────────────────────────────────────────────────────┘

Публичный сайт (SSR, SEO):
  Browser → Laravel Blade (из текущей вёрстки) + Vite assets
           ↳ часть данных/интеракций через /api/v1/*

Админка:
  Browser → Filament (/admin)

Будущие клиенты (мобильное приложение, виджеты):
  → только /api/v1/*
```

### 2.2 Архитектурные слои (для масштабирования)

Использовать **Modular / Domain-oriented** структуру внутри Laravel (не «всё в Controllers»):

```
app/
  Domain/
    Catalog/          # альбомы, треки
    Media/            # видео, фоторепортажи
    Content/          # новости, статичные страницы
    Events/           # концерты
    Charity/          # сборы, реквизиты, отчёты
    Communication/    # контакты, формы, партнёры
    Seo/              # meta, schema, sitemap
    Shared/           # настройки сайта, медиафайлы
  Application/        # UseCases / Actions / DTOs
  Http/
    Controllers/Web/  # Blade SSR
    Controllers/Api/  # JSON API v1
  Filament/Resources/ # админка
resources/
  views/              # Blade из утверждённой вёрстки
  js/, scss/          # перенос src/scripts + src/styles
```

Правила слоёв:

1. **Domain** — модели, enum’ы, бизнес-правила, scopes (`published()`, `upcoming()`).  
2. **Application** — Actions: `CreateNews`, `PublishAlbum`, `SubmitContactForm`.  
3. **Http Web** — тонкие контроллеры → ViewModels → Blade.  
4. **Http Api** — Resources/Transformers, версия `/api/v1`.  
5. **Filament** — только UI админки, вызывает Application Actions.

Это позволит позже вынести модули, добавить очередь/поиск/мобильное API без переписывания сайта.

### 2.3 Роли компонентов

| Слой | Технология | Ответственность |
|---|---|---|
| Backend | Laravel 13 (PHP ≥ 8.3) | SSR, API, auth админки, очереди, SEO-роутинг |
| Admin | Filament 3/4 (совместимая с L13) | CRUD всех сущностей, медиа, SEO-поля |
| DB | PostgreSQL 16 | контент, настройки, формы |
| Cache/Queue | Redis | кэш страниц/API, очереди писем |
| Frontend assets | Vite (текущий) | SCSS, GSAP/Lenis/Swiper, page JS |
| Media | Laravel Storage (local → S3-compatible) | audio, images, OG, QR |
| Mail | Mailpit (dev) / SMTP (prod) | заявки с формы |
| Search (этап 3) | PostgreSQL full-text и/или Meilisearch + Scout | поиск по новостям/альбомам |

---

## 3. Docker Desktop

### 3.1 Сервисы `docker-compose.yml`

| Сервис | Образ / роль | Порт (host) |
|---|---|---|
| `nginx` | reverse-proxy, статика `/build`, `/storage` | `80` / `443` |
| `app` | PHP 8.3+/8.4-FPM + Laravel 13 | — |
| `node` | Vite build / `npm run dev` (опционально) | `5173` |
| `pgsql` | PostgreSQL 16 | `5432` |
| `redis` | cache + queue | `6379` |
| `mailpit` | тестовая почта | `8025` (UI), `1025` (SMTP) |

Рекомендуемый базовый стек: **Laravel Sail** с `DB_CONNECTION=pgsql` или собственный compose (nginx + php-fpm + postgres + redis).

### 3.2 Volumes и env

```
./  → /var/www/html
storage/app/public → доступен как /storage
.env → DB_CONNECTION=pgsql, DB_HOST=pgsql, DB_PORT=5432, DB_*, REDIS_*, APP_URL, FILESYSTEM_DISK, MAIL_*
```

Минимальные команды:

```bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
docker compose exec node npm install && npm run build
```

Преимущества PostgreSQL для проекта: JSON/JSONB для SEO-overrides и block-контента новостей, полнотекст (`tsvector`) под будущий поиск, надёжные миграции и concurrent indexes.

### 3.3 Окружения

| Env | Назначение |
|---|---|
| `local` | Docker Desktop, Mailpit, debug, Vite HMR |
| `staging` | проверка SEO/контента перед продом |
| `production` | HTTPS, очередь supervisor, кэш config/route/view |

---

## 4. URL-структура (человекопонятные slug)

Заменить шаблонные `*-single.html` на SEO-URL:

| Было (вёрстка) | Станет |
|---|---|
| `/` | `/` |
| `/albums.html` | `/albums` |
| `/album.html` | `/albums/{slug}` |
| `/video.html` | `/video` |
| `/photos.html` | `/photos` |
| `/photo-report.html` | `/photos/{slug}` |
| `/news.html` | `/news` |
| `/news-single.html` | `/news/{slug}` |
| `/concerts.html` | `/concerts` |
| `/concert-single.html` | `/concerts/{slug}` |
| — | `/privacy` |
| — | `/reports` |
| — | `/reports/{slug}` |
| `#fundraising` | `/` якорь или `/charity` (опционально) |
| — | `/admin` (Filament) |
| — | `/api/v1/*` |

Редиректы 301 со старых `.html` URL — обязательны после запуска.

---

## 5. Модель данных (сущности под вёрстку)

### 5.1 ER (логическая)

```
albums 1──* tracks
photo_reports 1──* photos
news *──* tags
concerts *──* tags (опционально)
fundraisings 1──* fundraising_media
fundraisings 1──* reports (или отдельная сущность reports)
partners
requisites (или site_settings JSON)
site_settings (singleton)
contact_messages
pages (privacy и др.)
media (Spatie Media Library / Laravel Media)
seo_meta (morph: любая сущность)
```

### 5.2 Таблицы и поля

#### `albums`
| Поле | Тип | Из вёрстки |
|---|---|---|
| id | bigint | |
| slug | string unique | URL detail |
| title | string | h1 / card title |
| year | year/int | фильтр + meta |
| type | enum(`album`,`ep`) | «Альбом / EP» |
| status | enum(`draft`,`published`,`coming_soon`) | badge «Скоро» |
| cover_path | string/media | обложка |
| excerpt | text | card text / lead |
| description | longtext (HTML) | «История создания» |
| genre | string | meta |
| duration_label | string | «≈ 32 минуты» |
| vk_url / youtube_music_url | string nullable | CTA |
| published_at | datetime nullable | |
| sort_order | int | |
| seo_* | через morph | title/description/og |

#### `tracks`
| Поле | Тип | Из вёрстки |
|---|---|---|
| album_id | fk nullable | null = standalone embed |
| title | string | `data-title` |
| artist | string default «Русский Маяк» | `data-artist` |
| duration | string (`3:42`) или seconds | `data-duration` |
| audio_path | string | `data-src` |
| cover_path | string nullable | обложка плеера |
| position | int | index 01, 02… |
| is_featured_home | bool | плейлист на главной |

#### `videos`
| Поле | Тип |
|---|---|
| slug | optional (для админки) |
| title | |
| category | enum(`concerts`,`trips`,`interviews`,`backstage`) |
| type_label | string («Документальный») |
| duration_label | string (`6:24`) |
| embed_url | string (YouTube/VK) |
| thumbnail_path | string nullable |
| is_featured_home | bool |
| published_at / sort_order | |

#### `photo_reports`
| Поле | Тип |
|---|---|
| slug, title, excerpt, lead | |
| category | enum(`concerts`,`trips`,`hospitals`,`backstage`) |
| cover_path | |
| report_date | date |
| published_at | |

#### `photos`
| Поле | Тип |
|---|---|
| photo_report_id | fk |
| image_path | |
| alt / caption | aria-label / подпись |
| position | int |

#### `news`
| Поле | Тип |
|---|---|
| slug, title, excerpt | |
| category | enum(`trips`,`releases`,`charity`,`concerts`,`media`) |
| body | longtext / JSON blocks |
| cover_path | |
| author_name, author_role, author_initials | author-chip |
| reading_time | int/string |
| embedded_track_id | fk nullable |
| published_at | |
| tags | many-to-many |

#### `concerts`
| Поле | Тип |
|---|---|
| slug, title | |
| starts_at | datetime |
| ends_at | nullable |
| venue, city, address | place |
| badge_type | enum(`charity`,`trip`,`acoustic`,`other`) |
| status | enum(`upcoming`,`past`,`cancelled`) |
| ticket_status_label | «Билеты в продаже» |
| ticket_url | nullable |
| cover_path, body | как у новости |
| embedded_track_id | nullable |
| fundraising_id | nullable |
| published_at | |

#### `fundraisings`
| Поле | Тип |
|---|---|
| title, lead | |
| status | enum(`open`,`closed`,`draft`) |
| goal_amount | bigint |
| current_amount | bigint |
| report_page_url / report_id | |
| is_featured_home | bool |
| media[] | фото блока |

#### `requisites` (или JSON в `site_settings`)
- card_number, recipient, inn, bank_account, bik  
- qr_image_path  
- copy payloads для кнопок  

#### `partners`
- name, logo_path, url, sort_order, is_active  

#### `pages`
- slug (`privacy`, `about`…), title, body, seo  

#### `reports` (отчёты о помощи)
- slug, title, published_at, body/file_path, fundraising_id nullable  

#### `contact_messages`
- name, email, message, consent, ip, status(`new`,`read`,`archived`), created_at  

#### `site_settings` (singleton)
- phone, email, address  
- social: vk, telegram, youtube  
- about texts, about image  
- stats: years, concerts_count, trips_count  
- default og_image  
- schema MusicGroup fields  

#### `seo_meta` (morphOne)
- meta_title, meta_description, og_title, og_description, og_image, canonical, robots, schema_json (override)

---

## 6. API (`/api/v1`)

Фронт (Blade JS) и будущие клиенты работают через версионированное API.

### 6.1 Публичные endpoints (read)

```
GET  /api/v1/home                     # агрегатор блоков главной
GET  /api/v1/albums?year=&page=
GET  /api/v1/albums/{slug}
GET  /api/v1/albums/{slug}/tracks
GET  /api/v1/videos?category=
GET  /api/v1/photo-reports?category=
GET  /api/v1/photo-reports/{slug}
GET  /api/v1/news?category=&page=
GET  /api/v1/news/{slug}
GET  /api/v1/concerts?status=upcoming|past
GET  /api/v1/concerts/{slug}
GET  /api/v1/fundraisings/current
GET  /api/v1/partners
GET  /api/v1/settings
```

### 6.2 Публичные endpoints (write)

```
POST /api/v1/contact
  body: { name, email, message, consent }
  → validation, store ContactMessage, queue mail notification
  → rate limit: 5/min IP
```

### 6.3 Формат ответа

```json
{
  "data": {},
  "meta": { "current_page": 1, "last_page": 3, "total": 24 },
  "links": { "next": "..." }
}
```

API Resources зеркалят `data-*` фронта:

```json
{
  "id": 1,
  "title": "Позывной Надежда",
  "artist": "Русский Маяк",
  "duration": "3:42",
  "src": "https://.../storage/audio/track.mp3",
  "album_title": "Свет с передовой"
}
```

### 6.4 Как фронт использует API (сохраняя анимации)

| Место | SSR (первый рендер) | API |
|---|---|---|
| Listing страницы | HTML карточек из Blade | фильтры/load more могут догружать JSON |
| Плеер | треки в DOM из Blade | опционально refresh playlist |
| Видеомодалка | embed в `data-video-embed` | не обязателен |
| Форма контактов | разметка | `POST /api/v1/contact` |
| Прогресс сбора | `data-goal/current` в HTML | опционально polling |
| Главная | полный SSR | `GET /home` для виджетов/PWA позже |

**Важно:** первый HTML всегда полный (SEO + утверждённый вид). API — для интерактива и внешних клиентов.

---

## 7. Web (Blade) — миграция утверждённой вёрстки

### 7.1 Маппинг HTML → Blade

| HTML | Blade |
|---|---|
| `index.html` | `resources/views/pages/home.blade.php` |
| `albums.html` | `pages/albums/index.blade.php` |
| `album.html` | `pages/albums/show.blade.php` |
| `video.html` | `pages/videos/index.blade.php` |
| `photos.html` | `pages/photos/index.blade.php` |
| `photo-report.html` | `pages/photos/show.blade.php` |
| `news.html` | `pages/news/index.blade.php` |
| `news-single.html` | `pages/news/show.blade.php` |
| `concerts.html` | `pages/concerts/index.blade.php` |
| `concert-single.html` | `pages/concerts/show.blade.php` |
| + `privacy` / `reports` | `pages/static/show.blade.php` |

### 7.2 Layout / компоненты

```
resources/views/
  layouts/app.blade.php          ← html/head/body + @vite
  components/
    meta.blade.php               ← из meta.html
    header.blade.php
    footer.blade.php
    icons.blade.php
    page-header.blade.php
    breadcrumbs.blade.php
    card/album.blade.php
    card/news.blade.php
    card/video.blade.php
    player.blade.php             ← общий плеер
    fundraising.blade.php
    requisites.blade.php
    schema/*.blade.php
```

Классы BEM и data-атрибуты **не менять** — чтобы существующий JS продолжал работать.

### 7.3 Assets

Перенос:

```
src/styles/**  → resources/scss/** (или resources/css)
src/scripts/** → resources/js/**
public/favicon.svg → public/
```

`vite.config.js` Laravel-плагин:

- inputs: `resources/js/main.js` + page entries  
- `@vite(['resources/scss/main.scss', 'resources/js/main.js'])` в layout  

Анимации (GSAP/Lenis/Swiper) остаются на клиенте без изменений логики.

---

## 8. Админка (Filament) — удобство

### 8.1 Почему Filament

- Быстрый CRUD под контент-сайт  
- Медиа, повторители, SEO-поля из коробки/плагинами  
- Роли/права  
- Русская локаль  
- Не нужно писать отдельный React-admin  

URL: `/admin`

### 8.2 Resources (обязательные)

| Resource | Ключевые UX |
|---|---|
| Albums | обложка, треки (RelationManager), статус «Скоро», SEO |
| Tracks | загрузка mp3, длительность auto-detect (опционально) |
| Videos | preview embed, категории, featured на главной |
| PhotoReports | галерея фото drag&drop сортировка |
| News | Rich Editor / blocks, теги, автор, embed track, TOC из h2 |
| Concerts | дата/время/место, upcoming/past auto по `starts_at`, билеты |
| Fundraisings | goal/current, медиа, связь с отчётами |
| Reports | отчёты о помощи + файл PDF |
| Partners | логотип + порядок |
| Requisites / Settings | singleton страница настроек |
| ContactMessages | inbox, статус прочитано, ответ email |
| Pages | Политика конфиденциальности и др. |
| Users/Roles | админы |

### 8.3 SEO в каждой сущности (UI)

Вкладки формы Filament:

1. Контент  
2. Медиа  
3. Публикация  
4. **SEO** (title, description, OG image, robots, preview сниппета)  

Генерация slug из title + ручная правка.

### 8.4 Роли

| Роль | Права |
|---|---|
| Super Admin | всё |
| Editor | контент, медиа, публикации |
| Moderator | заявки формы, без настроек сайта |

---

## 9. SEO-реализация в Laravel

### 9.1 Обязательный набор

1. SSR HTML (Blade) — полный контент в первом ответе.  
2. Уникальные `title` / `description` / canonical на каждую страницу.  
3. OG + Twitter из `seo_meta` или fallback на сущность.  
4. JSON-LD:
   - Home → `MusicGroup` (+ `WebSite` + `SearchAction` позже)
   - Album → `MusicAlbum` + `MusicRecording[]`
   - News → `NewsArticle` + `Person` author + `image`
   - Concert → `Event` (status, location, offers)
   - Listing/Detail → `BreadcrumbList`
5. Динамический `sitemap.xml` (`spatie/laravel-sitemap` или свой generator).  
6. `robots.txt` из Laravel/public.  
7. ЧПУ slug + 301 со старых `.html`.  
8. Оптимизация изображений: WebP/AVIF через conversion (Spatie Media Library).  
9. Lazy-load как во вёрстке, `loading="lazy"`, корректные `alt`.  
10. Внутренняя перелинковка: related blocks из CMS.  

### 9.2 Технические SEO-маршруты

```
GET /sitemap.xml
GET /robots.txt
GET /manifest.webmanifest   # опционально
```

Кэш: `Cache::remember` для sitemap и home aggregator (сброс при publish).

### 9.3 Чеклист перед продом

- [ ] Lighthouse SEO ≥ 90  
- [ ] Нет пустых title/h1  
- [ ] Schema валидна (Rich Results Test)  
- [ ] OG-preview корректный  
- [ ] Все detail в sitemap только `published`  
- [ ] 404/410 для снятых материалов  

---

## 10. Медиа и файлы

| Тип | Диск | Пример пути | Где в UI |
|---|---|---|---|
| Обложки альбомов | `public` | `storage/albums/{id}/cover.webp` | album hero / cards / player |
| Аудио | `public` или private+signed | `storage/audio/...mp3` | `data-src` плеера |
| Фото репортажей | `public` | `storage/photos/...` | gallery + lightbox |
| Видео превью | `public` | thumbnail | video-card |
| OG image | `public` | `storage/seo/og-default.jpg` | meta |
| QR реквизитов | `public` | `storage/requisites/qr.svg\|png` | блок реквизитов |
| PDF отчётов | `public`/`local` | `storage/reports/...pdf` | `/reports` |

Пакет: `spatie/laravel-medialibrary` (коллекции `cover`, `gallery`, `audio`, `og`).

---

## 11. Интеграция каждого элемента вёрстки → backend

| Элемент UI | Источник данных | Admin | API |
|---|---|---|---|
| Hero тексты/CTA | `site_settings` / HomeSettings | Settings | `/settings`, `/home` |
| О группе + stats | `site_settings` | Settings | `/settings` |
| Плеер главной | `tracks` where featured | Tracks/Albums | `/home` |
| Карточки альбомов | `albums` published | Albums | `/albums` |
| Видео + modal | `videos` | Videos | `/videos` |
| Фото на главной | featured photos / reports | PhotoReports | `/home` |
| Новости | `news` | News | `/news` |
| Афиша | `concerts` | Concerts | `/concerts` |
| Сбор + progress | `fundraisings` current | Fundraisings | `/fundraisings/current` |
| Реквизиты + copy/QR | `requisites` | Settings | `/settings` |
| Партнёры marquee | `partners` | Partners | `/partners` |
| Контакты | `site_settings` | Settings | `/settings` |
| Форма | POST → `contact_messages` | Inbox | `POST /contact` |
| Privacy | `pages.privacy` | Pages | — (SSR) |
| Reports | `reports` | Reports | `/reports` (optional) |

Ни один блок утверждённой главной не остаётся «захардкоженным навсегда» — хардкод допустим только в seeder на этапе переноса.

---

## 12. Безопасность и качество

- CSRF для web-форм; API contact — throttle + honeypot/recaptcha (по необходимости)  
- Валидация Form Request на все write-операции  
- Хранение секретов только в `.env` / Docker secrets  
- `spatie/laravel-permission` для ролей админки  
- Policies на publish/unpublish  
- XSS: очистка HTML body (HTMLPurifier / allowed tags)  
- Загрузка файлов: mime/size whitelist (audio/image/pdf)  
- Backup PostgreSQL (`pg_dump`) + storage  
- Логи: `contact` failures, media upload errors  

---

## 13. Этапы внедрения

### Этап A — Каркас (Docker + Laravel) ✅

Статус: **выполнено** (ветка `feature/laravel-bootstrap`). Инструкция запуска: [`README.md`](../README.md), чеклист: [`STAGE_A.md`](STAGE_A.md).

1. ✅ Laravel 13 в корне репозитория; утверждённая HTML-вёрстка — в `docs/html-reference/`.  
2. ✅ Sail / Compose: app, pgsql, redis, mailpit (+ Vite).  
3. ✅ Vite: SCSS/JS/шрифты в `resources/scss`, `resources/js`.  
4. ✅ `layouts/app` + компоненты header/footer/meta/icons/page-header/schema.  
5. ✅ Blade-страницы всех экранов + `/privacy`, `/reports`; ЧПУ и 301 со старых `*.html`.  

**Критерий готовности:** все 10 страниц открываются через Laravel, анимации работают — **закрыт**.

### Этап B — Домен и админка ✅

Статус: **выполнено** (ветка `feature/stage-b`). Чеклист: [`STAGE_B.md`](STAGE_B.md).

1. ✅ Миграции сущностей раздела 5.  
2. ✅ Filament 5 Resources + Settings singleton (`/admin`, `/admin/site-settings`).  
3. ✅ `DemoContentSeeder` — мок **только** для `local`/`testing` (не production).  
4. ⏳ Медиа: поля путей + FileUpload в админке; реальные файлы — по мере наполнения.  
5. ✅ `privacy` / `reports` из `pages` + список `reports`.  

**Критерий:** контент главной и разделов редактируется из `/admin` — **закрыт**.

### Этап C — API

1. API v1 Resources + маршруты.  
2. `POST /contact` + уведомление на email.  
3. Load more / фильтры listing через API (по желанию) или server query.  
4. Обновить JS формы на `fetch`.  

**Критерий:** форма и ключевые виджеты работают через API; Postman/OpenAPI описание есть.

### Этап D — SEO и продакшен

1. Динамический sitemap/robots.  
2. Schema JSON-LD из данных.  
3. 301 редиректы со старых `.html`.  
4. Кэш, очереди, `storage:link`, оптимизации изображений.  
5. Lighthouse / Schema validation.  

**Критерий:** SEO-чеклист раздела 9.3 закрыт.

### Этап E — Развитие (после запуска)

- Поиск (Scout + Meilisearch)  
- Подписка / рассылка  
- Личный кабинет донатера (если понадобится)  
- Интеграция эквайринга к сборам  
- Мобильное приложение на том же `/api/v1`  

---

## 14. Структура репозитория после интеграции

```
/
  app/Domain/...
  app/Filament/...
  app/Http/Controllers/{Web,Api}/...
  bootstrap/
  config/
  database/migrations|seeders|factories
  docker/  (если не Sail)
  docs/
    LARAVEL_INTEGRATION_PLAN.md   ← этот документ
  public/
  resources/
    views/
    js/          ← из src/scripts
    scss/        ← из src/styles
  routes/
    web.php
    api.php
    admin (Filament)
  tests/
    Feature/Api/
    Feature/Web/
  compose.yaml
  package.json   ← текущие фронт-зависимости + laravel-vite-plugin
  vite.config.js
```

Статические `*.html` в корне после переноса:

1. Либо удаляются,  
2. Либо оставляются только как reference в `docs/html-reference/` до конца этапа A.

---

## 15. Тестирование (минимум)

| Тип | Что покрыть |
|---|---|
| Feature Web | home 200, album slug 200/404, news published only |
| Feature Api | contact validation, albums filter by year, concerts status |
| Browser/smoke | плеер play UI, video modal, lightbox, copy requisites |
| SEO | наличие title/h1/canonical/schema на detail |
| Admin | create+publish news → видно на сайте |

---

## 16. Риски и решения

| Риск | Решение |
|---|---|
| Потеря анимаций при переносе | Не менять BEM/data-атрибуты; переносить JS as-is |
| Плохое SEO при «только API SPA» | SSR Blade обязателен для публички |
| Большие mp3 | CDN/S3, range requests, не хранить в git |
| Контент-редакторы ломают вёрстку HTML | ограничить allowed tags / block editor |
| Расхождение demo-URL и slug | 301 + seeder со slug’ами транслитом |
| Двойной источник правды (HTML и админка) | после этапа B контент только из БД |

---

## 17. Критерии приёмки этапа Laravel

1. Все экраны утверждённой вёрстки доступны через Laravel-роуты и визуально соответствуют макету.  
2. Все сущности редактируются в Filament без правки кода.  
3. Форма обратной связи сохраняется и отправляет уведомление.  
4. Плеер играет файлы из Storage.  
5. Видео открывается в модалке с embed из CMS.  
6. Фоторепортаж: галерея + lightbox из CMS.  
7. Новости/концерты: listing + detail, теги/даты/автор/TOC.  
8. Сбор: актуальные `goal/current` из админки, прогресс анимируется.  
9. Реквизиты копируются, QR из админки.  
10. SEO: meta/OG/Schema/sitemap/robots/ЧПУ.  
11. Docker Desktop: проект поднимается одной командой `docker compose up -d`.  
12. Публичное JSON API v1 покрывает чтение ключевых сущностей и `POST /contact`.  

---

## 18. Рекомендуемый стек пакетов

| Пакет | Зачем |
|---|---|
| `laravel/framework` ^13 | ядро (PHP ≥ 8.3) |
| `filament/filament` ^3/^4 | админка (версия, совместимая с Laravel 13) |
| `spatie/laravel-medialibrary` | медиа |
| `spatie/laravel-sluggable` | slug |
| `spatie/laravel-sitemap` | sitemap |
| `spatie/laravel-permission` | роли |
| `laravel/sail` (или свой compose) | Docker |
| `laravel/vite-plugin` | связка с текущим Vite |
| `dedoc/scramble` или Scribe | документация API (опционально) |

---

## 19. Порядок следующих практических шагов

1. Инициализировать Laravel 13 + PostgreSQL + Docker в новой ветке `feature/laravel-bootstrap`.  
2. Перенести layout/partials → Blade, подключить Vite assets.  
3. Завести миграции Album/Track/News/Concert/Video/PhotoReport/Fundraising/Settings.  
4. Поднять Filament и Settings.  
5. Подключить `POST /api/v1/contact`.  
6. Заменить хардкод главной на Eloquent.  
7. Закрыть SEO-контур (sitemap/schema/редиректы).  

---

**Документ подготовлен по утверждённой вёрстке репозитория `russkiy-mayak` (ветка `master`) и является рабочим ТЗ на этап backend-интеграции.**
