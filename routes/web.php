<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return Inertia::render('Index/Index');
});

Route::resource('event', ActivityController::class)
    ->only('index','create','store');