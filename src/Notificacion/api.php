<?php

use Illuminate\Support\Facades\Route;
use Src\Notificacion\Application\Controllers\NotificacionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('notificaciones', [NotificacionController::class, 'index'])->name('api.notificaciones.index');
    Route::get('notificaciones/no-leidas', [NotificacionController::class, 'noLeidas'])->name('api.notificaciones.no-leidas');
    Route::patch('notificaciones/{id}/leida', [NotificacionController::class, 'marcarLeida'])->name('api.notificaciones.marcar-leida');
    Route::post('notificaciones/todas-leidas', [NotificacionController::class, 'marcarTodasLeidas'])->name('api.notificaciones.todas-leidas');
});
