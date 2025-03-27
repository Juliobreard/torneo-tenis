FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y git unzip curl libpq-dev libpng-dev libjpeg-dev libfreetype6-dev

# Configurar el directorio de trabajo
WORKDIR /var/www

# Eliminar archivos previos y clonar el repositorio
RUN rm -rf /var/www/* && \
    git clone https://github.com/Juliobreard/torneo-tenis.git /var/www

# Establecer permisos
RUN chown -R www-data:www-data /var/www

# Instalar Composer y dependencias
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto
EXPOSE 9000

# Comando por defecto
CMD ["php-fpm"]
