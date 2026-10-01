FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
  git curl zip unzip libzip-dev libonig-dev libxml2-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip bcmath ctype fileinfo xml

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set DocumentRoot to /app/public
RUN sed -i 's|/var/www/html|/app/public|g' /etc/apache2/sites-available/000-default.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction

COPY . .

RUN composer dump-autoload --optimize

RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
  && chmod -R a+rw storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "php artisan optimize:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]