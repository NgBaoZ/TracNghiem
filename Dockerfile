# Sử dụng image tích hợp NGINX và PHP-FPM. 
# Luôn dùng bản mới nhất để đảm bảo tương thích PHP
FROM richarvey/nginx-php-fpm:latest

# Copy toàn bộ code dự án vào thư mục /var/www/html trong container
COPY . /var/www/html

# Cấu hình môi trường và Laravel
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Cho phép Composer chạy với quyền root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Cài đặt một số extension PHP phổ biến (nếu cần) và Composer
# (Tùy chọn: Nếu bạn cần các extension khác, thêm vào đây)
RUN install-php-extensions pdo_pgsql gd intl zip

# Thiết lập permissions cho thư mục storage
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Cấu hình Laravel production
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV ASSET_URL ${RENDER_EXTERNAL_URL}

# Cho phép Composer chạy với quyền root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Thiết lập permissions cho thư mục storage
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Lệnh mặc định sẽ chạy /start.sh của base image
CMD ["/start.sh"]