<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\RatingController;


Route::get('/', [HomeController::class, 'index']);


Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/auth/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::get('/add-layanan', [LayananController::class, 'add_layanan'])->name('add-layanan');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{id}', [LayananController::class, 'edit'])->name('edit-layanan');
    Route::post('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::post('/gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
    Route::get('/artikel/data', [ArtikelController::class, 'artikel'])->name('artikel.data');
    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel/store', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{artikel}', [ArtikelController::class, 'show'])->name('artikel.show');
    Route::get('/artikel/{artikel}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::post('/artikel/{artikel}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{artikel}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    Route::get('/rating', [RatingController::class, 'index'])->name('rating');
});
