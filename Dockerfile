# -------------------------------------------------
# Base PHP image
# -------------------------------------------------
FROM php:8.2-cli

# Install system packages and PHP extensions needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring intl bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Allow Composer to run as root inside the container
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install Composer (from official image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# -------------------------------------------------
# Install PHP dependencies WITHOUT running scripts
# (avoids php artisan hooks failing during build)
# -------------------------------------------------

# Copy only composer files first (for better Docker caching)
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --ignore-platform-reqs

# Now copy the rest of the application code
COPY . .

# Expose the port Render expects
ENV PORT=10000

# Default command: start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]