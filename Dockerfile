FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd


WORKDIR /var/www/html
COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# NGINX
COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Exponer el puerto 80 para HTTP
EXPOSE 80

# Iniciar NGINX y PHP-FPM
CMD service nginx start && php-fpm
