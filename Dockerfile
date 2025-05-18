FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nginx supervisor libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

COPY . /var/www/html

COPY ./conf/nginx/nginx-site.conf /etc/nginx/sites-available/default

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["supervisord", "-n"]

RUN composer require laravel/sanctum

