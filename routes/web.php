<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\CitaController;
use Inertia\Inertia;


Route::get('/login', function () {
    return Inertia::render('Auth/Login'); // o la ruta de tu componente Vue de Login
})->name('login');


/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Ruta de Registro de Usuarios
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ], [
        'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
    ]);

    $userModel = config('auth.providers.users.model');

    $user = $userModel::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Asignar rol por defecto a los que se registran desde la web
    $user->assignRole('Paciente');

    return redirect()->route('login')->with('success', '¡Cuenta creada exitosamente! Ya puedes iniciar sesión.');
});


/*
|--------------------------------------------------------------------------
| 2. RUTAS PROTEGIDAS (USUARIOS AUTENTICADOS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard General (Acceso para todos los autenticados)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | MÓDULO ADMINISTRADOR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:administrar sistema'])->prefix('admin')->group(function () {
        // Gestión de Usuarios y Roles
        Route::get('/usuarios', function () {
            return Inertia::render('Admin/Usuarios/Index');
        })->name('admin.usuarios.index');

        // Registro de Especialidades
        Route::get('/especialidades', function () {
            return Inertia::render('Admin/Especialidades/Index');
        })->name('admin.especialidades.index');

        // Registro de Médicos
        Route::get('/medicos', function () {
            return Inertia::render('Admin/Medicos/Index');
        })->name('admin.medicos.index');

        // Configuración de Horarios
        Route::get('/horarios', function () {
            return Inertia::render('Admin/Horarios/Index');
        })->name('admin.horarios.index');

        // Consulta de Reportes
        Route::get('/reportes', function () {
            return Inertia::render('Admin/Reportes/Index');
        })->name('admin.reportes.index');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO RECEPCIONISTA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:agendar citas recepcion'])->prefix('recepcion')->group(function () {
        // Módulo de Pacientes (CRUD completo)
        Route::resource('pacientes', PacienteController::class);

        // Agendar y Reprogramar Citas desde Recepción
        Route::get('/citas', [CitaController::class, 'index'])->name('recepcion.citas.index');
        Route::get('/citas/crear', [CitaController::class, 'create'])->name('recepcion.citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('recepcion.citas.store');

        // Consultar Disponibilidad de Médicos & Confirmar Asistencia
        Route::get('/disponibilidad-medicos', function () {
            return Inertia::render('Recepcion/DisponibilidadMedicos');
        })->name('recepcion.disponibilidad');

        Route::post('/citas/{id}/confirmar-asistencia', function ($id) {
            // Lógica para confirmar asistencia
            return back()->with('success', 'Asistencia confirmada');
        })->name('recepcion.citas.confirmar');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO MÉDICO
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:consultar citas asignadas'])->prefix('medico')->group(function () {
        // Consultar citas asignadas
        Route::get('/agenda', function () {
            return Inertia::render('Medico/Agenda');
        })->name('medico.agenda');

        // Historial Clínico
        Route::get('/historial-clinico', function () {
            return Inertia::render('HistorialClinico/Index', [
                'historiales' => []
            ]);
        })->name('historial.index');

        // Marcar citas como atendidas
        Route::post('/citas/{id}/atendida', function ($id) {
            // Lógica para marcar como atendida
            return back()->with('success', 'Cita marcada como atendida');
        })->name('medico.citas.atendida');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO PACIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:agendar citas paciente'])->prefix('paciente')->group(function () {
        // Consultar citas propias
        Route::get('/mis-citas', function () {
            return Inertia::render('Paciente/MisCitas');
        })->name('paciente.citas.index');

        // Agendar citas como paciente
        Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');

        // Evaluación de Síntomas con IA
        Route::get('/evaluacion-ia', function () {
            return Inertia::render('EvaluacionIA/Index');
        })->name('evaluacion.index');
    });

});