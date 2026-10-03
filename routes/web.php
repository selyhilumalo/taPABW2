<?php

use App\Http\Controllers\LaporBanjirController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/lapor');

Route::get('/lapor', [LaporBanjirController::class, 'create'])->name('laporbanjir.form');

Route::post('/lapor', [LaporBanjirController::class, 'store'])->name('laporbanjir.kirim');
