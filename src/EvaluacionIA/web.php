<?php

use Illuminate\Support\Facades\Route;
use Src\EvaluacionIA\Application\Controllers\EvaluacionIAWebController;

Route::middleware('auth')->group(function () {
    Route::get('evaluaciones-ia', [EvaluacionIAWebController::class, 'index'])->name('evaluaciones-ia.index');
    Route::get('evaluaciones-ia/crear', [EvaluacionIAWebController::class, 'create'])->name('evaluaciones-ia.create');
    Route::post('evaluaciones-ia', [EvaluacionIAWebController::class, 'store'])->name('evaluaciones-ia.store');
    Route::get('evaluaciones-ia/{id}', [EvaluacionIAWebController::class, 'show'])->name('evaluaciones-ia.show');
});
