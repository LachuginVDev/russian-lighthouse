# Перенос сайта «Русский Маяк» на VPS

Sail (`compose.yaml`) — только для локальной разработки. На сервере ставим классический стек: **Nginx + PHP-FPM + PostgreSQL + Redis + Supervisor**.

Ориентир: Ubuntu 24.04, 2 vCPU / 4 GB RAM, диск от 40 GB.

---

## 1. Что подготовить до деплоя

- Домен, A-запись на IP VPS.
- SSH-доступ с ключом, пользователь с `sudo`.
- Репозиторий (git clone по SSH или HTTPS).
- SMTP для писем с формы (Timeweb / Beget / Yandex / Mailgun).
- Реальные реквизиты, OG-картинка, QR, пароль админки — не копируйте локальный `.env` и не запускайте `DemoContentSeeder` на проде.

Локально перед выкладкой:

```bash
vendor/bin/sail artisan test
vendor/bin/sail npm run build
```

---

## 2. Сервер: пакеты

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx postgresql redis-server supervisor unzip git curl \
  php8.3-fpm php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl \
  php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath php8.3-redis
```

Если в репозитории Ubuntu нет PHP 8.3 — поставьте [ondrej/php](https://launchpad.net/~ondrej/+archive/ubuntu/php). Laravel 13 требует PHP ≥ 8.3.

Node.js 20+ нужен, если собираете фронт **на сервере**:

```bash
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

Composer:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

## 3. Пользователь и каталог

```bash
sudo adduser --disabled-password --gecos "" deploy
sudo usermod -aG www-data deploy
sudo mkdir -p /var/www/russkiy-mayak
sudo chown deploy:www-data /var/www/russkiy-mayak
```

Дальше под `deploy`:

```bash
cd /var/www/russkiy-mayak
git clone git@github.com:ORG/REPO.git .
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

Если фронт собираете на сервере:

```bash
npm ci
npm run build
```

Иначе скопируйте уже собранный `public/build` вместе с релизом.

---

## 4. PostgreSQL

```bash
sudo -u postgres psql
```

```sql
CREATE USER mayak WITH PASSWORD 'СИЛЬНЫЙ_ПАРОЛЬ';
CREATE DATABASE russkiy_mayak OWNER mayak;
GRANT ALL PRIVILEGES ON DATABASE russkiy_mayak TO mayak;
\q
```

На PostgreSQL 15+ может понадобиться:

```sql
\c russkiy_mayak
GRANT ALL ON SCHEMA public TO mayak;
```

---

## 5. `.env` продакшена

Минимально замените:

```env
APP_NAME="Русский Маяк"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ваш-домен.ru
APP_TIMEZONE=Europe/Moscow

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=russkiy_mayak
DB_USERNAME=mayak
DB_PASSWORD=СИЛЬНЫЙ_ПАРОЛЬ

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="info@ваш-домен.ru"
MAIL_FROM_NAME="Русский Маяк"

FILESYSTEM_DISK=local
```

Не копируйте локальный `APP_KEY`. Не оставляйте `MAIL_HOST=mailpit`.

---

## 6. Миграции и права

```bash
cd /var/www/russkiy-mayak
php artisan migrate --force --seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

`--seed` создаёт:

- админа `admin@russkiy-mayak.test` / `password` — **сразу смените** в `/admin`;
- страницы `/privacy` и `/reports`, если их ещё нет.

Не запускайте `DemoContentSeeder` на проде.

```bash
sudo chown -R deploy:www-data /var/www/russkiy-mayak
sudo find /var/www/russkiy-mayak -type d -exec chmod 755 {} \;
sudo find /var/www/russkiy-mayak -type f -exec chmod 644 {} \;
sudo chmod -R ug+rwx storage bootstrap/cache
```

---

## 7. Nginx

Файл `/etc/nginx/sites-available/russkiy-mayak`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name ваш-домен.ru www.ваш-домен.ru;
    root /var/www/russkiy-mayak/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;
    client_max_body_size 32M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/russkiy-mayak /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

SSL:

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d ваш-домен.ru -d www.ваш-домен.ru
```

После сертификата в `.env` должен быть `APP_URL=https://...`, затем `php artisan config:cache`.

---

## 8. Очередь и расписание

Письма с формы идут через очередь (`QUEUE_CONNECTION=database`).

`/etc/supervisor/conf.d/russkiy-mayak-worker.conf`:

```ini
[program:russkiy-mayak-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/russkiy-mayak/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopwaitsecs=3600
user=deploy
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/russkiy-mayak/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start russkiy-mayak-worker:*
```

Cron от `deploy`:

```bash
crontab -e
```

```cron
* * * * * cd /var/www/russkiy-mayak && php artisan schedule:run >> /dev/null 2>&1
```

---

## 9. Обязательно сразу после запуска

1. Откройте `https://ваш-домен.ru/admin`.
2. Смените email и пароль администратора.
3. **Настройки сайта → SEO:** выключите «Режим разработки» (иначе `noindex` и пустой sitemap).
4. Заполните контакты, реквизиты, QR, фото блока «О группе», OG-картинку.
5. Проверьте форму на главной и письмо во входящих.
6. Откройте `/privacy`, `/robots.txt`, `/sitemap.xml`.

---

## 10. Обновление сайта

```bash
cd /var/www/russkiy-mayak
php artisan down
git pull
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
php artisan up
```

Медиа лежат в `storage/app/public`. При переезде копируйте этот каталог и заново делайте `storage:link`.

---

## 11. Бэкап

Раз в сутки: дамп БД + `storage/app`.

```bash
pg_dump -U mayak -h 127.0.0.1 russkiy_mayak | gzip > /var/backups/mayak-$(date +%F).sql.gz
rsync -a /var/www/russkiy-mayak/storage/app /var/backups/mayak-storage-$(date +%F)/
```

Храните копии вне VPS.

---

## 12. Файрвол

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
```

PostgreSQL и Redis снаружи не открывайте.

Проверка после деплоя: `https://ваш-домен.ru/up` должен отвечать 200.
