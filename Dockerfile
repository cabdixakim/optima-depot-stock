FROM php:8.2-cli

# Install system dependencies and PHP extensions needed by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring intl bcmath zip \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy the entire project (including vendor and public/build if you committed them)
COPY . .

# Render expects the app to listen on this port
ENV PORT=10000

# Start Laravel's built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
