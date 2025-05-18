FROM php:8.2-fpm

WORKDIR /var/www/html

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nginx supervisor libpq-dev \
    libpng-dev libonig-dev libxml2-dev npm nodejs \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath

COPY composer.json composer.lock ./

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

ENV COMPOSER_MEMORY_LIMIT=-1

# Копируем проект
COPY . .

# Установка PHP-зависимостей
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Установка JS-зависимостей
RUN npm install && npm run build

# Настройки прав
RUN chown -R www-data:www-data storage bootstrap/cache

# Копируем конфиги nginx и supervisor
COPY ./conf/nginx/nginx-site.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisord.conf"]
