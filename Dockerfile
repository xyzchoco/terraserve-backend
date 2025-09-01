# Gunakan base image PHP + Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libsodium-dev \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi dan install ekstensi PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        sodium \
        intl \
        xml

# Aktifkan Apache mod_rewrite (dibutuhkan Laravel untuk routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy composer dari official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file project ke dalam container
COPY . .

# Set permission storage dan bootstrap agar bisa ditulis Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Jalankan Apache di port 8080 (Railway default pakai $PORT)
CMD ["apache2-foreground"]
