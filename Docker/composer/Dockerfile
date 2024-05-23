FROM php:8.2-fpm

WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./composer.json ./composer.lock /var/www/html/

RUN composer install --ignore-platform-reqs

RUN php artisan key:generate