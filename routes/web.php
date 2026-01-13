<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewsController;

Route::get('/', [HomeController::class, 'landing'])->name('landing');

Route::get('/api/landing/news', [HomeController::class, 'landingNews']);
Route::get('/api/landing/services', [HomeController::class, 'landingServices']);

Route::get('/auth', [HomeController::class, 'auth'])->name('auth');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/select', [HomeController::class, 'select'])->name('select');
Route::get('/wizard', [HomeController::class, 'wizard'])->name('wizard');
Route::get('/tracking', [HomeController::class, 'tracking'])->name('tracking');