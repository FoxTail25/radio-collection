<?php

use App\Models\Station;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // Получаем станции с каналами
    $stations = Station::where('is_active', true)->with('channels')->get();

    // Передаем данные во Vue-компонент "Welcome"
    return Inertia::render('Welcome', [
        'stations' => $stations,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

// Роуты авторизации от Breeze (логин, регистрация) подключаются автоматически ниже:
require __DIR__ . '/auth.php';
