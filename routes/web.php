<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaPortalController;

// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role: Administrator & Petugas TU
Route::middleware(['role:admin,petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Transaksi Pembayaran & Cetak Kuitansi Resmi
    Route::get('/transaksi', [PembayaranController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi', [PembayaranController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/history', [PembayaranController::class, 'history'])->name('transaksi.history');
    Route::get('/transaksi/kuitansi/{id}', [PembayaranController::class, 'cetakKuitansi'])->name('transaksi.kuitansi');
});

// Khusus Role: Administrator Saja
Route::middleware(['role:admin'])->group(function () {
    // CRUD Kelas
    Route::resource('kelas', KelasController::class)->except(['create', 'show', 'edit']);

    // CRUD SPP
    Route::resource('spp', SppController::class)->except(['create', 'show', 'edit']);

    // CRUD Petugas
    Route::resource('petugas', PetugasController::class)->except(['create', 'show', 'edit']);

    // CRUD Siswa
    Route::resource('siswa', SiswaController::class)->except(['create', 'show', 'edit']);

    // Generate Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
});

// Khusus Role: Siswa Saja
Route::middleware(['role:siswa'])->group(function () {
    Route::get('/siswa/history', [SiswaPortalController::class, 'history'])->name('siswa.history');
});
