<?php

use Illuminate\Support\Facades\Route;
use Src\Cita\Application\Controllers\CitaWebController;

Route::middleware(['auth', 'role:admin,paciente'])->group(function () {
    Route::get('citas/crear', [CitaWebController::class, 'create'])->name('citas.create');
});

Route::middleware('auth')->group(function () {
    Route::get('citas', [CitaWebController::class, 'index'])->name('citas.index');
});

Route::middleware(['auth', 'role:admin,paciente'])->group(function () {
    Route::post('citas', [CitaWebController::class, 'store'])->name('citas.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('citas/{id}/editar', [CitaWebController::class, 'edit'])->name('citas.edit');
    Route::put('citas/{id}', [CitaWebController::class, 'update'])->name('citas.update');
    Route::delete('citas/{id}', [CitaWebController::class, 'destroy'])->name('citas.destroy');
});
