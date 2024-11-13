FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd opcache

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
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy .env and generate key
COPY .env.example .env
RUN php artisan key:generate --force

# Configure PHP
RUN echo "php_flag[display_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf
RUN echo "catch_workers_output = yes" >> /usr/local/etc/php-fpm.d/www.conf

# Create start script
RUN echo '#!/bin/sh' > /start.sh
RUN echo 'php artisan optimize:clear' >> /start.sh
RUN echo 'php artisan optimize' >> /start.sh
RUN echo 'php artisan serve --host=0.0.0.0 --port=8000' >> /start.sh
RUN chmod +x /start.sh

# Add healthcheck
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000 || exit 1

EXPOSE 8000

CMD ["/start.sh"]