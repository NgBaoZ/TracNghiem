#!/usr/bin/env bash

echo "Bắt đầu triển khai Laravel..."

# 1. Cài đặt các thư viện Composer (bỏ qua dev dependencies)
echo "Running composer install..."
composer install --no-dev --working-dir=/var/www/html

# 2. Xóa các cache cũ và tạo cache mới
echo "Clearing and caching configuration, routes, and views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# 3. Chạy Database Migrations
echo "Running migrations..."
php artisan migrate --force

echo "Triển khai Laravel hoàn tất."