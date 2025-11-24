<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Main route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Career Talk Routes
Route::get('/career-talk', [HomeController::class, 'careerTalk'])->name('career-talk');
Route::get('/career-talk/register', [HomeController::class, 'careerTalkRegister'])->name('career-talk.register');
Route::post('/career-talk/register', [HomeController::class, 'careerTalkRegisterStore'])->name('career-talk.register.store');
Route::get('/career-talk/success', [HomeController::class, 'careerTalkSuccess'])->name('career-talk.success');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
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