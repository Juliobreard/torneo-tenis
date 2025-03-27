FROM php:8.2-fpm


RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN [ -d "/var/www/.git" ] || git clone https://github.com/Juliobreard/torneo-tenis.git /var/www


WORKDIR /var/www

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponer el puerto 9000 para Nginx
EXPOSE 9000

# iniciar PHP-FPM
CMD ["php-fpm"]
