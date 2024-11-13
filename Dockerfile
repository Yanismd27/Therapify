FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files first
COPY composer.json composer.lock ./

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy the rest of the application
COPY . .

# Create necessary directories
RUN mkdir -p /var/www/storage/framework/sessions \
    /var/www/storage/framework/views \
    /var/www/storage/framework/cache \
    /var/www/bootstrap/cache

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy .env and generate key
COPY .env.example .env
RUN php artisan key:generate --force

# Change ownership
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]