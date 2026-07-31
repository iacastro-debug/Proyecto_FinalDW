<?php

use Illuminate\Support\Facades\Route;
use Src\Especialidad\Application\Controllers\EspecialidadWebController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('especialidades', EspecialidadWebController::class);
});
