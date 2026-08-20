<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dosen\BimbinganSkripsiController;
use App\Http\Controllers\Dosen\JadwalMengajarController;
use App\Http\Controllers\Dosen\NilaiController;
use App\Http\Controllers\Dosen\PresensiController;
use App\Http\Controllers\Staf\KeuanganSppController;
use App\Http\Controllers\Staf\LaporanAkademikController;
use App\Http\Controllers\Staf\MahasiswaController;
use App\Http\Controllers\Staf\SuratDokumenController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('teleport.auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['teleport.auth', 'role:staf'])->prefix('staf')->name('staf.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staf'])->name('dashboard');
    Route::resource('mahasiswa', MahasiswaController::class)->only(['index']);
    Route::resource('surat-dokumen', SuratDokumenController::class)->only(['index']);
    Route::resource('keuangan-spp', KeuanganSppController::class)->only(['index']);
    Route::resource('laporan-akademik', LaporanAkademikController::class)->only(['index']);
});

Route::middleware(['teleport.auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dosen'])->name('dashboard');
    Route::resource('jadwal-mengajar', JadwalMengajarController::class)->only(['index']);
    Route::resource('nilai', NilaiController::class)->only(['index']);
    Route::resource('presensi', PresensiController::class)->only(['index']);
    Route::resource('bimbingan-skripsi', BimbinganSkripsiController::class)->only(['index']);
});
