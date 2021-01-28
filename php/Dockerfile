FROM php:7.4-fpm
RUN apt-get update
RUN docker-php-ext-install mysqli
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer self-update