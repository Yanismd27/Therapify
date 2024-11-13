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

# Créer la structure explicitement
RUN mkdir -p /var/www/resources/js/Utils

# Copier le projet en plusieurs étapes
COPY resources/js/Utils/toast.js /var/www/resources/js/Utils/
COPY resources/js/Utils/toast.css /var/www/resources/js/Utils/

# Debug: Vérifier les fichiers copiés
RUN echo "=== Contenu de /var/www/resources/js/Utils ===" && \
    ls -la /var/www/resources/js/Utils/

# Copier le reste du projet
COPY . .

# Debug: Vérifier que les fichiers sont toujours là
RUN echo "=== Vérification après copie complète ===" && \
    ls -la /var/www/resources/js/Utils/

# Copy .env file
COPY .env.example .env

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Debug: Vérifier avant npm install
RUN echo "=== Vérification avant npm install ===" && \
    ls -la /var/www/resources/js/Utils/

RUN npm install

# Debug: Vérifier après npm install
RUN echo "=== Vérification après npm install ===" && \
    ls -la /var/www/resources/js/Utils/

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