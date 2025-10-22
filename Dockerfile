FROM php:8.2-fpm

# Instal ekstensi Laravel yang dibutuhkan
RUN apt-get update && apt-get install -y \
    git zip unzip curl libpng-dev libjpeg-dev libfreetype6-dev libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd dom

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file project ke dalam container
COPY . .

# Beri izin folder storage dan bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Tambahkan safe.directory agar git tidak error
RUN git config --global --add safe.directory /var/www/html

# Install dependensi Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Jalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
