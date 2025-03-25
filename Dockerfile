FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev libzip-dev git unzip nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

COPY docker/nginx/default.conf /etc/nginx/sites-available/default

# Crear enlace simbólico para que Nginx reconozca la configuración
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Dar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Comando de inicio (supervisord para manejar PHP-FPM y Nginx en el mismo contenedor)
CMD ["sh", "-c", "service nginx start && php-fpm"]
