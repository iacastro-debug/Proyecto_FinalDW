<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController; // 👈 1. IMPORTAR PACIENTECONTROLLER

// Rutas protegidas (autenticadas)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 👈 2. AGREGAR LA RUTA DE PACIENTES AQUÍ
    Route::resource('pacientes', PacienteController::class);
});
