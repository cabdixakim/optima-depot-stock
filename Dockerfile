# ---------------------------------
# Base PHP + Apache image
# ---------------------------------
FROM php:8.2-apache

# ---------------------------------
# 1) System deps + PHP extensions
#    (MySQL only; pgsql not needed now)
# ---------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli intl gd zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Optional: silence Apache "ServerName" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ---------------------------------
# 2) App code
# ---------------------------------
WORKDIR /var/www/html
COPY . /var/www/html

# ---------------------------------
# 3) Composer install
#    (public/build already committed from local)
# ---------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs

# ---------------------------------
# 4) Permissions for storage/cache/logs
# ---------------------------------
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R ug+rwx \
        storage \
        bootstrap/cache

# ---------------------------------
# 5) Expose + runtime command
# ---------------------------------
EXPOSE 80

CMD ["sh", "-lc", "\
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache || true && \
    php artisan view:cache && \
    apache2-foreground \
"]