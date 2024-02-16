FROM php:fpm-alpine
RUN docker-php-ext-install opcache pdo pdo_mysql
COPY ./ /var/www/html/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer install --no-scripts --no-autoloader

# Generate the Composer autoloader files
RUN composer dump-autoload --optimize

