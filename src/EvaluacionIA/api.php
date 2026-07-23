<?php

use Illuminate\Support\Facades\Route;
use Src\EvaluacionIA\Application\Controllers\EvaluacionIAController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('evaluaciones-ia', [EvaluacionIAController::class, 'index'])->name('api.evaluaciones-ia.index');
    Route::post('evaluaciones-ia', [EvaluacionIAController::class, 'store'])->name('api.evaluaciones-ia.store');
    Route::get('evaluaciones-ia/{id}', [EvaluacionIAController::class, 'show'])->name('api.evaluaciones-ia.show');
});
