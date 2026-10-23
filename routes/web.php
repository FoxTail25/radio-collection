<?php

use Illuminate\Support\Facades\Route;
use App\Models\Station;

// base route
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    // Загружаем только активные станции и сразу подтягиваем их каналы (жадная загрузка / eager loading)
    $stations = Station::where('is_active', true)->with('channels')->get();

    return view('home', compact('stations'));
});
