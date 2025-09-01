# Gunakan PHP 8.2 FPM dengan ekstensi dasar
FROM php:8.2-fpm

# Install dependencies system
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install \
    pdo_mysql \
    zip \
    intl \
    bcmath \
    gd \
    opcache \
    sockets

# Install ekstensi tambahan yang sering dipakai Laravel + Filament
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-install sodium

# Copy composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk storage & bootstrap
RUN chmod -R 777 storage bootstrap/cache

# Expose port 8000 untuk Railway
EXPOSE 8000

# Jalankan Laravel dengan PHP artisan serve
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
