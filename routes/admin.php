<?php

use App\Http\Controllers\Admin\ClassesController;
use App\Http\Controllers\Admin\CompetitionsController;
use App\Http\Controllers\Admin\MapelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\LaporanKehadiranController;
use App\Http\Controllers\LaporanNilaiController;
use App\Http\Middleware\HasRoleAdmin;

// manajemen siswa
Route::middleware(HasRoleAdmin::class)->group(function () {
    Route::get('/siswa/list', [StudentController::class, 'index'])->name('students');
    Route::get('/data/siswa', [StudentController::class, 'dataSiswa'])->name('students.data');
    Route::get('/siswa/add', [StudentController::class, 'add'])->name('students.add');
    Route::post('/siswa/add', [StudentController::class, 'store'])->name('students.store');
    Route::post('/siswa/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/siswa/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/siswa/update/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::get('/siswa/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('/siswa/import', [StudentController::class, 'importProcess'])->name('students.importProcess');
    Route::get('/kelas/list', [ClassesController::class, 'index'])->name('class');
    Route::post('/kelas/add', [ClassesController::class, 'store'])->name('class.add');
    Route::get('/kelas/destroy/{id}', [ClassesController::class, 'destroy'])->name('class.destroy');
    Route::put('/kelas/update/{id}', [ClassesController::class, 'update'])->name('class.update');

    // manajemen user
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
    Route::get('/user-management/data', [UserManagementController::class, 'data'])->name('user-management.data');
    Route::get('/users/add', [UserManagementController::class, 'add'])->name('users.add');
    Route::post('/users/add', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/users/update/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::post('/users/destroy/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // pengaturan umum
    Route::get('/pengaturan-umum', [SettingController::class, 'index'])->name('setting');
    Route::put('/pengaturan-umum', [SettingController::class, 'identitas'])->name('setting.identitas');
    Route::put('/pengaturan-umum/kepala-sekolah', [SettingController::class, 'kepala_sekolah'])->name('setting.kepala_sekolah');
    Route::put('/pengaturan-umum/tahun-ajaran', [SettingController::class, 'tahun_ajaran'])->name('setting.tahun_ajaran');
    Route::put('/pengaturan-umum/logo', [SettingController::class, 'logo'])->name('setting.logo');

    // competitions
    Route::get('/kejuaraan', [CompetitionsController::class, 'index'])->name('competition');
    Route::get('/kejuaraan/add', [CompetitionsController::class, 'add'])->name('competition.add');
    Route::post('/kejuaraan/add', [CompetitionsController::class, 'store'])->name('competition.store');

    // subject
    Route::get('/mapel', [MapelController::class, 'index'])->name('subject');
    Route::post('/mapel/store', [MapelController::class, 'store'])->name('subject.store');
    Route::post('/mapel/destroy/{id}', [MapelController::class, 'destroy'])->name('subject.destroy');
    Route::get('/getMapel', [MapelController::class, 'getMapel'])->name('subject.getMapel');

    // naik kelas
    Route::post('/up-class', [StudentController::class, 'upClass'])->name('upclass');

    // laporan
    Route::get('/laporan/kehadiran', [LaporanKehadiranController::class, 'index'])->name('report.kehadiran');
    Route::get('/laporan/kehadiran/export', [LaporanKehadiranController::class, 'exportPDF'])->name('laporan.kehadiran.export');
    Route::get('/laporan/nilai', [LaporanNilaiController::class, 'index'])->name('report.nilai');
    Route::get('/laporan/nilai/export', [LaporanNilaiController::class, 'exportLaporanNilai'])->name('laporan.nilai.export');
});
