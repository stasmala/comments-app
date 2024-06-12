# Модуль Комментарии

Этот проект представляет собой модуль комментариев , разработанный с использованием фреймворка Laravel в качестве бэкэнда и Node.js для управления фронтендом.

## Требования

Для запуска этого проекта вам потребуется:

- PHP >= 7.4
- Composer
- Node.js >= 14
- NPM или Yarn
- MySQL или другая поддерживаемая база данных

## Установка

    **Клонирование репозитория**

Сначала склонируйте этот репозиторий на свой компьютер:

   ```bash
   git clone https://github.com/stasmala/comments-app.git
   ```
**Установка зависимостей**

Перейдите в каталог проекта и установите PHP зависимости через Composer:
   

    cd comments-app
    composer install


Затем установите зависимости Node.js через npm или yarn:


    npm install
    # или
    yarn install

**Настройка окружения**

Скопируйте файл .env.example и назовите его .env. Настройте свои переменные окружения в файле .env, включая параметры базы данных.

**Выполнение миграций**

Запустите миграции для создания таблиц в базе данных:

    php artisan migrate

**Запуск сервера разработки**

Запустите сервер разработки Laravel и скомпилируйте ресурсы с помощью следующей команды:
    
    php artisan serve

В другом терминале запустите скрипт сборки для фронтенда:

    npm run dev
Теперь ваше приложение должно быть доступно по адресу http://127.0.0.1:8000.
