<?php

use Illuminate\Support\Facades\Route;
use Src\Horario\Application\Controllers\HorarioController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('horarios', [HorarioController::class, 'index'])->name('api.horarios.index');
    Route::get('horarios/{id}', [HorarioController::class, 'show'])->name('api.horarios.show');

    Route::middleware('role:admin')->group(function () {
        Route::post('horarios', [HorarioController::class, 'store'])->name('api.horarios.store');
        Route::put('horarios/{id}', [HorarioController::class, 'update'])->name('api.horarios.update');
        Route::delete('horarios/{id}', [HorarioController::class, 'destroy'])->name('api.horarios.destroy');
    });
});
