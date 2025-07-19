# Dockerfile para Laravel (inspirado en Laravel Sail) usando PHP 8.4
FROM php:8.4-fpm

# Instala dependencias del sistema
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        zip \
        unzip \
        libzip-dev \
        libpq-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libssl-dev \
        nodejs \
        npm \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip opcache intl

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala Node.js (v18 LTS) y npm si no está en el sistema
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copia archivos de la app
COPY . /var/www
WORKDIR /var/www

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expone el puerto 9000 para PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
