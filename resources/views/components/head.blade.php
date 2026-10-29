<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index, follow">
    {{-- title --}}
    <title>{{ config('app.name', 'Radio Collection') }}</title>
    <!-- фавиконка -->
    <link rel="icon" href="./favicon.svg" type="image/svg+xml" sizes="any"/>
    <!-- СЕО-ОПТИМИЗАЦИЯ (SEO) -->
    <meta name="description" content="Коллекция интернет радиоканалов">
    <meta name="keywords" content="Григорий Шустиков, фронтенд разработчик, frontend developer, fullstack, верстка сайтов, веб-разработчик Москва, Laravel, React, Vue, интернет радио, коллекция радиоканалов, интернетрадио">
    <meta name="author" content="Григорий Шустиков">

    <!-- OPEN GRAPH (Для превью в Telegram, VK, WhatsApp) -->
    <meta property="og:type" content="website" >
    <!-- Сюда финальную ссылку после деплоя -->
    <meta property="og:url" content="https://radio.foxtail25.ru" >
    <meta property="og:title" content="Григорий Шустиков | Fullstack-разработчик" >
    <meta property="og:description" content="Сайт-визитка фронтенд-разработчика. Чистый код без тяжелых фреймворков, поддержка темной темы и адаптивная верстка.">
    <!-- Ссылка на картинку-превью (скриншот главного экрана) -->
    <meta property="og:image" content="https://preview.png">
    <meta property="og:site_name" content="Портфолио Григория Шустикова" >
    <meta property="og:locale" content="ru_RU" >

    <!-- ДЛЯ TWITTER / X -->
    <meta name="twitter:card" content="summary_large_image" >
    <meta name="twitter:title" content="Григорий Шустиков | Fullstack-разработчик">
    <meta name="twitter:description" content="Сайт-визитка фронтенд-разработчика. Чистый код без фреймворков, поддержка темной темы.">
    <meta name="twitter:image" content="https://preview.png">



    <!-- Подключаем Tailwind CSS через CDN для быстрой и красивой стилизации -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>
