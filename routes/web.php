<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\CitaController;
use Inertia\Inertia;

// 1. Ruta de registro
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ], [
        'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
    ]);

    $userModel = config('auth.providers.users.model');

    $userModel::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Redirige al login pasando una variable de sesión con el mensaje de éxito
    return redirect()->route('login')->with('success', '¡Cuenta creada exitosamente! Ya puedes iniciar sesión.');
});

// 2. Rutas protegidas para usuarios autenticados
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Módulo de Pacientes (CRUD completo)
    Route::resource('pacientes', PacienteController::class);

    // Citas
    Route::get('/citas/crear', function () {
        return Inertia::render('Citas/Create', [
            'pacientes'      => [],
            'medicos'        => [],
            'especialidades' => [],
            'pacienteActual' => auth()->user(),
        ]);
    })->name('citas.create');

    Route::post('/citas', function (Request $request) {
        // Lógica para guardar la cita...
        return redirect()->route('dashboard');
    })->name('citas.store');

    // Historial clínico
    Route::get('/historial-clinico', function () {
        return Inertia::render('HistorialClinico/Index', [
            'historiales' => []
        ]);
    })->name('historial.index');



    // Módulo de Pacientes (CRUD completo)
Route::resource('pacientes', PacienteController::class);



    // Rutas para Citas
        Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');

    // Si la evaluación de síntomas abre un formulario especial o directo a crear cita:
       Route::get('/evaluacion-ia', function () {
            return Inertia::render('EvaluacionIA/Index'); 
        })->name('evaluacion.index');
});