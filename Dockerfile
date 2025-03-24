FROM php:8.2-fpm


RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev libzip-dev git unzip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


COPY . /var/www/html


WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto en el que correrá el servicio PHP-FPM
EXPOSE 9000

COPY nginx/default.conf /etc/nginx/conf.d/default.conf

# Exponer el puerto 80 para Nginx
EXPOSE 80

# Comando para iniciar PHP-FPM y Nginx
CMD service nginx start && php-fpm
