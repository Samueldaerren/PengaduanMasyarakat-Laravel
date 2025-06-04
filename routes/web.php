<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HeadStaffController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ImportExportController;

// Route untuk halaman landing
Route::get('/', [LandingController::class, 'showLandingPage'])->name('landing');

// Route untuk halaman login
Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login');

Route::post('/login', [AuthController::class, 'submitLogin'])->name('login.submit');

Route::post('/register', [AuthController::class, 'submitRegister'])->name('register.submit');


// Routes yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    // Route untuk logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Route untuk laporan
    Route::prefix('report')->group(function () {
        Route::get('/article', [ReportController::class, 'showArticle'])->name('report.article'); // Semua laporan
        Route::get('/create', [ReportController::class, 'showCreateForm'])->name('report.create'); // Form pengaduan
        Route::post('/', [ReportController::class, 'submitReport'])->name('report.submit'); // Submit pengaduan
        Route::get('/{id}', [ReportController::class, 'show'])->name('report.show'); // Detail laporan
        Route::post('/reports/{report}/vote', [ReportController::class, 'vote'])->name('report.vote'); // Vote laporan
        Route::post('/{id}/comment', [ReportController::class, 'addComment'])->name('report.addComment'); // Komentar laporan
        Route::delete('/{id}', [ReportController::class, 'delete'])->name('report.delete'); // Hapus laporan
        Route::get('/reports', [ReportController::class, 'search'])->name('search.report');
        Route::get('/reports', [ReportController::class, 'index'])->name('report.index'); // Semua laporan pengguna
        Route::post('/reports/{id}/view', [ReportController::class, 'updateViewerCount']);
    });

    // Route untuk halaman profil pengguna dan laporan mereka
    Route::get('/me', [ReportController::class, 'showMe'])->name('report.me');

    // Routes untuk role STAFF
    Route::middleware(['role:STAFF'])->group(function () {
        // Menampilkan dashboard staff dengan daftar laporan
        Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    
        // Menampilkan detail laporan berdasarkan ID
        Route::get('/staff/report/{id}', [StaffController::class, 'show'])->name('staff.show');
    
        // Menangani aksi dari staff untuk laporan
        Route::post('/staff/report/action', [StaffController::class, 'processAction'])->name('staff.processAction');
    
        // Menyimpan progress untuk response terkait
        Route::post('/report/{report}/progress', [StaffController::class, 'storeProgress'])->name('store-progress');
    });
    
    
    // Routes untuk role HEAD_STAFF
    Route::middleware(['role:HEAD_STAFF'])->group(function () {
        Route::get('/headstaff/dashboard', [HeadStaffController::class, 'index'])->name('headstaff.dashboard');
        
        // Route untuk kelola akun
        Route::get('/headstaff/account/manage', [HeadStaffController::class, 'manageAccount'])->name('account.manage');
        
        // Route untuk menyimpan akun staff baru
        Route::post('/headstaff/account/store', [HeadStaffController::class, 'storeAccount'])->name('account.store');
        
        // Route untuk update akun (reset password)
        Route::put('/headstaff/account/update/{id}', [HeadStaffController::class, 'updateAccount'])->name('account.update');
        
        // Route untuk menghapus akun
        Route::delete('/headstaff/account/delete/{id}', [HeadStaffController::class, 'destroyAccount'])->name('account.destroy');
        
        Route::get('/headstaff/manage', [HeadStaffController::class, 'manageAccount'])->name('headstaff.manage');

        // Logout route untuk HEAD_STAFF
        Route::get('/headstaff/logout', [HeadStaffController::class, 'logout'])->name('headstaff.logout');
    });


    Route::controller(ImportExportController::class)->group(function(){
        Route::get('import_export', 'importExport');
        Route::get('export', 'export')->name('export');
    });
});

