FROM php:8.2-apache

WORKDIR /var/www/html

# System packages
RUN apt-get update && apt-get install -y \
    zip unzip libpq-dev libzip-dev libonig-dev git curl

# PHP Extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql zip

# Enable rewrite
RUN a2enmod rewrite

# Set DocumentRoot to /public
RUN sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-available/000-default.conf

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy project
COPY . .

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress

# Laravel optimize
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]