<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. ROUTE KHUSUS MEDIA (Solusi untuk Windows/Symlink Error)
// =========================================================================
Route::get('/media/{path}', function ($path) {
    if (str_contains($path, '..')) abort(403);
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) abort(404);
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

    // --- PROFILE ROUTES ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PERBAIKAN ERROR: Menambahkan route 'profile.show' yang dicari oleh Navbar.
    // Kita arahkan ke 'edit' karena ProfileController bawaan Breeze biasanya tidak punya method 'show'.
    Route::get('/profile/view', [ProfileController::class, 'edit'])->name('profile.show');


    // --- GROUP UNTUK ROLE: USER ---
    // PERBAIKAN: Ganti 'user' menjadi 'User' (sesuai database)
    Route::middleware('checkrole:User')->group(function () {
        Route::get('/report/step-1', [ReportController::class, 'showStep1'])->name('report.step1.show');
        Route::post('/report/step-1', [ReportController::class, 'storeStep1'])->name('report.step1.store');
        Route::get('/report/step-2', [ReportController::class, 'showStep2'])->name('report.step2.show');
        Route::post('/report/step-2', [ReportController::class, 'storeStep2'])->name('report.step2.store');
        Route::get('/report/success', fn() => view('report-success'))->name('report.success');
    });


    // --- GROUP UNTUK ROLE: USER dan PSYCHOLOGIST ---
    // PERBAIKAN: Gunakan 'User' dan 'Psychologist' (Huruf depan besar)
    Route::middleware('checkrole:User,Psychologist')->group(function () {
        
        // Route Consultation
        Route::get('/consultation', function () {
            $users = \App\Models\User::where('role', 'Psychologist')->get(); // Sesuaikan query juga
            return view('consultation', compact('users'));
        })->name('consultation');

        // PERBAIKAN ERROR: Menambahkan route 'chat.show'
        // Ini adalah placeholder sementara agar halaman tidak error. 
        // Nanti bisa Anda ganti dengan Controller Chat yang sebenarnya.
        Route::get('/chat/{id}', function ($id) {
            return "Halaman Chat untuk User ID: " . $id; 
        })->name('chat.show');
        
        // --- COMMUNITY ROUTES ---
        Route::get('/community', [CommunityController::class, 'index'])->name('community');
        Route::post('/community/post', [CommunityController::class, 'storePost'])->name('community.post.store');
        Route::post('/community/post/{post}/comment', [CommunityController::class, 'storeComment'])->name('community.comment.store');
        Route::post('/community/post/{post}/like', [CommunityController::class, 'toggleLike'])->name('community.like');
        Route::delete('/community/post/{post}', [CommunityController::class, 'destroyPost'])->name('community.post.destroy');
        Route::put('/community/post/{post}', [CommunityController::class, 'updatePost'])->name('community.post.update');
    });


    // --- GROUP UNTUK ROLE: PSYCHOLOGIST ---
    // PERBAIKAN: Gunakan 'Psychologist'
    Route::middleware('checkrole:Psychologist')->group(function () {
        Route::get('/psychologist/chat', fn() => view('psychologist.chat'))->name('psychologist.chat');
    });


    // --- GROUP UNTUK ROLE: SUPERADMIN ---
    // PERBAIKAN: Gunakan 'SuperAdmin'
    Route::middleware('checkrole:SuperAdmin')->prefix('admin')->name('admin.')->group(function () {
        
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

require __DIR__ . '/auth.php';