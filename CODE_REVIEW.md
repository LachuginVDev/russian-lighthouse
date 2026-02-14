# Код-ревью: Russian Lighthouse

Обзор состояния проекта — что сделано, что работает, замечания.

---

## Что сделано

### Инфраструктура
- **Docker:** app (PHP 8.3-FPM), nginx, postgres:16, redis:7. Entrypoint выставляет права на `storage` и `bootstrap/cache`. Порт 8000 → nginx, 5173 → Vite в app.
- **Nginx:** корень `public`, PHP через fastcgi на app:9000.
- **Laravel 12:** Breeze (Vue 3 + TS + Inertia), Filament (админка по `/admin`).

### Бэкенд
- **Роли и права:** таблицы `roles`, `permissions`, `permission_role`, у `users` поле `role_id`. Роли `user` и `admin`. Модели `Role`, `Permission`, `User` с `role()`, `hasPermission()`, `canAccessPanel()` (Filament только для admin). Сидеры: `PermissionSeeder`, `AssignFirstAdminSeeder`.
- **Регистрация:** email приводится к нижнему регистру, при создании пользователя ставится роль `user`.
- **Маршруты:** `/` → Welcome, `/dashboard`, `/profile`, `/login`, `/register`, Breeze auth (forgot/reset/verify/confirm), Filament `/admin`.

### Фронтенд
- **Точка входа:** `resources/js/app.ts` — createInertiaApp, resolvePageComponent по `./Pages/**/*.vue`, Ziggy, прогресс-бар.
- **Шаблон:** `resources/views/app.blade.php` — один вызов `@vite(['resources/js/app.ts'])`, `@routes`, `@inertia`, `@inertiaHead`. Локаль из `app()->getLocale()`.
- **Главная:** `Welcome.vue` — sticky-шапка (Вход/Регистрация или Панель), затем блоки из `Components/Home/`: HeroSlider, HeroBlock, NewsSlider, ActiveFundraisers, MediaBlock, MissionBlock. Пропсы с бэка: `canLogin`, `canRegister`; `auth.user` приходит через HandleInertiaRequests.
- **Компоненты главной:** все шесть в `resources/js/Components/Home/`, с типами и опциональными пропсами под будущие данные (слайды, новости, сборы, медиа, миссия). Данные пока заглушки/пустые.
- **Vite:** алиас `@` → `resources/js`, laravel-vite-plugin, Vue plugin. Стабильная связка: Vite 6, laravel-vite-plugin ~1.3 (см. README).
- **TypeScript:** tsconfig с `baseUrl`, `moduleResolution: "node"`, paths для `@/*` и ziggy. Объявление модуля `@inertiajs/vue3` в `resources/js/types/inertia.d.ts` (чтобы IDE не ругалась).

### Документация
- **README:** стек, запуск (первый/обычный), стабильная сборка фронта, главная (структура блоков), роли/сидеры, установка на хосте (Windows).
- **WORK_LOG:** задачи 1–5, история файлов.

---

## Что работает

| Компонент | Статус |
|-----------|--------|
| Маршрут `/` | Inertia отдаёт Welcome с canLogin/canRegister. |
| Blade + Vite | Один entry — app.ts; бандл и страницы подхватываются. |
| Shared auth | HandleInertiaRequests отдаёт `auth.user`; Welcome и лейауты используют `$page.props.auth?.user`. |
| Вход/регистрация | Роли проставляются; Breeze-контроллеры и маршруты на месте. |
| Доступ в админку | User::canAccessPanel через role->isAdmin(); только admin. |
| Главная по блокам | Все шесть блоков рендерятся, без данных — заглушки/пустой вид. |
| Сборка | Vite 6 + plugin 1.3 — `npm install` и `npm run build` без конфликтов в контейнере. |

---

## Замечания и риски

1. **Welcome — лишние пропсы:** в маршруте `/` передаются `laravelVersion` и `phpVersion`; во фронте не используются. Можно убрать для чистоты.
2. **Главная без данных:** слайдер, новости, сборы, медиа, миссия пока без бэкенда. Когда появятся API/контроллер — передавать пропсы из роута в Welcome и пробрасывать в компоненты.
3. **Nginx и Vite dev:** в проде скрипты из `public/build`. При `npm run dev` Laravel отдаёт страницу с ссылками на localhost:5173; если Vite не запущен — скрипты не грузятся. README это описывает (запускать `npm run dev` при необходимости hot-reload).
4. **Типы Inertia:** `inertia.d.ts` с пустым `declare module` убирает ошибку IDE, но типы из пакета могут не подхватываться (экспорты как `any`). Для строгой типизации позже можно добавить path mapping в tsconfig на `node_modules/@inertiajs/vue3`.
5. **Порядок миграций:** миграция ролей должна идти после создания таблицы `users` (Breeze). Сейчас отдельная миграция с `role_id` — порядок по дате в имени файла нужно сохранять при добавлении новых.

---

## Краткий чеклист перед релизом/деплоем

- [ ] Выполнены миграции и сидеры (PermissionSeeder, при необходимости AssignFirstAdminSeeder).
- [ ] Назначен хотя бы один admin (AssignFirstAdminSeeder + ADMIN_EMAIL или первому пользователю).
- [ ] Собран фронт: `npm run build`, в `public/build` есть manifest и ассеты.
- [ ] APP_KEY и .env для окружения заданы.
- [ ] Очереди (Redis) и при необходимости `queue:work` / Horizon.

---

*Дата ревью: 14.02.2025*
