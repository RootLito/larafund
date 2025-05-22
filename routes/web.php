<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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



//PAGES DIRI
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/tracking', function () {
    return view('pages.tracking');
})->name('tracking');

Route::get('/users', function () {
    return view('pages.users');
})->name('users');

Route::get('/calendar', function () {
    return view('pages.calendar');
})->name('calendar');





//CONTROLLER ROUTES     
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);