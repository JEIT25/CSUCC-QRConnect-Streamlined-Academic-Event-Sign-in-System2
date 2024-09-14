<?php
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterListStudentController;
use App\Http\Controllers\QrCodeGeneratorController;
use App\Http\Controllers\QrScannerController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MasterListController;
use App\Http\Controllers\FacilitatorController;
use App\Http\Controllers\StudentController;

Route::get('test', function () {
    return inertia('Index/Test', ["data" => "hi"]);
});

//Log In Routes
Route::get('facilitators/login', function () {
    return inertia('Auth/Facilitator/Login');
})->name('facilitators.login'); //

Route::get('students/login', function () {
    return inertia('Auth/Student/Login');
});

Route::get('login', fn () => redirect()->route('homepage')->with("failed","Unauthorized access. Please login to any user above to continue."))//redirect to homepage wtoh anauthorized message
    ->name('login'); //sign in form

Route::post('login',[AuthController::class,'store'])
->name('login.store');

Route::delete('logout', [AuthController::class, 'destroy']); //log out user
//

//HOMEPAGE
Route::get('/', function () {
    return Inertia::render('Index/Index');
})->name('homepage');
//

//RESOURCE ROUTE FOR EVENTS,
Route::resource('events', EventController::class)
    ->only('index', 'create', 'store', 'show', 'destroy', 'edit', 'update')
    ->middleware('auth');
//

//Student Routes
Route::get('/students/create', [StudentController::class, 'create']);
Route::post('/students', [StudentController::class, 'store']);
//

//Facilitator Routes
Route::resource('facilitators', FacilitatorController::class)
    ->only('create', 'show', 'store');
//

//Attendee Routes
Route::get('/events/{event}/attendees', [AttendeeController::class, 'index'])
    ->name('attendees.index')
    ->middleware('auth');
;
Route::delete('/events/{event}/attendees/{attendee}', [AttendeeController::class, 'destroy'])
    ->name('attendees.destroy')
    ->middleware('auth');
;
//

//Master List And Master List Student routes
Route::get('/events/{event}/master-lists/{master_list}', [MasterListController::class, 'show'])
    ->name('master-lists.show')
    ->middleware('auth');

Route::post('/events/{event}/master-lists', [MasterListController::class, 'store'])
    ->name('master-lists.store')
    ->middleware('auth');
Route::delete('/events/{event}/master-lists/{master_list}', [MasterListController::class, 'destroy'])
    ->name('master-list.destroy')
    ->middleware('auth');

Route::post('master-list-students/{master_list}', [MasterListStudentController::class, 'store'])
    ->name('master-list-students.store')
    ->middleware('auth');

Route::delete('master-list-students/{master_list_student}', [MasterListStudentController::class, 'destroy'])
    ->name('master-list-students.destroy')
    ->middleware('auth');
//

//QR scanner Routes
Route::get('/events/{event}/qrscanner/checkin', [QrScannerController::class, 'checkin'])
    ->name('qrscanner.checkin.get')
    ->middleware('auth');

Route::post('/events/{event}/qrscanner/checkin', [QrScannerController::class, 'checkinPost'])
    ->name('qrscanner.checkin.post')
    ->middleware('auth');

Route::get('/events/{event}/qrscanner/checkout', [QrScannerController::class, 'checkout'])
    ->name('qrscanner.checkout.get')
    ->middleware('auth');

Route::post('/events/{event}/qrscanner/checkout', [QrScannerController::class, 'checkoutPost'])
    ->name('qrscanner.checkout.post')
    ->middleware('auth');
//

//QR Generator Routes
Route::get('qr-generator/result/{user}', [QrCodeGeneratorController::class, 'show'])
    ->name('qr-generator.show');
//
