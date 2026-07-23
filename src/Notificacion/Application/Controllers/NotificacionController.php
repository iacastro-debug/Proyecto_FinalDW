<?php

namespace Src\Notificacion\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\Notificacion\Infrastructure\Resources\NotificacionResource;
use Src\Notificacion\Infrastructure\Models\NotificacionEloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $notificaciones = NotificacionEloquentModel::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return NotificacionResource::collection($notificaciones);
    }

    public function marcarLeida(Request $request, string $id)
    {
        $notificacion = NotificacionEloquentModel::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$notificacion) {
            return response()->json([
                'success' => false,
                'message' => 'Notificación no encontrada'
            ], 404);
        }

        $notificacion->update(['leida' => true]);

        return new NotificacionResource($notificacion);
    }

    public function marcarTodasLeidas(Request $request)
    {
        NotificacionEloquentModel::where('user_id', $request->user()->id)
            ->where('leida', false)
            ->update(['leida' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas'
        ]);
    }

    public function noLeidas(Request $request)
    {
        $count = NotificacionEloquentModel::where('user_id', $request->user()->id)
            ->where('leida', false)
            ->count();

        return response()->json([
            'success' => true,
            'data' => ['count' => $count]
        ]);
    }
}
