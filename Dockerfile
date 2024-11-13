FROM node:20 as build

WORKDIR /app

# Copier les fichiers de configuration
COPY package*.json ./
COPY vite.config.js ./
COPY composer.* ./
COPY resources/ ./resources/
COPY public/ ./public/

# Installer les dépendances npm
RUN npm install

# Copier le reste des fichiers source
COPY . .

# Build
RUN npm run build

# Second stage
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files
COPY composer.* ./

# Install composer dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Copy the rest of the application
COPY . .

# Copy built assets from node stage
COPY --from=build /app/public/build ./public/build

# Copy .env file
COPY .env.example .env

# Generate key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]