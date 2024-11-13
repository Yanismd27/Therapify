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

# Copier les fichiers de configuration d'abord
COPY composer.json composer.lock package.json package-lock.json ./

# Créer la structure de dossiers
RUN mkdir -p /var/www/resources/js/Utils

# Copier spécifiquement le fichier toast
COPY resources/js/Utils/toast.js /var/www/resources/js/Utils/
COPY resources/js/Utils/toast.css /var/www/resources/js/Utils/

# Copier le reste du projet
COPY . .

# Debug: Vérifier que le fichier existe
RUN ls -la /var/www/resources/js/Utils/toast.js

# Copy .env file
COPY .env.example .env

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist
RUN npm install

# Build assets
RUN npm run build

# Generate key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000