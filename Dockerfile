FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    ${PHPIZE_DEPS} \
    oniguruma-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd zip mbstring xml

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy entire project
COPY . .

# Create required directories and set permissions
RUN mkdir -p bootstrap/cache storage/framework/{sessions,views,cache}
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Install Composer dependencies
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install --legacy-peer-deps
RUN npm run build

# Copy environment file
RUN cp .env.example .env

# Generate application key
RUN php artisan key:generate --force

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]