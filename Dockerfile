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

# Copier d'abord les fichiers essentiels
COPY composer.json composer.lock package.json package-lock.json ./
COPY resources/ ./resources/

# Debug: Vérifier la structure après la copie des resources
RUN echo "=== Vérification des fichiers initiaux ===" && \
    ls -la /var/www/resources/js/Utils/ || echo "Utils directory not found"

# Copier le reste du projet
COPY . .

# Debug: Vérifier à nouveau après la copie complète
RUN echo "=== Vérification après copie complète ===" && \
    ls -la /var/www/resources/js/Utils/ || echo "Utils directory still not found"

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist
RUN npm install

# Debug: Vérifier après l'installation des dépendances
RUN echo "=== Vérification après npm install ===" && \
    ls -la /var/www/resources/js/Utils/ || echo "Utils directory missing after install"

# Build assets
RUN npm run build

# Copy .env file
COPY .env.example .env

# Generate key
RUN php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000