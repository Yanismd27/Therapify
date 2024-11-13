FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    nginx \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libxml2-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql bcmath gd

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy everything
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN chmod -R 775 storage bootstrap/cache

# Configure environment
RUN cp .env.example .env
RUN php artisan key:generate --force

# Nginx config
RUN echo 'server { \n\
    listen 80; \n\
    root /var/www/public; \n\
    index index.php; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/http.d/default.conf

# Start script
RUN echo '#!/bin/sh' > /start.sh && \
    echo 'php-fpm &' >> /start.sh && \
    echo 'nginx -g "daemon off;"' >> /start.sh && \
    chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]