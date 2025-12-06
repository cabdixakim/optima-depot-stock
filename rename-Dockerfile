FROM php:8.2-cli

WORKDIR /var/www/html

# Install PHP extensions you actually need (Postgres here)
RUN apt-get update && apt-get install -y \
    libpq-dev \
 && docker-php-ext-install pdo pdo_pgsql

# Copy everything (including vendor) into the container
COPY . .

# Permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]