<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// =============================
// 🏠 HALAMAN USER BIASA
// =============================
Route::get('/', function () {
    $user = auth()->user();
    if ($user && $user->role === 'SuperAdmin') return redirect()->route('admin.dashboard');
    return view('home');
})->name('home');

// Consultation
Route::get('/consultation', function () {
    $user = auth()->user();
    if (! $user || ! in_array($user->role, ['User','Psychologist'])) abort(403);
    return view('consultation');
})->name('consultation');

// Community
Route::get('/community', function () {
    $user = auth()->user();
    if (! $user || ! in_array($user->role, ['User','Psychologist'])) abort(403);
    return view('community');
})->name('community');

// Information
Route::get('/information', function () {
    $user = auth()->user();
    if (! $user || ! in_array($user->role, ['User','Psychologist'])) abort(403);
    return app(InformationController::class)->index();
})->name('information');

// Report multi-step
Route::get('/report/step-1', function (Request $request) {
    $user = auth()->user();
    if (! $user || $user->role !== 'User') abort(403);
    return app(ReportController::class)->showStep1($request);
})->name('report.step1.show');

Route::post('/report/step-1', function (Request $request) {
    $user = auth()->user();
    if (! $user || $user->role !== 'User') abort(403);
    return app(ReportController::class)->storeStep1($request);
})->name('report.step1.store');

Route::get('/report/step-2', function (Request $request) {
    $user = auth()->user();
    if (! $user || $user->role !== 'User') abort(403);
    return app(ReportController::class)->showStep2($request);
})->name('report.step2.show');

Route::post('/report/step-2', function (Request $request) {
    $user = auth()->user();
    if (! $user || $user->role !== 'User') abort(403);
    return app(ReportController::class)->storeStep2($request);
})->name('report.step2.store');

Route::get('/report/success', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'User') abort(403);
    return view('report-success');
})->name('report.success');

// =============================
// 🧑‍⚕️ HALAMAN PSYCHOLOGIST
// =============================
Route::get('/psychologist/chat', function () {
    $user = auth()->user();
    if (! $user || $user->role !== 'Psychologist') abort(403);
    return view('psychologist.chat'); // buat file ini nanti
})->name('psychologist.chat');

// =============================
// 🧑‍💼 HALAMAN ADMIN (SUPERADMIN ONLY)
// =============================
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', function () {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminController::class)->dashboard();
    })->name('dashboard');

    // Role Management
    Route::get('/role', function () {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminRoleController::class)->index();
    })->name('role');

    Route::post('/role', function (Request $request) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminRoleController::class)->store($request);
    })->name('role.store');

    Route::get('/role/{id}', function ($id) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminRoleController::class)->show($id);
    })->name('role.show');

    Route::put('/role/{id}', function (Request $request, $id) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminRoleController::class)->update($request, $id);
    })->name('role.update');

    Route::delete('/role/{id}', function ($id) {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminRoleController::class)->destroy($id);
    })->name('role.destroy');

    // Report
    Route::get('/report', function () {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminController::class)->report();
    })->name('report');

    // Consultation
    Route::get('/consultation', function () {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminController::class)->consultation();
    })->name('consultation');

    // Information
    Route::get('/information', function () {
        $user = auth()->user();
        if (! $user || $user->role !== 'SuperAdmin') abort(403);
        return app(AdminController::class)->information();
    })->name('information');
});

// =============================
// 🔐 AUTH ROUTES (Breeze)
// =============================
require __DIR__ . '/auth.php';
