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

# Silence Apache ServerName warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# -------------------------------
# 2) App code
# -------------------------------
WORKDIR /var/www/html
COPY . /var/www/html

# -------------------------------
# 3) Apache VHOST -> /public
# -------------------------------
RUN printf '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>\n' > /etc/apache2/sites-available/000-default.conf

# -------------------------------
# 4) Composer install
# -------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# -------------------------------
# 5) Permissions
# -------------------------------
RUN mkdir -p /var/www/html/storage/logs && \
    chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache && \
    chmod -R 777 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

# -------------------------------
# 6) Expose + Temporary Runtime
# -------------------------------
EXPOSE 80

# 🔥 TEMPORARY CMD — rebuild full schema clean
CMD ["sh", "-lc", "\
    php artisan migrate:fresh --force --seed || true; \
    php artisan config:cache; \
    php artisan view:cache; \
    apache2-foreground \
"]