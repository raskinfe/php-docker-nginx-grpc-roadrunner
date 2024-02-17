FROM ghcr.io/roadrunner-server/roadrunner:2023.3.11 AS roadrunner
ENV RR_MODE=http

FROM php:fpm-alpine

# Install Linux kernel headers
RUN apk add --no-cache linux-headers

# Install required PHP extensions
RUN docker-php-ext-install sockets pdo pdo_mysql

# Copy your application files
COPY ./ /var/www/html/

# Copy Composer binary from Composer image
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

# Set COMPOSER_ALLOW_SUPERUSER environment variable
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install dependencies
RUN composer install --no-scripts --no-autoloader

# Generate the Composer autoloader files
RUN composer dump-autoload --optimize
