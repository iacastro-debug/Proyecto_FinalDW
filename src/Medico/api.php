<?php

use Illuminate\Support\Facades\Route;
use Src\Medico\Application\Controllers\MedicoController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('medicos', [MedicoController::class, 'index'])->name('api.medicos.index');
    Route::get('medicos/{id}', [MedicoController::class, 'show'])->name('api.medicos.show');

    Route::middleware('role:admin')->group(function () {
        Route::post('medicos', [MedicoController::class, 'store'])->name('api.medicos.store');
        Route::put('medicos/{id}', [MedicoController::class, 'update'])->name('api.medicos.update');
        Route::delete('medicos/{id}', [MedicoController::class, 'destroy'])->name('api.medicos.destroy');
    });
});
