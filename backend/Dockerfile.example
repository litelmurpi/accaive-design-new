FROM php:8.3-cli-alpine

# Install system dependencies & PostgreSQL driver
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    icu-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql intl zip pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Create storage directory structure & permissions
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/app/public \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Start command
CMD php artisan config:clear && php artisan migrate --force && php artisan db:seed --class=ProductionDataSeeder && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
