#!/bin/sh
set -e

# Pastikan file sqlite ada jika koneksi sqlite dipilih
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        touch /var/www/html/database/database.sqlite
        chown www-data:www-data /var/www/html/database/database.sqlite
        chmod 664 /var/www/html/database/database.sqlite
    fi
fi

# Clear & optimize caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Jalankan migrasi dan seeder otomatis jika diperintahkan atau first run
if [ "$RUN_MIGRATIONS" = "true" ] || [ ! -f /var/www/html/storage/installed.lock ]; then
    echo "Running migrations & seeders..."
    php artisan migrate --force || true
    php artisan db:seed --force || true
    touch /var/www/html/storage/installed.lock
fi

# Jalankan Apache
exec apache2-foreground
