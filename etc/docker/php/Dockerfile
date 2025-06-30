FROM php:8.4-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apk update && \
   apk add --no-cache postgresql-dev \
       && docker-php-ext-install pdo pdo_pgsql bcmath


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --chown=www-data:www-data . .
