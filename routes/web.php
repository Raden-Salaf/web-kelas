<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ServiceController;

// ==============================================
// PUBLIC ROUTES (bisa diakses siapa saja)
// ==============================================

// Landing page — halaman utama untuk guest
Route::get('/', [ServiceController::class, 'landing'])->name('landing');

// Halaman berita publik
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

// Halaman galeri publik (hanya lihat)
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');

// Halaman jasa publik
Route::get('/jasa', [ServiceController::class, 'publicIndex'])->name('services.index');

// ==============================================
// AUTH ROUTES
// ==============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==============================================
// SISWA ROUTES (harus login + role siswa)
// ==============================================
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedule');
        Route::get('/pr', [HomeworkController::class, 'index'])->name('homework');
        Route::get('/galeri', [GalleryController::class, 'siswaIndex'])->name('gallery');
        Route::get('/berita', [NewsController::class, 'siswaIndex'])->name('news');
        Route::get('/jasa', [ServiceController::class, 'siswaIndex'])->name('services');
    });

// ==============================================
// ADMIN ROUTES (harus login + role admin)
// ==============================================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Kelola PR
        Route::resource('homework', HomeworkController::class)->except(['show']);

        // Kelola Jadwal
        Route::resource('schedule', ScheduleController::class)->except(['show']);

        // Kelola Akun Siswa
        Route::get('/siswa', [AdminController::class, 'siswaList'])->name('siswa.index');
        Route::get('/siswa/create', [AdminController::class, 'siswaCreate'])->name('siswa.create');
        Route::post('/siswa', [AdminController::class, 'siswaStore'])->name('siswa.store');
        Route::delete('/siswa/{user}', [AdminController::class, 'siswaDestroy'])->name('siswa.destroy');

        // Kelola Galeri
        Route::resource('gallery', GalleryController::class)->except(['show', 'edit', 'update']);

        // Kelola Berita
        Route::resource('news', NewsController::class)->except(['show']);
        Route::patch('/news/{news}/publish', [NewsController::class, 'publish'])->name('news.publish');

        // Kelola Jasa
        Route::resource('service', ServiceController::class)->except(['show']);

        // Pengaturan Website
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    });