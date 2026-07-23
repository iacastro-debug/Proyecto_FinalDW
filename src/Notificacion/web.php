<?php

use Illuminate\Support\Facades\Route;
use Src\Notificacion\Application\Controllers\NotificacionWebController;

Route::middleware('auth')->group(function () {
    Route::get('notificaciones', [NotificacionWebController::class, 'index'])->name('notificaciones.index');
    Route::post('notificaciones/{id}/leer', [NotificacionWebController::class, 'markAsRead'])->name('notificaciones.markAsRead');
});
