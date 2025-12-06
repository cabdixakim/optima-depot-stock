FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Enable needed PHP extensions
RUN docker-php-ext-install pdo_mysql

# Copy application code into the container
COPY . .

# Apache: make "public" the document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

# Enable mod_rewrite for Laravel pretty URLs
RUN a2enmod rewrite

# Permissions for storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache || true

CMD ["apache2-foreground"]