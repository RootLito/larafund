<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});


Route::get('/dashboard', function () {
    return view('layout.dashboard');
});


Route::get('/app', function () {
    return view('layout.app');
});


Route::get('/dashboard', [TrackingController::class, 'dashboard'])->name('dashboard');
Route::get('/tracking', [TrackingController::class, 'records'])->name('tracking');


Route::get('/users', function () {
    return view('pages.users');
})->name('users');


Route::get('/calendar', function () {
    return view('pages.calendar');
})->name('calendar');





//USER CONTROLLER     
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);




//TRACKING CONTROLLER
Route::post('/pr', [TrackingController::class, 'newpr']);
Route::put('/tracking/{id}', [TrackingController::class, 'update'])->name('tracking.update');
// Route::delete('/tracking/delete/{id}', [TrackingController::class, 'delete'])->name('tracking.delete');
Route::delete('/tracking/{id}', [TrackingController::class, 'destroy'])->name('tracking.delete');



//CALENDAR CONTROLLER
Route::get('/calendar', [TrackingController::class, 'calendar'])->name('calendar');





