<?php

use Illuminate\Support\Facades\Route;
use Src\HistorialClinico\Application\Controllers\HistorialClinicoWebController;

Route::middleware(['auth', 'role:admin,medico'])->group(function () {
    Route::get('historiales-clinicos/crear/{cita?}', [HistorialClinicoWebController::class, 'create'])->name('historiales-clinicos.create');
    Route::post('historiales-clinicos', [HistorialClinicoWebController::class, 'store'])->name('historiales-clinicos.store');
});

Route::middleware(['auth', 'role:admin,medico,paciente'])->group(function () {
    Route::get('historiales-clinicos', [HistorialClinicoWebController::class, 'index'])->name('historiales-clinicos.index');
    Route::get('historiales-clinicos/{id}', [HistorialClinicoWebController::class, 'show'])->name('historiales-clinicos.show');
});

Route::middleware(['auth', 'role:admin,medico'])->group(function () {
    Route::get('historiales-clinicos/{id}/editar', [HistorialClinicoWebController::class, 'edit'])->name('historiales-clinicos.edit');
    Route::put('historiales-clinicos/{id}', [HistorialClinicoWebController::class, 'update'])->name('historiales-clinicos.update');
});
