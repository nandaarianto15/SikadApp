<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\VerifikatorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page (Publik)
Route::get('/', [HomeController::class, 'landing'])->name('landing');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{slug}', [HomeController::class, 'newsDetail'])->name('news.detail');

// API Routes
Route::get('/api/services/{slug}', [HomeController::class, 'getServiceBySlug']);
Route::get('/api/landing/news', [HomeController::class, 'landingNews']);
Route::get('/api/landing/services', [HomeController::class, 'landingServices']);

// Authentication Routes
Route::get('/auth', [AuthController::class, 'showLoginForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($user->role === 'verifikator') {
            return redirect()->route('verifikator.dashboard');
        }
        return redirect()->route('pemohon.dashboard');
    })->name('dashboard');

    Route::prefix('pemohon')->name('pemohon.')->middleware('role:pemohon')->group(function () {
        Route::get('/dashboard', [PemohonController::class, 'dashboard'])->name('dashboard');
        Route::get('/select', [PemohonController::class, 'select'])->name('select');
        Route::get('/wizard', [PemohonController::class, 'wizard'])->name('wizard');

        Route::get('/tracking/{tracking_id}', [PemohonController::class, 'tracking'])->name('tracking');
        
        Route::post('/submissions', [PemohonController::class, 'store'])->name('submissions.store');
        Route::post('/submissions/{submission}/update', [PemohonController::class, 'updateSubmission'])->name('updateSubmission');

        Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/documents/{document}/view', [DocumentController::class, 'view'])->name('documents.view');
        
        // API endpoint untuk filter
        Route::get('/api/filter-submissions', [PemohonController::class, 'filterSubmissions'])->name('api.filter-submissions');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // News Management
        Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
        Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
        Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
        Route::get('/news/{id}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
        Route::put('/news/{id}', [AdminController::class, 'newsUpdate'])->name('news.update');
        Route::delete('/news/{id}', [AdminController::class, 'newsDestroy'])->name('news.destroy');
        
        // Service Management
        Route::get('/services', [AdminController::class, 'serviceIndex'])->name('services.index');
        Route::get('/services/create', [AdminController::class, 'serviceCreate'])->name('services.create');
        Route::post('/services', [AdminController::class, 'serviceStore'])->name('services.store');
        Route::get('/services/{id}/edit', [AdminController::class, 'serviceEdit'])->name('services.edit');
        Route::put('/services/{id}', [AdminController::class, 'serviceUpdate'])->name('services.update');
        Route::delete('/services/{id}', [AdminController::class, 'serviceDestroy'])->name('services.destroy');
    });
    
    Route::prefix('verifikator')->name('verifikator.')->middleware('role:verifikator')->group(function () {
        Route::get('/dashboard', [VerifikatorController::class, 'dashboard'])->name('dashboard');
        Route::get('/submissions', [VerifikatorController::class, 'submissions'])->name('submissions');
        Route::get('/tracking/{submission:tracking_id}', [VerifikatorController::class, 'tracking'])->name('tracking');
        Route::get('/verify/{submission}', [VerifikatorController::class, 'verify'])->name('verify');
        Route::post('/verify/{submission}', [VerifikatorController::class, 'updateStatus'])->name('updateStatus');
        
        // Tambahkan route untuk menolak pengajuan
        Route::post('/submissions/{submission}/reject', [VerifikatorController::class, 'rejectSubmission'])->name('submissions.reject');

        Route::post('/documents/{document}/verify', [VerifikatorController::class, 'updateDocumentStatus'])->name('documents.verify');

        // API endpoint untuk filter
        Route::get('/api/filter-submissions', [VerifikatorController::class, 'filterSubmissions'])->name('api.filter-submissions');
        Route::get('/api/submission/{submission}', [VerifikatorController::class, 'getSubmission'])->name('api.get-submission');
        
        // Document routes
        Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
        Route::get('/documents/{document}/view', [DocumentController::class, 'view'])->name('documents.view');
    });
});