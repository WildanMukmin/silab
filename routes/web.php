<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AdminPeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Public Route
Route::get('/', [DashboardController::class, 'home'])->name('home');

// 🚪 Guest Routes (Hanya untuk user yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// 🔐 Authenticated Routes (Hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ⚙️ ADMIN Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        // CRUD User
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('users', UserController::class);

        // CRUD Alat
        Route::resource('alat', AlatController::class);

        // Peminjaman
        // Note: The routes below seem to be for AdminPeminjamanController but are named peminjaman.
        // It might be clearer to name them admin.peminjaman.*
        // For now, I will keep them as they are to avoid breaking other parts of the app.
        // But consider refactoring the route names and controller for clarity.

        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/peminjaman/export', [AdminPeminjamanController::class, 'export'])->name('peminjaman.export');
        Route::get('/peminjaman/{id}', [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::post('/peminjaman/{id}/verifikasi/{status}', [AdminPeminjamanController::class, 'verifikasi'])->name('peminjaman.verifikasi');
        Route::post('/peminjaman/{id}/update-status', [AdminPeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
        Route::delete('/peminjaman/{id}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

        // Admin profile edit page
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });

    // Profile routes (common for all authenticated users)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
        Route::post('/photo', [ProfileController::class, 'uploadPhoto'])->name('photo');
        Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('photo.delete');
    });

    // 🎓 STUDENT Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'studentDashboard'])->name('dashboard');
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/alat', [AlatController::class, 'studentIndex'])->name('alat.index');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.delete');
    });
});
