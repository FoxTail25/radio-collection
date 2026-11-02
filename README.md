# Radio Collection (Сборник интернет-радиостанций)

Удобный веб-интерфейс для прослушивания и каталогизации интернет-радиостанций. Проект разработан на современном технологическом стеке и полностью готов к контейнеризации.

**Демо-версия:** [radio.foxtail25.ru](https://radio.foxtail25.ru)

---

## 🛠 Стек технологий

Проект построен на базе экосистемы Laravel и современных фронтенд-инструментов:

*   **Backend:** PHP 8.x / [Laravel](https://laravel.com)
*   **Админ-панель:** [Filament v3](https://filamentphp.com) (мощная и быстрая панель управления)
*   **Frontend:** [Vue 3](https://vuejs.org) + [Inertia.js](https://inertiajs.com) (SPA-опыт без сложных API)
*   **Стилизация:** [Tailwind CSS](https://tailwindcss.com)
*   **Сборщик:** [Vite](https://vite.dev)
*   **Окружение:** [Docker](https://docker.com) + Docker Compose

---

## 🚀 Быстрый запуск (Docker)

Проект полностью настроен для работы в Docker-контейнерах. Для локального развертывания выполните следующие шаги:

### 1. Клонирование репозитория
```bash
git clone https://github.com
cd radio-collection
```

### 2. Настройка окружения
Скопируйте файл конфигурации среды:
```bash
cp .env.example .env
```
*При необходимости измените настройки подключения к базе данных и порты в файле `.env`.*

### 3. Сборка и запуск контейнеров
Запустите Docker Compose в фоновом режиме:
```bash
docker-compose up -d
```

### 4. Установка зависимостей и настройка приложения
Зайдите внутрь контейнера (или выполните команды локально, если у вас настроен PHP/Composer):

```bash
# Установка PHP зависимостей
docker-compose exec app composer install

# Генерация ключа приложения
docker-compose exec app php artisan key:generate

# Запуск миграций и сидов (если есть)
docker-compose exec app php artisan migrate

# Установка Node-зависимостей и сборка фронтенда
docker-compose exec app npm install
docker-compose exec app npm run build
```

После этого проект будет доступен по адресу, указанному в вашем `.env` (обычно `http://localhost`).

---

## 💻 Локальная разработка (без Docker)

Если вы предпочитаете запускать проект напрямую на вашем хосте:

1. Убедитесь, что у вас установлены **PHP 8.2+**, **Composer**, **Node.js** и **MySQL**.
2. Установите зависимости: `composer install` и `npm install`.
3. Настройте БД в файле `.env` и запустите миграции: `php artisan migrate`.
4. Запустите сервер разработки Laravel: `php artisan serve`.
5. Запустите сборщик фронтенда в режиме разработки: `npm run dev`.

---

## 👑 Создание администратора (Filament)

Для доступа в админ-панель (по умолчанию доступна по адресу `/admin`) создайте пользователя с правами администратора:

```bash
docker-compose exec app php artisan make:filament-user
```
Следуйте инструкциям в терминале, чтобы задать имя, email и пароль.

---

## 📄 Лицензия

Этот проект является открытым программным обеспечением, распространяемым по лицензии [MIT](LICENSE).
