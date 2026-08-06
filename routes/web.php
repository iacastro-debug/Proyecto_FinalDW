<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\Admin\UserController;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| 1. RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

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

    $user->assignRole('Paciente');

    return redirect()->route('login')->with('success', '¡Cuenta creada exitosamente! Ya puedes iniciar sesión.');
});

/*
|--------------------------------------------------------------------------
| 2. RUTAS PROTEGIDAS (USUARIOS AUTENTICADOS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard General
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | MÓDULO ADMINISTRADOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->as('admin.')->group(function () {
        
        // Gestión de Usuarios y Roles
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');

        // Registro de Especialidades
        Route::get('/especialidades', function () {
            return Inertia::render('Admin/Especialidades/Index');
        })->name('especialidades.index');

        // Registro de Médicos
        Route::get('/medicos', function () {
            return Inertia::render('Admin/Medicos/Index');
        })->name('medicos.index');

        // Configuración de Horarios
        Route::get('/horarios', function () {
            return Inertia::render('Admin/Horarios/Index');
        })->name('horarios.index');

        // Consulta de Reportes
        Route::get('/reportes', function () {
            return Inertia::render('Admin/Reportes/Index');
        })->name('reportes.index');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO RECEPCIONISTA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:agendar citas recepcion'])->prefix('recepcion')->group(function () {
        Route::resource('pacientes', PacienteController::class);

        Route::get('/citas', [CitaController::class, 'index'])->name('recepcion.citas.index');
        Route::get('/citas/crear', [CitaController::class, 'create'])->name('recepcion.citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('recepcion.citas.store');

        Route::get('/disponibilidad-medicos', function () {
            return Inertia::render('Recepcion/DisponibilidadMedicos');
        })->name('recepcion.disponibilidad');

        Route::post('/citas/{id}/confirmar-asistencia', function ($id) {
            return back()->with('success', 'Asistencia confirmada');
        })->name('recepcion.citas.confirmar');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO MÉDICO
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:consultar citas asignadas'])->prefix('medico')->group(function () {
        Route::get('/agenda', function () {
            return Inertia::render('Medico/Agenda');
        })->name('medico.agenda');

        Route::get('/historial-clinico', function () {
            return Inertia::render('HistorialClinico/Index', [
                'historiales' => []
            ]);
        })->name('historial.index');

        Route::post('/citas/{id}/atendida', function ($id) {
            return back()->with('success', 'Cita marcada como atendida');
        })->name('medico.citas.atendida');
    });

    /*
    |--------------------------------------------------------------------------
    | MÓDULO PACIENTE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['permission:agendar citas paciente'])->prefix('paciente')->group(function () {
        Route::get('/mis-citas', function () {
            return Inertia::render('Paciente/MisCitas');
        })->name('paciente.citas.index');

        Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');

        Route::get('/evaluacion-ia', function () {
            return Inertia::render('EvaluacionIA/Index');
        })->name('evaluacion.index');
    });

});