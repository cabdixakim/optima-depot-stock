# ---- Base image ----
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring intl bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install PHP dependencies (Composer)
# --ignore-platform-reqs avoids failing on minor extension version differences
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --ignore-platform-reqs

# Cache config/routes/views (ignore first-run failures)
RUN php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

# Port Render expects
ENV PORT=10000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]