# Русский Маяк

Официальный сайт музыкальной группы: новости, дискография, видео, фоторепортажи, афиша, благотворительные сборы и форма обратной связи.

Публичная часть — SSR на Blade (SEO). Контент правится в админке Filament. Чтение тех же данных доступно через JSON API.

---

## Стек

| Слой | Технология |
|---|---|
| Backend | PHP 8.3+, Laravel 13 |
| БД | PostgreSQL |
| Кэш / очередь | Redis (прод), database (локально по умолчанию) |
| Админка | Filament 5 (`/admin`) |
| Фронт | Vite 7, Sass, GSAP, Lenis, Swiper, Splitting.js |
| Локально | Docker Desktop + Laravel Sail (`compose.yaml`) |
| Прод | Nginx + PHP-FPM + PostgreSQL + Redis + Supervisor |

Язык сайта: `ru`, часовой пояс: `Europe/Moscow`.

---

## Требования (локально)

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (запущен)
- Git
- PHP / Composer / Node.js внутри Sail не обязательны

---

## Быстрый старт

```bash
cp .env.example .env
php artisan key:generate          # если PHP есть локально, иначе после sail up
composer install                  # если vendor/ ещё нет
vendor/bin/sail up -d
vendor/bin/sail npm install
vendor/bin/sail artisan migrate --seed
vendor/bin/sail artisan storage:link
vendor/bin/sail npm run build
```

`--seed` создаёт администратора и страницы `/privacy`, `/reports`.  
Демо-контент из вёрстки **не** сидится сам: только вручную и только local —

```bash
vendor/bin/sail artisan db:seed --class=DemoContentSeeder
```

На Windows в PowerShell: `vendor\bin\sail …`. Если `vendor/` нет:

```powershell
docker run --rm -v "${PWD}:/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
Copy-Item .env.example .env
vendor\bin\sail up -d
vendor\bin\sail artisan key:generate
vendor\bin\sail npm install
vendor\bin\sail artisan migrate --seed
vendor\bin\sail artisan storage:link
vendor\bin\sail npm run build
```

В `.env` задано `COMPOSE_PROJECT_NAME=russkiy-mayak` — не убирайте: папка проекта короткая, без этого Sail путает контейнеры. `SAIL_XDEBUG_MODE=off`.

Открывать **http://127.0.0.1**, не `localhost` (на Windows IPv6 часто уходит в другой процесс).

| Сервис | URL |
|---|---|
| Сайт | http://127.0.0.1 |
| Админка | http://127.0.0.1/admin |
| Vite HMR | http://127.0.0.1:5173 (`sail npm run dev`) |
| Mailpit | http://127.0.0.1:8025 |
| PostgreSQL | `127.0.0.1:5432` · `sail` / `password` · БД `russkiy_mayak` |

Локальный вход в админку: `admin@russkiy-mayak.test` / `password`. На проде смените сразу.

Ежедневно: `vendor/bin/sail up -d` → в другом терминале `vendor/bin/sail npm run dev`. Стоп: `vendor/bin/sail down`.

Тесты: `vendor/bin/sail artisan test`.

---

## Страницы и API

| URL | Назначение |
|---|---|
| `/` | Главная |
| `/albums`, `/albums/{slug}` | Дискография |
| `/video` | Видеогалерея |
| `/photos`, `/photos/{slug}` | Фоторепортажи |
| `/news`, `/news/{slug}` | Новости |
| `/concerts`, `/concerts/{slug}` | Афиша |
| `/privacy`, `/reports` | Политика и отчёты |
| `/admin` | CMS |
| `/api/v1/*` | JSON API |
| `/robots.txt`, `/sitemap.xml` | SEO |
| `/up` | Health-check |

Старые `*.html` редиректят 301 на ЧПУ. Неопубликованное (`published_at` в будущем или пусто, альбом-черновик) на сайте и в API не видно.

API (префикс `/api/v1`): `home`, `settings`, `albums`, `videos`, `photo-reports`, `news`, `concerts`, `partners`, `fundraisings/current`, `POST /contact` (форма с главной).

Контент только из БД через `/admin`. Перед запуском в проде: **Настройки сайта → SEO → выключить «Режим разработки»** (иначе `noindex` и пустой sitemap).

---

## Структура

```
app/                 модели, контроллеры, Filament, API
database/            миграции и сидеры
resources/views      Blade (вёрстка)
resources/scss       дизайн-система
resources/js         плеер, модалки, GSAP, Lenis…
routes/web.php       публичный сайт
routes/api.php       /api/v1
compose.yaml         Sail: app, PostgreSQL, Redis, Mailpit
```

---

## Деплой на VPS

Sail на сервер **не** ставить. Стек: Ubuntu 24.04, Nginx, PHP 8.3-FPM, PostgreSQL, Redis, Supervisor, Certbot.

Для теста и прода на одной машине — **две копии**: разные папки, БД, `.env`, домены.

| | Тест | Прод |
|---|---|---|
| Домен | `test.домен.ru` | `домен.ru` |
| Каталог | `/var/www/russkiy-mayak-test` | `/var/www/russkiy-mayak` |
| БД | `russkiy_mayak_test` | `russkiy_mayak` |
| Ветка | рабочая | `main` |
| Режим разработки | включён (noindex) | выключен |

Не копируйте локальный `.env`. Не запускайте `DemoContentSeeder`. Свой `APP_KEY` на каждую копию.

Кратко на каждой копии:

```bash
git clone git@github.com:USER/REPO.git .
composer install --no-dev --optimize-autoloader
cp .env.example .env && php artisan key:generate
# поправить APP_ENV, APP_URL, БД, почту, DEBUG=false
npm ci && npm run build
php artisan migrate --force --seed
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

Nginx `root` — `…/public`. PHP: `unix:/run/php/php8.3-fpm.sock`. SSL: `certbot --nginx`.  
Письма формы: `QUEUE_CONNECTION=database` + worker Supervisor + cron `php artisan schedule:run`.  
Медиа: `storage/app/public` (свой у теста и у прода). Проверка: `https://домен.ru/up`.

Обновление: `php artisan down` → `git pull` → `composer install --no-dev` → `npm ci && npm run build` → `migrate --force` → кэш → `queue:restart` → `up`.

---

## Что не попадает в git

- `.env`, `vendor/`, `node_modules/`, `public/build`, загруженные файлы
- каталог `docs/` — локальные заметки и HTML-референс вёрстки, только на машине разработчика
