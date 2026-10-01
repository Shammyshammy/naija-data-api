FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libonig-dev libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip bcmath ctype fileinfo xml

# Enable mod_rewrite for Laravel routing and point Apache at the public directory
RUN a2enmod rewrite \
    && sed -ri 's!/var/www/html!/app/public!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!/var/www/!/app/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && printf '<Directory /app/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

COPY . .
RUN composer dump-autoload --optimize

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache

EXPOSE 80

# Railway provides $PORT; make Apache listen on it (defaults to 80), run migrations, then start Apache
CMD ["sh", "-c", "sed -i \"s/Listen 80/Listen ${PORT:-80}/\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT:-80}>/\" /etc/apache2/sites-available/000-default.conf && php artisan optimize:clear && php artisan migrate --force && apache2-foreground"]
