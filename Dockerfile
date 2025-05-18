FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nginx supervisor libpq-dev libpng-dev libonig-dev libxml2-dev npm nodejs \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring zip exif pcntl bcmath

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install && npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

COPY ./conf/nginx/nginx-site.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
