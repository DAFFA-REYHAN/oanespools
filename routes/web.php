<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');

    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::get('/add-layanan', [LayananController::class, 'add_layanan'])->name('add-layanan');
    Route::post('/layanan/upload', [LayananController::class, 'upload'])->name('layanan.upload');
    Route::post('/layanan/delete-upload', [LayananController::class, 'deleteUpload'])->name('layanan.deleteUpload');
    Route::post('/layanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::get('/layanan/{id}', [LayananController::class, 'edit'])->name('edit-layanan');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');
});


