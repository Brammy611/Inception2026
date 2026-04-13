<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Main route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
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
    Route::get('/profile', [App\Http\Controllers\Peserta\DashboardController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Peserta\DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/notifications', [App\Http\Controllers\Peserta\DashboardController::class, 'notifications'])->name('notifications');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\Peserta\DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/register', [App\Http\Controllers\Peserta\DashboardController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [App\Http\Controllers\Peserta\DashboardController::class, 'register'])->name('register.store');
    Route::post('/documents', [App\Http\Controllers\Peserta\DashboardController::class, 'updateDocuments'])->name('documents.update');
    Route::get('/documents/ktm/{filename}', [App\Http\Controllers\Peserta\DashboardController::class, 'viewKtm'])->name('view-ktm');
    Route::get('/documents/follow-ig/{filename}', [App\Http\Controllers\Peserta\DashboardController::class, 'viewFollowIg'])->name('view-follow-ig');
    Route::get('/documents/share-poster/{filename}', [App\Http\Controllers\Peserta\DashboardController::class, 'viewSharePoster'])->name('view-share-poster');
    Route::get('/documents/payment/{filename}', [App\Http\Controllers\Peserta\DashboardController::class, 'viewPayment'])->name('view-payment');
    
    // Semifinal Payment Routes
    Route::post('/semifinal/payment', [App\Http\Controllers\Peserta\DashboardController::class, 'uploadSemifinalPayment'])->name('semifinal.payment.upload');
    Route::get('/semifinal/payment/view', [App\Http\Controllers\Peserta\DashboardController::class, 'viewSemifinalPayment'])->name('semifinal.payment.view');

    // Final Payment Routes
    Route::post('/final/payment', [App\Http\Controllers\Peserta\DashboardController::class, 'uploadFinalPayment'])->name('final.payment.upload');
    Route::get('/final/payment/view', [App\Http\Controllers\Peserta\DashboardController::class, 'viewFinalPayment'])->name('final.payment.view');
    
    // Submission Routes
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', function() { return redirect()->route('peserta.dashboard'); })->name('index');
        Route::post('/upload', [App\Http\Controllers\Peserta\SubmissionController::class, 'upload'])->name('upload');
        Route::delete('/delete', [App\Http\Controllers\Peserta\SubmissionController::class, 'delete'])->name('delete');
        Route::get('/status', [App\Http\Controllers\Peserta\SubmissionController::class, 'status'])->name('status');
        Route::get('/view/{type}/{stage}', [App\Http\Controllers\Peserta\SubmissionController::class, 'view'])->name('view');
        Route::get('/download/{type}/{stage}', [App\Http\Controllers\Peserta\SubmissionController::class, 'download'])->name('download');
    });
});

// Career Talk Routes
Route::get('/career-talk', [HomeController::class, 'careerTalk'])->name('career-talk');
Route::get('/career-talk/register', [HomeController::class, 'careerTalkRegister'])->name('career-talk.register');
Route::post('/career-talk/register', [HomeController::class, 'careerTalkRegisterStore'])->name('career-talk.register.store');
Route::get('/career-talk/success', [HomeController::class, 'careerTalkSuccess'])->name('career-talk.success');

// Company Visit Routes
Route::get('/company-visit', [HomeController::class, 'companyVisit'])->name('company-visit');

// Competition Routes
Route::get('/competitions', function () {
    return view('competition.competition-home');
})->name('competitions');

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
    
    // Competition Participant Management
    Route::prefix('peserta')->name('peserta.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminPesertaController::class, 'index'])->name('index');
        Route::get('/export', [App\Http\Controllers\Admin\AdminPesertaController::class, 'export'])->name('export');
        Route::get('/documents/ktm/{filename}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'viewKtm'])->name('view-ktm');
        Route::get('/documents/follow-ig/{filename}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'viewFollowIg'])->name('view-follow-ig');
        Route::get('/documents/share-poster/{filename}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'viewSharePoster'])->name('view-share-poster');
        Route::get('/documents/payment/{filename}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'viewPayment'])->name('view-payment');
        Route::get('/{peserta}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'show'])->name('show');
        Route::patch('/{peserta}/status', [App\Http\Controllers\Admin\AdminPesertaController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{peserta}', [App\Http\Controllers\Admin\AdminPesertaController::class, 'destroy'])->name('destroy');
        
        // Admin Submission Management
        Route::get('/{peserta}/submissions', [App\Http\Controllers\Admin\AdminSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/{peserta}/submissions/{type}/{stage}', [App\Http\Controllers\Admin\AdminSubmissionController::class, 'view'])->name('submissions.view');
        Route::get('/{peserta}/submissions/{type}/{stage}/download', [App\Http\Controllers\Admin\AdminSubmissionController::class, 'download'])->name('submissions.download');
    });
    
    // Semifinal Payment Management
    Route::prefix('semifinal-payments')->name('semifinal-payments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminSemifinalPaymentController::class, 'index'])->name('index');
        Route::get('/{payment}/view', [App\Http\Controllers\Admin\AdminSemifinalPaymentController::class, 'view'])->name('view');
        Route::patch('/{payment}/verify', [App\Http\Controllers\Admin\AdminSemifinalPaymentController::class, 'verify'])->name('verify');
        Route::patch('/{payment}/reject', [App\Http\Controllers\Admin\AdminSemifinalPaymentController::class, 'reject'])->name('reject');
    });

    // Final Payment Management
    Route::prefix('final-payments')->name('final-payments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminFinalPaymentController::class, 'index'])->name('index');
        Route::get('/{payment}/view', [App\Http\Controllers\Admin\AdminFinalPaymentController::class, 'view'])->name('view');
        Route::patch('/{payment}/verify', [App\Http\Controllers\Admin\AdminFinalPaymentController::class, 'verify'])->name('verify');
        Route::patch('/{payment}/reject', [App\Http\Controllers\Admin\AdminFinalPaymentController::class, 'reject'])->name('reject');
    });
});