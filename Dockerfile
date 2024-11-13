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

# Créer la structure de dossiers nécessaire
RUN mkdir -p /var/www/resources/js/Utils

# Copier tout le projet
COPY . .

# Debug: Afficher la structure avant l'installation
RUN echo "=== Structure des dossiers ===" && \
    ls -R /var/www/resources/js/ && \
    echo "=== Contenu du dossier Utils ===" && \
    ls -la /var/www/resources/js/Utils/

# Copy .env file
COPY .env.example .env

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Install NPM dependencies
RUN npm install

# Debug: Vérifier les fichiers node_modules
RUN echo "=== Node modules installés ===" && \
    ls -la /var/www/node_modules/

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