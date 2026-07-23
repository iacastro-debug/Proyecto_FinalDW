<?php

use Illuminate\Support\Facades\Route;
use Src\Cita\Application\Controllers\CitaWebController;

Route::middleware('auth')->group(function () {
    Route::resource('citas', CitaWebController::class);
});
