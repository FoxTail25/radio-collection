FROM php:8.4-fpm-alpine

# Устанавливаем системные зависимости для Laravel и SQLite
RUN apk add --no-cache \
    alpine-sdk \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    curl \
    sqlite-dev

# Устанавливаем расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip pcntl

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Задаем рабочую директорию
WORKDIR /var/www

# Копируем файлы проекта
COPY . /var/www

# Устанавливаем права для Laravel (папки storage и cache должны быть доступны для записи)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

# Изменяем финальную команду: сначала ставим зависимости, затем запускаем php-fpm
CMD sh -c "composer install --no-dev --optimize-autoloader --no-interaction && php-fpm"
