<?php

namespace Src\Notificacion\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Notificacion\Infrastructure\Models\NotificacionEloquentModel;
use Inertia\Inertia;

class NotificacionWebController extends Controller
{
    public function index()
    {
        $notificaciones = NotificacionEloquentModel::with('user')->latest()->get();
        return Inertia::render('Notificacion/index', ['notificaciones' => $notificaciones]);
    }

    public function markAsRead(string $id)
    {
        $notificacion = NotificacionEloquentModel::findOrFail($id);
        $notificacion->update(['leido' => true]);
        return redirect()->back()->with('success', 'Notificación marcada como leída');
    }
}
