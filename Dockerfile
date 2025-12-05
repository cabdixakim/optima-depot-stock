# ---- Base image ----
FROM php:8.2-cli

# Install system dependencies (includes Node + pgsql driver)
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer (from official composer image)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files into container
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build front-end (if you use Vite / npm)
RUN npm install && npm run build

# Cache config/routes/views (allow failures on fresh env)
RUN php artisan config:cache || true \
 && php artisan route:cache || true \
 && php artisan view:cache || true

# Render will expose this port
ENV PORT=10000

# Start Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]