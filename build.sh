#!/usr/bin/env bash
# Thoát ngay nếu có lỗi
set -o errexit

echo "Bat dau build..."

# 1. Cài đặt dependencies
composer install --no-dev --no-interaction --optimize-autoloader

# 2. Tạo cache cho config, route, view (quan trọng cho production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Chạy migrations để tạo bảng (bao gồm bảng users)
# --force là bắt buộc vì đang ở môi trường production
php artisan migrate --force

php artisan db:seed --force
echo "Build hoan tat!"