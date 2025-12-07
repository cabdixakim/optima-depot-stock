# -------------------------------
# Base PHP + Apache image
# -------------------------------
FROM php:8.2-apache

# -------------------------------
# 1) System deps + PHP extensions
# -------------------------------
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

# Silence Apache "ServerName" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# -------------------------------
# 2) App code
# -------------------------------
WORKDIR /var/www/html
COPY . /var/www/html

# -------------------------------
# 3) Apache vhost -> point to /public
# -------------------------------
RUN rm -f /etc/apache2/sites-enabled/000-default.conf \
    && printf '<VirtualHost *:80>\n\
        ServerName localhost\n\
        DocumentRoot /var/www/html/public\n\
        <Directory /var/www/html/public>\n\
            AllowOverride All\n\
            Order allow,deny\n\
            Allow from all\n\
            Require all granted\n\
        </Directory>\n\
    </VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf \
    && ln -s /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# -------------------------------
# 4) Composer install
#    (assets already built locally: public/build committed)
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# -------------------------------
# 5) Permissions for storage, cache, logs
# -------------------------------
RUN mkdir -p /var/www/html/storage/logs && \
    chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache && \
    chmod -R 777 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

# -------------------------------
# 6) Expose + runtime command
# -------------------------------
EXPOSE 80

CMD ["sh", "-lc", "\
    php artisan migrate --force || true; \
    php artisan config:cache; \
    php artisan route:cache; \
    php artisan view:cache; \
    apache2-foreground \
"]