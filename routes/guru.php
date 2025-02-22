<?php

use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\HasRoleGuru;
use Illuminate\Support\Facades\Route;

// kehadiran
Route::get('/kehadiran', [KehadiranController::class, 'input'])->name('kehadiran');
Route::post('/kehadiran/get-siswa', [KehadiranController::class, 'getSiswa'])->name('kehadiran.get-siswa');
Route::post('/kehadiran', [KehadiranController::class, 'store'])->name('kehadiran.store');
Route::get('/kehadiran/rekap', [KehadiranController::class, 'rekap'])->name('kehadiran.rekap');
Route::get('/kehadiran/import', [KehadiranController::class, 'import'])->name('kehadiran.import');
Route::post('/kehadiran/import', [KehadiranController::class, 'importProcess'])->name('kehadiran.importProcess');
Route::get('/getDataRekap', [KehadiranController::class, 'getDataRekap'])->name('kehadiran.getDataRekap');

// penilaian
Route::get('/penilaian', [PenilaianController::class, 'input'])->name('penilaian');
Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store');
Route::post('/penilaian/get-siswa', [PenilaianController::class, 'getSiswa'])->name('penilaian.get-siswa');
Route::get('/penilaian/import', [PenilaianController::class, 'import'])->name('penilaian.import');
Route::post('/penilaian/import', [PenilaianController::class, 'importProcess'])->name('penilaian.importProcess');

Route::middleware(HasRoleGuru::class)->group(function () {
    // siswa
    Route::get('/siswa', [StudentController::class, 'index'])->name('guru.students');
    Route::post('/siswa/{id}', [StudentController::class, 'storeDeskripsi'])->name('guru.students.deskripsi');
    Route::get('/siswa/data', [StudentController::class, 'data'])->name('guru.students.data');
});
