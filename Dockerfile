FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev

RUN docker-php-ext-install pdo_mysql bcmath gd

WORKDIR /var/www

COPY . .
COPY .env.example .env

RUN php artisan key:generate --force
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]