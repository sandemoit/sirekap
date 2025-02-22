<?php

use App\Http\Controllers\OrtangtuaController;
use Illuminate\Support\Facades\Route;

Route::get('/orangtua/akademis', [OrtangtuaController::class, 'akademis'])->name('ortu.akademis');
