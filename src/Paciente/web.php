<?php

use Illuminate\Support\Facades\Route;
use Src\Paciente\Application\Controllers\PacienteWebController;

Route::middleware('auth')->group(function () {
    Route::resource('pacientes', PacienteWebController::class);
});
