<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;

// Rutas protegidas (autenticadas)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Gestión de pacientes: solo administrador
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('pacientes', PacienteController::class);
});
