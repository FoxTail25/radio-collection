<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index, follow">
    {{-- title --}}
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    <!-- фавиконка -->
    <link rel="icon" href="./favicon.ico" sizes="any"/>
    <!-- СЕО-ОПТИМИЗАЦИЯ (SEO) -->
    <meta name="description" content="Коллекция интернет радиоканалов">
    <meta name="keywords" content="Григорий Шустиков, фронтенд разработчик, frontend developer, fullstack, верстка сайтов, веб-разработчик Москва, Laravel, React, Vue, интернет радио, коллекция радиоканалов, интернетрадио">
    <meta name="author" content="Григорий Шустиков">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
