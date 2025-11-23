<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController; // Pastikan Controller ini di-import

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. ROUTE TEST UPLOAD (DEBUG)
// =========================================================================
Route::get('/test-upload', function () {
    return view('test-upload');
});

Route::post('/test-upload', function () {
    $file = request()->file('file');
    if (!$file) return "Tidak ada file.";
    $path = Storage::disk('supabase_posts')->putFile('testing', $file);
    return "Upload berhasil! Path: " . $path;
});

// =========================================================================
// 2. ROUTE KHUSUS MEDIA
// =========================================================================
Route::get('/media/{path}', function ($path) {
    if (str_contains($path, '..')) return "Error: Dilarang mengakses folder lain (..)";
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) return "ERROR: File tidak ditemukan!";
    return response()->file($filePath);
})->where('path', '.*')->name('media.show');

Route::get('/test-upload', function () {
    return view('test-upload');
});

// =============================
// PUBLIC ROUTES
// =============================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/information', [InformationController::class, 'index'])->name('information');

    // Route untuk setiap link di navbar
    Route::get('/consultation', function () {
        return view('consultation');
    })->name('consultation');

// =============================
// AUTHENTICATED ROUTES
// =============================
Route::middleware(['auth'])->group(function () {

    // === PROFILE ROUTES (PERBAIKAN DISINI) ===
    
    // 1. Halaman My Profile (Dashboard Profil)
    // URL: /profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    // 2. Halaman Edit Profile (Settings)
    // URL: /profile/edit (Kita ubah dari '/profile' agar tidak bentrok)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Halaman History Laporan
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');


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
        
        // CONSULTATION & CHAT
        Route::get('/consultation', [ChatController::class, 'index'])->name('consultation'); 
        Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{userId}', [ChatController::class, 'store'])->name('chat.store');
        
        // COMMUNITY
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

    // --- GROUP ADMIN ---
    Route::middleware('checkrole:superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/role', [AdminRoleController::class, 'index'])->name('role');
        Route::post('/role', [AdminRoleController::class, 'store'])->name('role.store');
        Route::get('/role/{id}', [AdminRoleController::class, 'show'])->name('role.show');
        Route::put('/role/{id}', [AdminRoleController::class, 'update'])->name('role.update');
        Route::delete('/role/{id}', [AdminRoleController::class, 'destroy'])->name('role.destroy');
        
        Route::get('/report', [AdminController::class, 'report'])->name('report');
        Route::get('/consultation', [AdminController::class, 'consultation'])->name('consultation');
        
        Route::get('/information', [AdminInformationController::class, 'index'])->name('information');
        Route::post('/information', [AdminInformationController::class, 'store'])->name('information.store');
        Route::put('/information/{information}', [AdminInformationController::class, 'update'])->name('information.update');
        Route::delete('/information/{information}', [AdminInformationController::class, 'destroy'])->name('information.destroy');
    });
});

require __DIR__ . '/auth.php';