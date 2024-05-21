FROM php:8.1-apache AS backend

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip

RUN a2enmod rewrite

COPY ./composer.json ./composer.lock /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer update --no-scripts --no-autoloader

COPY . /var/www/html

RUN composer install # --no-scripts --no-autoloader

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
EXPOSE 8000

# CMD ["apache2-foreground"]
#RUN php artisan migrate

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]



