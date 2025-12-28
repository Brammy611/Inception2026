<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Main route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard Route
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('peserta.dashboard');
})->name('dashboard')->middleware('auth');

// Peserta Routes
Route::prefix('peserta')->name('peserta.')->middleware(['auth', 'peserta'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Peserta\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/register', [App\Http\Controllers\Peserta\DashboardController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Peserta\DashboardController::class, 'register'])->name('register.store');
    Route::post('/documents', [App\Http\Controllers\Peserta\DashboardController::class, 'updateDocuments'])->name('documents.update');
});

// Career Talk Routes
Route::get('/career-talk', [HomeController::class, 'careerTalk'])->name('career-talk');
Route::get('/career-talk/register', [HomeController::class, 'careerTalkRegister'])->name('career-talk.register');
Route::post('/career-talk/register', [HomeController::class, 'careerTalkRegisterStore'])->name('career-talk.register.store');
Route::get('/career-talk/success', [HomeController::class, 'careerTalkSuccess'])->name('career-talk.success');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Career Talk Management
    Route::prefix('career-talk')->name('career-talk.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'index'])->name('index');
        Route::get('/export', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'export'])->name('export');
        Route::get('/{registration}', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'show'])->name('show');
        Route::patch('/{registration}/status', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{registration}', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'destroy'])->name('destroy');
        Route::post('/check-in', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'checkIn'])->name('check-in');
        Route::post('/bulk-confirmation', [App\Http\Controllers\Admin\AdminCareerTalkController::class, 'sendBulkConfirmation'])->name('bulk-confirmation');
    });
});