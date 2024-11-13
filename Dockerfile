FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copier d'abord les fichiers de configuration
COPY package*.json ./
COPY composer.json composer.lock ./
COPY vite.config.js ./

# Installer les dépendances avant de copier le reste des fichiers
RUN composer install --no-dev --no-interaction --prefer-dist
RUN npm install

# Copier le reste du projet
COPY . .

# S'assurer que les répertoires existent
RUN mkdir -p /var/www/resources/js/Utils
RUN mkdir -p /var/www/public/build

# Vérifier si les fichiers sont bien copiés
RUN ls -la /var/www/resources/js/Utils/

# Build assets
RUN npm run build

# Copy environment file
COPY .env.example .env

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache