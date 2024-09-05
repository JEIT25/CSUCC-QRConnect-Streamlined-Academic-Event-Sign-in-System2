<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return Inertia::render('Index/Index');
});

Route::resource('events', EventController::class)
    ->only('index','create','store','show','destroy','edit','update');