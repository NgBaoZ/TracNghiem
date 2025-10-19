#!/usr/bin/env bash
# Thoát ngay nếu có lỗi
set -o errexit

echo "Bat dau Build..."

# 1. Cài đặt dependencies (không cài gói dev)
composer install --no-dev --no-interaction --optimize-autoloader

# 2. Tạo cache (quan trọng cho production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Chạy migrations (tạo bảng users, v.v...)
php artisan migrate --force

echo "Build hoan tat!"