<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommunityController;
use Illuminate\Support\Facades\Storage;

Route::get('/test-upload', function () {
    return view('test-upload');
});

Route::post('/test-upload', function () {
    $file = request()->file('file');

    if (!$file) {
        return "Tidak ada file.";
    }

    // upload ke supabase
    $path = Storage::disk('supabase_posts')->putFile('testing', $file);

    return "Upload berhasil! Path: " . $path;
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. ROUTE KHUSUS MEDIA (Solusi untuk Windows/Symlink Error)
// =========================================================================
// Route ini membaca file langsung dari folder storage tanpa butuh php artisan storage:link
// =========================================================================
// 1. ROUTE KHUSUS MEDIA (MODE DEBUG)
// =========================================================================
Route::get('/media/{path}', function ($path) {
    // Cegah akses folder lain
    if (str_contains($path, '..')) {
        return "Error: Dilarang mengakses folder lain (..)";
    }
    
    // Tentukan lokasi file yang dicari
    $filePath = storage_path('app/public/' . $path);
    
    // CEK APAKAH FILE ADA?
    if (!file_exists($filePath)) {
        // JIKA TIDAK ADA, TAMPILKAN PESAN ERROR INI DI BROWSER
        return "ERROR: File tidak ditemukan!\n" .
               "Dicari di: " . $filePath . "\n" .
               "Path dari URL: " . $path;
    }
    
    // Jika ada, tampilkan gambarnya
    return response()->file($filePath);
})->where('path', '.*')->name('media.show');
// =============================
// PUBLIC ROUTES (TIDAK PERLU LOGIN)
// =============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/information', [InformationController::class, 'index'])->name('information');


// =============================
// AUTHENTICATED ROUTES (HARUS LOGIN)
// =============================
Route::middleware(['auth'])->group(function () {

    // --- GROUP UNTUK ROLE: USER ---
    Route::middleware('checkrole:user')->group(function () {
        Route::get('/report/step-1', [ReportController::class, 'showStep1'])->name('report.step1.show');
        Route::post('/report/step-1', [ReportController::class, 'storeStep1'])->name('report.step1.store');
        Route::get('/report/step-2', [ReportController::class, 'showStep2'])->name('report.step2.show');
        Route::post('/report/step-2', [ReportController::class, 'storeStep2'])->name('report.step2.store');
        Route::get('/report/success', fn() => view('report-success'))->name('report.success');
    });

    // --- GROUP UNTUK ROLE: USER dan PSYCHOLOGIST ---
    Route::middleware('checkrole:user,psychologist')->group(function () {
        Route::get('/consultation', fn() => view('consultation'))->name('consultation');
        
        // --- COMMUNITY ROUTES ---
        Route::get('/community', [CommunityController::class, 'index'])->name('community');
        Route::post('/community/post', [CommunityController::class, 'storePost'])->name('community.post.store');
        Route::post('/community/post/{post}/comment', [CommunityController::class, 'storeComment'])->name('community.comment.store');
        Route::post('/community/post/{post}/like', [CommunityController::class, 'toggleLike'])->name('community.like');
        Route::delete('/community/post/{post}', [CommunityController::class, 'destroyPost'])->name('community.post.destroy');
        Route::put('/community/post/{post}', [CommunityController::class, 'updatePost'])->name('community.post.update');
    });

    // --- GROUP UNTUK ROLE: PSYCHOLOGIST ---
    Route::middleware('checkrole:psychologist')->group(function () {
        Route::get('/psychologist/chat', fn() => view('psychologist.chat'))->name('psychologist.chat');
    });

    // --- GROUP UNTUK ROLE: SUPERADMIN ---
    Route::middleware('checkrole:superadmin')->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // ROLE
        Route::get('/role', [AdminRoleController::class, 'index'])->name('role');
        Route::post('/role', [AdminRoleController::class, 'store'])->name('role.store');
        Route::get('/role/{id}', [AdminRoleController::class, 'show'])->name('role.show');
        Route::put('/role/{id}', [AdminRoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{id}', [AdminRoleController::class, 'destroy'])->name('role.destroy');

        // REPORT
        Route::get('/report', [AdminController::class, 'report'])->name('report');

        // CONSULTATION
        Route::get('/consultation', [AdminController::class, 'consultation'])->name('consultation');

        // INFORMATION
        Route::get('/information', [AdminInformationController::class, 'index'])->name('information');
        Route::post('/information', [AdminInformationController::class, 'store'])->name('information.store');
        Route::put('/information/{information}', [AdminInformationController::class, 'update'])->name('information.update');
        Route::delete('/information/{information}', [AdminInformationController::class, 'destroy'])->name('information.destroy');
   
    });

});


// Auth routes (login, register, logout, dll.) dari Breeze
require __DIR__ . '/auth.php';