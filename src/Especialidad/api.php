<?php

use Illuminate\Support\Facades\Route;
use Src\Especialidad\Application\Controllers\EspecialidadController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('especialidades', [EspecialidadController::class, 'index'])->name('api.especialidades.index');
    Route::get('especialidades/{id}', [EspecialidadController::class, 'show'])->name('api.especialidades.show');

    Route::middleware('role:admin')->group(function () {
        Route::post('especialidades', [EspecialidadController::class, 'store'])->name('api.especialidades.store');
        Route::put('especialidades/{id}', [EspecialidadController::class, 'update'])->name('api.especialidades.update');
        Route::delete('especialidades/{id}', [EspecialidadController::class, 'destroy'])->name('api.especialidades.destroy');
    });
});
