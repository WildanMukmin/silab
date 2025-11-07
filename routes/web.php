<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AdminPeminjamanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [DashboardController::class, 'home'])->name('home');

// Guest Routes (Only accessible when not logged in)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Routes
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('alat', AlatController::class);
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/export', [AdminPeminjamanController::class, 'export'])->name('peminjaman.export');
    Route::get('/peminjaman/{id}', [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::post('/peminjaman/{id}/verifikasi/{status}', [AdminPeminjamanController::class, 'verifikasi'])->name('peminjaman.verifikasi');
    Route::post('/peminjaman/{id}/update-status', [AdminPeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::delete('/peminjaman/{id}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});


    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/alat', [AlatController::class, 'studentIndex'])->name('alat.index');
    });

    
});