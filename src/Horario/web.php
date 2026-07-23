<?php

use Illuminate\Support\Facades\Route;
use Src\Horario\Application\Controllers\HorarioWebController;

Route::middleware('auth')->group(function () {
    Route::resource('horarios', HorarioWebController::class);
});
