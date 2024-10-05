<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvailabilityController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('availability.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create/{role}', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/create/{role}', [UserController::class, 'store'])->name('user.store');
    //Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/edit/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');

    Route::get('/availability', [AvailabilityController::class, 'index'])->name('availability.index');
    Route::get('/availability/create', [AvailabilityController::class, 'create'])->name('availability.create');
    Route::post('/availability/create', [AvailabilityController::class, 'store'])->name('availability.store');
    //Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/availability/edit/{id}', [AvailabilityController::class, 'edit'])->name('availability.edit');
    Route::post('/availability/edit/{id}', [AvailabilityController::class, 'update'])->name('availability.update');
    Route::delete('/availability/{id}', [AvailabilityController::class, 'destroy'])->name('availability.delete');

    Route::get('/availability/schedule/{id}', [AvailabilityController::class, 'schedule'])->name('availability.schedule.index');
    Route::post('/availability/schedule/{id}', [AvailabilityController::class, 'scheduleStore'])->name('availability.schedule.store');
    Route::delete('/availability/schedule/cancel/{id}', [AvailabilityController::class, 'scheduleCancel'])->name('availability.schedule.cancel');
});

require __DIR__.'/auth.php';
