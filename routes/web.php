<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Authenticated app routes
Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('habits', HabitController::class)->except(['destroy'])->middleware('owns.habit');
    Route::delete('habits/{habit}', [HabitController::class, 'destroy'])->middleware('owns.habit')->name('habits.destroy');
    Route::post('habits/{habit}/archive', [HabitController::class, 'archive'])->middleware('owns.habit')->name('habits.archive');
    Route::post('habits/{habit}/check-in', [CheckInController::class, 'store'])->middleware('owns.habit')->name('habits.check-in');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
