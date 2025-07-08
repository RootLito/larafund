<?php
use App\Http\Middleware\AuthRedirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackingController;

// Unprotected: Publicly accessible
Route::get('/', [TrackingController::class, 'main']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/bac', function () {
    return view('auth.login');
});


// Group all protected routes
Route::middleware([AuthRedirect::class])->group(function () {

    //Tracking routes
    Route::get('/dashboard', [TrackingController::class, 'dashboard'])->name('dashboard');
    Route::get('/tracking', [TrackingController::class, 'records'])->name('tracking');
    Route::get('/calendar', [TrackingController::class, 'calendar'])->name('calendar');
    Route::post('/pr', [TrackingController::class, 'newpr']);
    Route::put('/tracking/{id}', [TrackingController::class, 'update'])->name('tracking.update');
    Route::delete('/tracking/{id}', [TrackingController::class, 'destroy'])->name('tracking.delete');
    Route::get('/projects/search', [TrackingController::class, 'search'])->name('projects.search');
    Route::get('/view', [TrackingController::class, 'viewProject'])->name('project.action.view');
    Route::get('/edit', [TrackingController::class, 'editProject'])->name('project.action.edit');
    Route::post('/tracking/export', [TrackingController::class, 'export'])->name('tracking.export');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard/reminders', [TrackingController::class, 'reminders'])->name('reminders.post-qua');
    
    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/register', [UserController::class, 'register'])->name('users.register');
});










