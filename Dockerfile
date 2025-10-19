# Sử dụng image tích hợp NGINX và PHP-FPM. 
FROM richarvey/nginx-php-fpm:latest

# Copy toàn bộ code dự án và cấu hình NGINX
COPY . /var/www/html
COPY default.conf /etc/nginx/sites-enabled/default.conf

# Cấu hình môi trường cơ bản
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Cấu hình Laravel production và Composer
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV ASSET_URL ${RENDER_EXTERNAL_URL}
ENV COMPOSER_ALLOW_SUPERUSER 1


# Cài đặt các gói hệ thống cần thiết (Dependencies)
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    gd-dev \
    && rm -rf /var/cache/apk/*

# Cài đặt và kích hoạt các extension PHP (chỉ chạy 1 lần)
RUN docker-php-ext-install pdo_pgsql zip intl gd

# Thiết lập permissions cho thư mục storage (chỉ chạy 1 lần)
# Lệnh này phải chạy sau khi COPY code
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/bootstrap/cache


# Lệnh mặc định sẽ chạy /start.sh của base image
CMD ["/start.sh"]