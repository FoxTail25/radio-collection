# ==============================================================================
# ЭТАП 1: Сборка зависимостей (Heavy Builder)
# ==============================================================================
FROM php:8.4-fpm-alpine AS builder

# Устанавливаем ВСЕ необходимые инструменты для сборки
RUN apk add --no-cache \
    alpine-sdk \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    sqlite-dev \
    icu-dev \
    git

# Компилируем и устанавливаем расширения PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip pcntl intl

# Ставим Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Копируем ТОЛЬКО файлы зависимостей (для кэширования слоев Docker)
COPY composer.json composer.lock ./

# Устанавливаем продакшн-зависимости прямо на этапе сборки образа!
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# ==============================================================================
# ЭТАП 2: Чистый Продакшн (Lightweight Production)
# ==============================================================================
FROM php:8.4-fpm-alpine

# На продакшне нам нужны только системные библиотеки (без компиляторов и git!)
RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    libzip \
    sqlite-libs \
    icu-libs \
    nginx

# Магия: копируем УЖЕ СКОМПИЛИРОВАННЫЕ расширения из первого этапа (builder)
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /var/www

# Копируем исходный код проекта
COPY . /var/www

# Магия 2: копируем УЖЕ СКАЧАННУЮ папку vendor из первого этапа
COPY --from=builder /var/www/vendor /var/www/vendor

# Настраиваем права и конфиг Nginx
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

# Финальная команда стала чище и быстрее: никаких composer install!
# Контейнер запускается мгновенно, за доли секунды.
CMD sh -c "mkdir -p database && touch database/database.sqlite && \
           chown -R www-data:www-data database/database.sqlite database && \
           php-fpm -D && nginx -g 'daemon off;'"
