<?php

use Illuminate\Support\Facades\Route;
use Src\HistorialClinico\Application\Controllers\HistorialClinicoController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('historiales-clinicos', [HistorialClinicoController::class, 'index'])->name('api.historiales-clinicos.index');
    Route::get('historiales-clinicos/{id}', [HistorialClinicoController::class, 'show'])->name('api.historiales-clinicos.show');

    Route::middleware('role:medico')->group(function () {
        Route::post('historiales-clinicos', [HistorialClinicoController::class, 'store'])->name('api.historiales-clinicos.store');
        Route::put('historiales-clinicos/{id}', [HistorialClinicoController::class, 'update'])->name('api.historiales-clinicos.update');
    });
});
