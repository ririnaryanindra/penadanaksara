<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\BookWebController;
use App\Http\Controllers\CategoryWebController;
use App\Http\Controllers\TransactionWebController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');

Route::get('/register', [WebAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
Route::get('/transactions/export', [DashboardController::class, 'exportTransactions'])->name('transactions.export');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::resource('books', BookWebController::class);
    Route::resource('categories', CategoryWebController::class);
    Route::resource('transactions', TransactionWebController::class);
});
