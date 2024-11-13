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
    npm \
    tree

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copier tout le projet
COPY . .

# Copier et renommer le .env.example en .env
COPY .env.example .env

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist
RUN npm install

# Create Utils directory if it doesn't exist
RUN mkdir -p /var/www/resources/js/Utils

# Copy toast files explicitly
COPY resources/js/utils/toast.js /var/www/resources/js/Utils/
COPY resources/js/utils/toast.css /var/www/resources/js/Utils/

# Build assets
RUN npm run build

# Generate application key (avec --force pour éviter les problèmes de fichier .env)
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000