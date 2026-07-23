<?php

use Illuminate\Support\Facades\Route;
use Src\Especialidad\Application\Controllers\EspecialidadWebController;

Route::middleware('auth')->group(function () {
    Route::resource('especialidades', EspecialidadWebController::class);
});
