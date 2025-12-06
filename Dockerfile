# Base PHP + Apache image
FROM php:8.2-apache

# --------------------------------------------------------
# 1) System dependencies + PHP extensions + Node (for Vite)
# --------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    gnupg \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli intl gd zip \
    && docker-php-ext-install pdo_pgsql pgsql \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Node.js (for npm run build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------------
# 2) App code
# --------------------------------------------------------
WORKDIR /var/www/html
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
# 4) Composer install (ignore platform requirements) + Vite build
# --------------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

RUN npm install --omit=dev && npm run build

# Permissions for storage, cache, and built assets
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/public/build

# --------------------------------------------------------
# 5) Runtime: migrate + seed + cache + start Apache
# --------------------------------------------------------
EXPOSE 80

CMD ["sh", "-lc", "\
    php artisan migrate --force || true; \
    php artisan db:seed --class=AdminUserSeeder --force || true; \
    php artisan config:cache; \
    php artisan route:cache; \
    php artisan view:cache; \
    apache2-foreground \
"]