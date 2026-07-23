<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteController;

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('reportes')->group(function () {
    Route::get('dashboard', [ReporteController::class, 'dashboard'])->name('api.reportes.dashboard');
    Route::get('citas-por-fecha', [ReporteController::class, 'citasPorFecha'])->name('api.reportes.citas-por-fecha');
    Route::get('citas-por-medico', [ReporteController::class, 'citasPorMedico'])->name('api.reportes.citas-por-medico');
    Route::get('citas-por-especialidad', [ReporteController::class, 'citasPorEspecialidad'])->name('api.reportes.citas-por-especialidad');
    Route::get('citas-canceladas', [ReporteController::class, 'citasCanceladas'])->name('api.reportes.citas-canceladas');
    Route::get('pacientes-atendidos', [ReporteController::class, 'pacientesAtendidos'])->name('api.reportes.pacientes-atendidos');
    Route::get('evaluaciones-ia', [ReporteController::class, 'evaluacionesIA'])->name('api.reportes.evaluaciones-ia');
});
