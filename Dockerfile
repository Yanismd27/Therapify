FROM php:8.2-fpm-alpine

# Install system dependencies and nginx
RUN apk add --no-cache \
    nginx \
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
COPY composer.* ./

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Configure nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Create necessary directories and set permissions
RUN mkdir -p /var/www/storage/framework/{sessions,views,cache} \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy and set up environment file
COPY .env.production .env
RUN php artisan key:generate --force

# Create start script
RUN echo '#!/bin/sh' > /start.sh \
    && echo 'php artisan config:cache' >> /start.sh \
    && echo 'php artisan route:cache' >> /start.sh \
    && echo 'php artisan view:cache' >> /start.sh \
    && echo 'php-fpm &' >> /start.sh \
    && echo 'nginx -g "daemon off;"' >> /start.sh \
    && chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]