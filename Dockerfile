# Base PHP + Apache image
FROM php:8.2-apache

# --------------------------------------------------------
# 1) System dependencies + PHP extensions
# --------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli intl gd zip \
    && docker-php-ext-install pdo_pgsql pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------------
# 2) App code
# --------------------------------------------------------
WORKDIR /var/www/html

# Copy application code into the container
COPY . /var/www/html

# --------------------------------------------------------
# 3) Apache vhost -> point to /public
# --------------------------------------------------------
RUN printf '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

# --------------------------------------------------------
# 4) Composer
# --------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Permissions for storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies (production)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# --------------------------------------------------------
# 5) Runtime: migrate + cache + start Apache
# --------------------------------------------------------
EXPOSE 80

# At container start:
#  - run migrations against Railway Postgres (ignore if they fail)
#  - cache config/routes/views
#  - start Apache in foreground
CMD ["sh", "-lc", "php artisan migrate --force || true; php artisan config:cache; php artisan route:cache; php artisan view:cache; apache2-foreground"]