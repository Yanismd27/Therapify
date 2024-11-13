FROM composer:latest AS composer
WORKDIR /app
COPY composer.* ./
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist

FROM node:20-alpine AS node
WORKDIR /app
COPY package*.json ./
COPY --from=composer /app/vendor ./vendor
COPY . .
RUN npm install --legacy-peer-deps
RUN npm run build

FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

# PHP Extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy from previous stages
COPY --from=composer /app/vendor ./vendor
COPY --from=node /app/public/build ./public/build
COPY . .

# Set environment
COPY .env.example .env
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]