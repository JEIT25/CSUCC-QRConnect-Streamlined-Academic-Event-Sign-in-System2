<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MasterListController;
route::get('test', function () {
    return inertia('Index/Test', ["data" => "hi"]);
});

//HOMEPAGE
Route::get('/', function () {
    return Inertia::render('Index/Index');
})->name('homepage');
//

//RESOURCE ROUTE FOR EVENTS,
Route::resource('events', EventController::class)
    ->only('index','create','store','show','destroy','edit','update');
//

//Master List Routes
Route::get('/events/{event}/master-lists/{masterlist}', [MasterListController::class, 'show'])
    ->name('master-lists.show');

Route::get('/events/{event}/master-lists/create', [MasterListController::class,'create'])
->name('master-lists.create');

Route::post('/events/{event}/master-lists', [MasterListController::class, 'store'])
    ->name('master-lists.store');
//

//Log In Routes
route::get('login', [AuthController::class, 'create'])
    ->name('login'); //sing in form

route::post('login', [AuthController::class, 'store'])
    ->name('login'); //sign in request handler

route::delete('logout',[AuthController::class,'destroy']); //log out user
//