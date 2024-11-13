FROM node:20-alpine as node-builder
WORKDIR /app
COPY package*.json ./
COPY resources/ resources/
COPY public/ public/
COPY vite.config.js ./
RUN npm install
COPY . .
RUN npm run build

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
    npm

# PHP Extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files
COPY composer.* ./
RUN composer install --no-dev --no-interaction --prefer-dist

# Copy application files
COPY . .
COPY --from=node-builder /app/public/build public/build

# Set environment
COPY .env.example .env
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]