# Sử dụng image tích hợp NGINX và PHP-FPM
FROM richarvey/nginx-php-fpm:latest

# Cài đặt các gói hệ thống cần thiết
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    gd-dev \
    && rm -rf /var/cache/apk/*

# Cài đặt và kích hoạt các extension PHP
RUN docker-php-ext-install pdo_pgsql zip intl gd

# Copy code
COPY . /var/www/html

# Copy cấu hình NGINX
COPY default.conf /etc/nginx/sites-enabled/default.conf

# Cấu hình môi trường
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV ASSET_URL ${RENDER_EXTERNAL_URL}

# Copy script deploy vào thư mục mà base image sẽ chạy
COPY 00-laravel-deploy.sh /docker-entrypoint.d/00-laravel-deploy.sh
RUN chmod +x /docker-entrypoint.d/00-laravel-deploy.sh

# Thiết lập permissions (PHẢI chạy sau khi copy code)
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Lệnh mặc định sẽ chạy /start.sh của base image
# /start.sh sẽ tự động chạy script 00-laravel-deploy.sh
CMD ["/start.sh"]