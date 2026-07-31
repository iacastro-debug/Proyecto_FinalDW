<?php

use Illuminate\Support\Facades\Route;
use Src\Medico\Application\Controllers\MedicoWebController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('medicos', MedicoWebController::class);
});
