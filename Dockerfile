FROM php:8.4-fpm
# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos de dependencias
COPY composer.json composer.lock* ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copiar código del proyecto
COPY . .
RUN composer dump-autoload --optimize

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# EXPONER EL PUERTO DE ARTISAN SERVE
EXPOSE 8000

# COMANDO PARA LEVANTAR EL SERVIDOR INTERNO
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
