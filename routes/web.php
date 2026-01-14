<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerifikatorController;

// Landing Page
Route::get('/', [HomeController::class, 'landing'])->name('landing');

// API Routes
Route::get('/api/services/{slug}', [HomeController::class, 'getServiceBySlug']);
Route::get('/api/landing/news', [HomeController::class, 'landingNews']);
Route::get('/api/landing/services', [HomeController::class, 'landingServices']);

// Authentication Routes
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    // Pemohon Routes
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/select', [HomeController::class, 'select'])->name('select');
    Route::get('/wizard', [HomeController::class, 'wizard'])->name('wizard');
    Route::get('/tracking', [HomeController::class, 'tracking'])->name('tracking');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
    
    // Verifikator Routes
    Route::prefix('verifikator')->name('verifikator.')->group(function () {
        Route::get('/dashboard', [VerifikatorController::class, 'dashboard'])->name('dashboard');
    });
});