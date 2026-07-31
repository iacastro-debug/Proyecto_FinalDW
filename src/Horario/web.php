<?php

use Illuminate\Support\Facades\Route;
use Src\Horario\Application\Controllers\HorarioWebController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('horarios/crear', [HorarioWebController::class, 'create'])->name('horarios.create');
});

Route::middleware(['auth', 'role:admin,medico'])->group(function () {
    Route::get('horarios', [HorarioWebController::class, 'index'])->name('horarios.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('horarios', [HorarioWebController::class, 'store'])->name('horarios.store');
    Route::get('horarios/{id}/editar', [HorarioWebController::class, 'edit'])->name('horarios.edit');
    Route::put('horarios/{id}', [HorarioWebController::class, 'update'])->name('horarios.update');
    Route::delete('horarios/{id}', [HorarioWebController::class, 'destroy'])->name('horarios.destroy');
});
