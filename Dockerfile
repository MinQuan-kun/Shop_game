# Sử dụng Image PHP 8.2 với Apache
FROM php:8.2-apache

# 1. Cài đặt các thư viện hệ thống
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libssl-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. Cài đặt MongoDB và MySQL
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 5. Copy toàn bộ code vào
COPY . .

# 6. Cài đặt Dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts
RUN npm install
RUN npm run build

# 7. Cấu hình quyền ghi
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Cấu hình Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 9. Bật mod_rewrite
RUN a2enmod rewrite

# Cấu hình .htaccess
RUN echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf
RUN echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf
RUN echo "    AllowOverride All" >> /etc/apache2/apache2.conf
RUN echo "    Require all granted" >> /etc/apache2/apache2.conf
RUN echo "</Directory>" >> /etc/apache2/apache2.conf

# 10. Mở port 80
EXPOSE 80

# 11. THÊM SCRIPT KHỞI CHẠY
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]