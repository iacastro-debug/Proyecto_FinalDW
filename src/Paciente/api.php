<?php

use Illuminate\Support\Facades\Route;
use Src\Paciente\Application\Controllers\PacienteController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('pacientes', PacienteController::class)->names([
        'index' => 'api.pacientes.index',
        'store' => 'api.pacientes.store',
        'show' => 'api.pacientes.show',
        'update' => 'api.pacientes.update',
        'destroy' => 'api.pacientes.destroy',
    ]);
});
