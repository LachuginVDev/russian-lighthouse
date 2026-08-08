# Русский Маяк — официальный сайт

Laravel 13 · PostgreSQL · Docker Desktop (Sail) · Vite · утверждённая вёрстка на Blade.

Полный технический план: [`docs/LARAVEL_INTEGRATION_PLAN.md`](docs/LARAVEL_INTEGRATION_PLAN.md)  
Этап A: [`docs/STAGE_A.md`](docs/STAGE_A.md) · этап B: [`docs/STAGE_B.md`](docs/STAGE_B.md)

---

## Требования

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (запущен)
- Git
- (опционально локально) Node.js 20+, PHP 8.3+, Composer — внутри Sail не обязательны

---

## Быстрый старт (одна сессия)

В корне проекта:

```bash
# 1. Окружение
cp .env.example .env

# 2. Ключ приложения (локально, если PHP установлен)
php artisan key:generate

# 3. Поднять контейнеры
./vendor/bin/sail up -d

# 4. Зависимости фронта + миграции БД
./vendor/bin/sail npm install
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm run build
```

`--seed` в `local` подтянет мок-контент и админа. В production демо-сид не выполняется.

На Windows в PowerShell вместо `./vendor/bin/sail` можно:

```powershell
vendor\bin\sail up -d
vendor\bin\sail npm install
vendor\bin\sail artisan migrate
vendor\bin\sail npm run build
```

Если `vendor/` ещё нет (чистый клон) и PHP/Composer стоят локально:

```bash
composer install
cp .env.example .env
php artisan key:generate
vendor/bin/sail up -d
vendor/bin/sail npm install
vendor/bin/sail artisan migrate
vendor/bin/sail npm run build
```

Без локального PHP — через Docker (из корня проекта):

```bash
docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
cp .env.example .env
# APP_KEY: после первого `sail up` выполните
#   vendor/bin/sail artisan key:generate
vendor/bin/sail up -d
vendor/bin/sail artisan key:generate
vendor/bin/sail npm install
vendor/bin/sail artisan migrate
vendor/bin/sail npm run build
```

На Windows PowerShell (без `id -u`):

```powershell
docker run --rm -v "${PWD}:/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
Copy-Item .env.example .env
vendor\bin\sail up -d
vendor\bin\sail artisan key:generate
vendor\bin\sail npm install
vendor\bin\sail artisan migrate
vendor\bin\sail npm run build
```

В `.env` уже задано `COMPOSE_PROJECT_NAME=russkiy-mayak` — не переименовывайте папку проекта в одну цифру без этого ключа: иначе Sail может «не видеть» контейнеры.

Если `vendor/bin/sail …` пишет, что Sail не запущен, а `docker ps` показывает контейнеры:

```powershell
docker exec russkiy-mayak-laravel.test-1 php artisan migrate
docker exec russkiy-mayak-laravel.test-1 npm run build
```

### Открыть сайт

| Сервис | URL |
|---|---|
| Сайт | http://localhost |
| Админка | http://localhost/admin (`admin@russkiy-mayak.test` / `password`) |
| Vite HMR (dev) | http://localhost:5173 |
| Mailpit (почта) | http://localhost:8025 |
| PostgreSQL | `localhost:5432` (user/pass: `sail` / `password`, db: `russkiy_mayak`) |

---

## Ежедневная работа

```bash
# Старт
vendor/bin/sail up -d

# Фронт с HMR (в отдельном терминале)
vendor/bin/sail npm run dev

# Artisan / composer / npm
vendor/bin/sail artisan migrate
vendor/bin/sail composer require vendor/package
vendor/bin/sail npm install

# Остановка
vendor/bin/sail down
```

Алиас (удобно один раз в профиле shell):

```bash
alias sail='sh vendor/bin/sail'
```

---

## Страницы (этап A)

| URL | Описание |
|---|---|
| `/` | Главная |
| `/albums`, `/albums/{slug}` | Дискография |
| `/video` | Видеогалерея (модалка) |
| `/photos`, `/photos/{slug}` | Фоторепортажи |
| `/news`, `/news/{slug}` | Новости |
| `/concerts`, `/concerts/{slug}` | Концерты |
| `/privacy`, `/reports` | Статичные страницы |

Старые `*.html` редиректят 301 на ЧПУ.

Контент пока зашит в Blade (демо из утверждённой вёрстки). CMS/Filament — этап B.

---

## Структура

```
app/Http/Controllers/PageController.php
resources/views/layouts|components|pages
resources/scss                 ← дизайн-система
resources/js                   ← GSAP/Lenis/Swiper/player…
docs/html-reference            ← исходная утверждённая HTML-вёрстка
docs/LARAVEL_INTEGRATION_PLAN.md
compose.yaml                   ← Sail: app, pgsql, redis, mailpit
```

---

## Полезные команды

```bash
vendor/bin/sail artisan route:list
vendor/bin/sail artisan view:clear
vendor/bin/sail npm run build
vendor/bin/sail down -v          # стоп + удалить volumes (осторожно: сотрёт БД)
```
