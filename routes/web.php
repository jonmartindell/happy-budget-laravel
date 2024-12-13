<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('dashboard', DashboardController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('categories', CategoryController::class)
    ->only(['index', 'store', 'create', 'edit', 'update', 'destroy', 'show'])
    ->middleware(['auth', 'verified']);
Route::get('/summary', [CategoryController::class, 'summary'])
    ->middleware(['auth', 'verified'])
    ->name('summary');

Route::resource('transactions', TransactionController::class)
    ->only(['index', 'store', 'create', 'edit', 'update', 'destroy', 'show'])
    ->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
