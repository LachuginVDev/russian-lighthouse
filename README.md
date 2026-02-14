
# Russian Lighthouse

Сайт музыкальной группы с блогом и системой благотворительных сборов.

---

## 📦 Технологический стек

### Backend

* Laravel 12
* PHP 8.3
* PostgreSQL 16
* Redis

### Frontend

* Vue 3
* TypeScript
* Vite
* Tailwind CSS

### Admin

* Filament

### Infrastructure

* Docker (Docker Compose v2)
* Nginx (Alpine)
* Образы: PHP 8.3-fpm, PostgreSQL 16, Redis 7

---

## 🧰 Требования к окружению

* Docker >= 24
* Docker Compose v2 (встроен в Docker Desktop)
* Git

Локально PHP не требуется — используется контейнер.

---

## 🐘 Версия PHP

Проект работает на:

PHP 8.3

Используются возможности языка:

* strict types
* typed properties
* readonly properties
* enums
* constructor property promotion

Во всех PHP-файлах обязательно:

```php
declare(strict_types=1);
```

---

## 📐 Стандарты кодирования

Проект следует стандартам:

* PSR-1
* PSR-12
* PSR-4 (autoloading)
* PSR-3 (logging)
* PSR-7 / PSR-15 при необходимости middleware

Форматирование кода:

* Laravel Pint


## 🧱 Архитектурные правила

1. Контроллеры — только orchestration.
2. Бизнес-логика — в Service слое.
3. Валидация — через FormRequest.
4. DTO используются для передачи данных между слоями.
5. Репозитории применяются при усложнении доступа к данным.
6. Никакой бизнес-логики в контроллерах.
7. Никакой логики в Blade или Vue компонентах.
8. Feature-based / Domain структура.

Структура проекта:

```
app/Domain/
    Blog/
    Music/
    Donations/
```

---

## 🗄 База данных

* PostgreSQL 16
* Миграции через Laravel


---

## 🔐 Авторизация

Используется Laravel Breeze (Vue + TypeScript).

---

## 🔄 Очереди

* Redis

Запуск worker:

```bash
docker compose exec app php artisan queue:work
```

В production рекомендуется использовать Horizon + Supervisor.

---

## 🚀 Запуск проекта

1. Скопировать `.env.example` в `.env` (если ещё не сделано).
2. Поднять контейнеры:

   ```bash
   docker compose up -d
   ```

3. Установить зависимости и настроить приложение (первый запуск):

   ```bash
   docker compose exec app composer install --no-interaction
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan storage:link
   docker compose exec app php artisan migrate --force
   docker compose exec app npm install --legacy-peer-deps
   docker compose exec app npm run build
   ```

4. Открыть в браузере: **http://localhost:8000**

   * Сайт (Breeze/Vue): главная, регистрация, вход.
   * Админ-панель Filament: **http://localhost:8000/admin** (доступ после входа под любым пользователем).

5. Режим разработки с hot-reload фронтенда:

   ```bash
   docker compose exec app npm run dev
   ```
