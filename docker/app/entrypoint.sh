#!/bin/sh
set -e
# Права для записи скомпилированных view, cache, logs (PHP-FPM работает от www-data)
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache 2>/dev/null || true
exec "$@"
