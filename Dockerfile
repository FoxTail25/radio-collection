# --- Этап 1: Сборка фронтенда (Полноценный Debian, где npm не падает) ---
FROM node:24 AS frontend-builder
WORKDIR /app
COPY package*.json ./

# Чистая установка без строгих конфликтов peer-зависимостей
RUN npm install --legacy-peer-deps
COPY . .
RUN npm run build

# --- Этап 2: Сборка веб-сервера и PHP (Легковесный Alpine для экономии места) ---
FROM php:8.4-fpm-alpine

# Устанавливаем системные зависимости для Laravel, SQLite и Nginx
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
    sqlite-dev \
    icu-dev \
    nginx

# Устанавливаем и настраиваем расширения PHP (включая intl для Filament и pdo_sqlite)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip pcntl intl

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Задаем рабочую директорию
WORKDIR /var/www

# Копируем исходники проекта
COPY . /var/www

# Копируем скомпилированный фронтенд (Vue) из первого этапа
COPY --from=frontend-builder /app/public/build /var/www/public/build

# Настраиваем права для Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Копируем конфигурацию Nginx внутрь контейнера Alpine
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

EXPOSE 80

# Финальная команда: устанавливаем зависимости Composer, создаем БД (если её нет) и запускаем Nginx + PHP-FPM
CMD sh -c "composer install --no-dev --optimize-autoloader --no-interaction && \
           mkdir -p database && touch database/database.sqlite && \
           chown -R www-data:www-data database/database.sqlite database && \
           php-fpm -D && nginx -g 'daemon off;'"
