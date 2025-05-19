FROM php:8.2-fpm

# Рабочая директория
WORKDIR /var/www/html

# Установка системных зависимостей и PHP-расширений
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nginx supervisor libpq-dev \
    libpng-dev libonig-dev libxml2-dev npm nodejs \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring zip exif pcntl bcmath

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Копирование всех файлов проекта
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Установка JS-зависимостей и сборка
RUN npm install && npm run build

# Права на storage и bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Nginx + supervisor (настройки должны быть добавлены отдельно)
COPY ./conf/nginx/nginx-site.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisord.conf

# Запуск
CMD ["supervisord", "-c", "/etc/supervisord.conf"]
