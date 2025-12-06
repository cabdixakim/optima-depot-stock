# -----------------------------
# Base PHP + Apache image
# -----------------------------
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# -----------------------------
# System dependencies
# -----------------------------
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    git \
    curl

# -----------------------------
# PHP Extensions
# -----------------------------
# Install PostgreSQL driver + optional MySQL
RUN docker-php-ext-install pdo_pgsql pdo_mysql

# Install additional extensions Laravel commonly needs
RUN docker-php-ext-install zip

# Enable Apache rewrite
RUN a2enmod rewrite

# -----------------------------
# Copy source code
# -----------------------------
COPY . .

# -----------------------------
# Install Composer
# -----------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies (no dev packages)
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress

# -----------------------------
# Laravel optimizations
# -----------------------------
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# -----------------------------
# Set correct permissions
# -----------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# -----------------------------
# Expose port
# -----------------------------
EXPOSE 80

# -----------------------------
# Apache starts when container starts
# -----------------------------
CMD ["apache2-foreground"]