# Sử dụng Image PHP 8.2 với Apache
FROM php:8.2-apache

# 1. Cài đặt các thư viện hệ thống cần thiết và Node.js (để build Vite)
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

# 2. Cài đặt PHP Extensions (Bao gồm MongoDB)
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 5. Copy toàn bộ code vào container
COPY . .

# 6. Cài đặt Dependencies (PHP & Node)
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 7. Cấu hình quyền ghi cho thư mục storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Cấu hình Apache Document Root trỏ vào public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 9. Bật mod_rewrite của Apache (để Laravel route hoạt động)
RUN a2enmod rewrite

# Cấu hình cho phép .htaccess hoạt động trong thư mục public
RUN echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf
RUN echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf
RUN echo "    AllowOverride All" >> /etc/apache2/apache2.conf
RUN echo "    Require all granted" >> /etc/apache2/apache2.conf
RUN echo "</Directory>" >> /etc/apache2/apache2.conf

# 10. Mở port 80
EXPOSE 80

# 11. Lệnh chạy khi khởi động
CMD ["apache2-foreground"]