#!/usr/bin/env bash

echo "Bắt đầu triển khai Laravel..."

# 1. Cài đặt các thư viện Composer (bỏ qua dev dependencies)
echo "Running composer install..."
composer install --no-dev --working-dir=/var/www/html

echo "Clearing all caches..."
# Xóa tất cả các loại cache để tránh xung đột
php artisan optimize:clear 
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo "Caching production config..."



# 3. Chạy Database Migrations
echo "Running migrations..."
php artisan migrate --force

echo "Triển khai Laravel hoàn tất."