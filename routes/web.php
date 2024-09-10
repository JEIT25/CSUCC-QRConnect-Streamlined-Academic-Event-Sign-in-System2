<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QrCodeGeneratorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MasterListController;
use App\Http\Controllers\FacilitatorController;
use App\Http\Controllers\StudentController;

route::get('test', function () {
    return inertia('Index/Test', ["data" => "hi"]);
});

//Log In Routes
route::get('facilitators/login', function () {
    return inertia('Auth/Facilitator/Login');
})->name('facilitators.login'); //

// route::get('login', [AuthController::class, 'create'])
//     ->name('login'); //sing in form

route::post('login', [AuthController::class, 'store'])
    ->name('login'); //sign in request handler

route::delete('logout', [AuthController::class, 'destroy']); //log out user
//

//HOMEPAGE
Route::get('/', function () {
    return Inertia::render('Index/Index');
})->name('homepage');
//

//RESOURCE ROUTE FOR EVENTS,
Route::resource('events', EventController::class)
    ->only('index','create','store','show','destroy','edit','update');
//

//Student routes
Route::get('/students/create', [StudentController::class, 'create']);
Route::post('/students', [StudentController::class, 'store']);
Route::get('students/login', function () {
    return inertia('Auth/Student/Login');
});
//

//Facilitator routes
Route::resource('facilitators', FacilitatorController::class)
->only('create','show','store');
//

//Master List Routes
Route::get('/events/{event}/master-lists/create', [MasterListController::class, 'create'])
    ->name('master-lists.create'); //place create route before show route to avoid route conflicts

Route::get('/events/{event}/master-lists/{masterlist}', [MasterListController::class, 'show'])
    ->name('master-lists.show');

Route::post('/events/{event}/master-lists', [MasterListController::class, 'store'])
    ->name('master-lists.store');
//

//QR scanner route
route::get('/events/{event}/qrscanner/checkin', function () {
    return inertia('QrScanner/Checkin');
});

//QR Generator Routes
route::get('qr-generator/result/{user}',[QrCodeGeneratorController::class,'show'])
->name('qr-generator.show');
//
