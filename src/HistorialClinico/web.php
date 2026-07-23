<?php

use Illuminate\Support\Facades\Route;
use Src\HistorialClinico\Application\Controllers\HistorialClinicoWebController;

Route::middleware('auth')->group(function () {
    Route::get('historiales-clinicos', [HistorialClinicoWebController::class, 'index'])->name('historiales-clinicos.index');
    Route::get('historiales-clinicos/{id}', [HistorialClinicoWebController::class, 'show'])->name('historiales-clinicos.show');
});
