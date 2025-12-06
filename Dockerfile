FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set correct Apache VirtualHost (IMPORTANT FIX)
RUN printf "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog \${APACHE_LOG_DIR}/error.log\n\
    CustomLog \${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Fix storage + cache permissions
RUN chmod -R 777 storage bootstrap/cache

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]