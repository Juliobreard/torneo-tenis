FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

RUN rm -rf /var/www/* && \
    git clone https://github.com/Juliobreard/torneo-tenis.git /var/www

COPY .env /var/www/.env

RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www

RUN php artisan key:generate

EXPOSE 9000

CMD ["php-fpm"]
