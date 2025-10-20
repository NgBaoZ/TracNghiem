#!/usr/bin/env bash
set -o errexit

echo "Bat dau deploy script (trong Docker)..."

# 1. Cài đặt Composer
echo "Dang chay composer install..."
cd /var/www/html
composer install --no-dev --no-interaction --optimize-autoloader

# 2. Tạo cache
echo "Dang tao cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Chạy migrations
echo "Dang chay migrations..."
php artisan migrate --force

echo "Hoan tat script deploy."