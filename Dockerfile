FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libzip-dev \
    git \
    unzip
    
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

#COPY docker/nginx/default.conf /etc/nginx/sites-available/default
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf


# Dar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

# Comando de inicio (supervisord para manejar PHP-FPM y Nginx en el mismo contenedor)
CMD ["sh", "-c", "service nginx start && php-fpm"]
