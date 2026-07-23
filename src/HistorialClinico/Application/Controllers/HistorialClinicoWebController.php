<?php

namespace Src\HistorialClinico\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\HistorialClinico\Infrastructure\Models\HistorialClinicoEloquentModel;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Inertia\Inertia;

class HistorialClinicoWebController extends Controller
{
    public function index()
    {
        $historiales = HistorialClinicoEloquentModel::with('paciente.user')->latest()->get();
        return Inertia::render('HistorialClinico/index', ['historiales' => $historiales]);
    }

    public function show(string $id)
    {
        $historial = HistorialClinicoEloquentModel::with('paciente.user')->findOrFail($id);
        return Inertia::render('HistorialClinico/show', ['historial' => $historial]);
    }
}
