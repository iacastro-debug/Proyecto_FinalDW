<?php

use Illuminate\Support\Facades\Route;
use Src\Cita\Application\Controllers\CitaController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('citas', CitaController::class)->names([
        'index' => 'api.citas.index',
        'store' => 'api.citas.store',
        'show' => 'api.citas.show',
        'update' => 'api.citas.update',
        'destroy' => 'api.citas.destroy',
    ]);

    Route::patch('citas/{id}/cancelar', [CitaController::class, 'cancelar'])->name('api.citas.cancelar');
});
