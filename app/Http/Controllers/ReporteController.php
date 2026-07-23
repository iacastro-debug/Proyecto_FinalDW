<?php

namespace App\Http\Controllers;

use Src\Cita\Infrastructure\Models\CitaEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Src\EvaluacionIA\Infrastructure\Models\EvaluacionIAEloquentModel;
use Src\Especialidad\Infrastructure\Models\EspecialidadEloquentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function citasPorFecha(Request $request)
    {
        $desde = $request->get('desde', now()->subMonth()->toDateString());
        $hasta = $request->get('hasta', now()->toDateString());

        $citas = CitaEloquentModel::selectRaw('DATE(fecha_cita) as fecha, COUNT(*) as total')
            ->whereBetween('fecha_cita', [$desde, $hasta])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return response()->json(['success' => true, 'data' => $citas]);
    }

    public function citasPorMedico()
    {
        $citas = CitaEloquentModel::selectRaw('medico_id, COUNT(*) as total')
            ->with('medico.user')
            ->groupBy('medico_id')
            ->get()
            ->map(fn($c) => [
                'medico' => $c->medico?->user?->name ?? 'Desconocido',
                'total' => $c->total,
            ]);

        return response()->json(['success' => true, 'data' => $citas]);
    }

    public function citasPorEspecialidad()
    {
        $citas = CitaEloquentModel::selectRaw('especialidad_id, COUNT(*) as total')
            ->with('especialidad')
            ->groupBy('especialidad_id')
            ->get()
            ->map(fn($c) => [
                'especialidad' => $c->especialidad?->nombre ?? 'Desconocida',
                'total' => $c->total,
            ]);

        return response()->json(['success' => true, 'data' => $citas]);
    }

    public function citasCanceladas()
    {
        $total = CitaEloquentModel::where('estado', 'cancelada')->count();
        $porMes = CitaEloquentModel::selectRaw("TO_CHAR(fecha_cita, 'YYYY-MM') as mes, COUNT(*) as total")
            ->where('estado', 'cancelada')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json([
            'success' => true,
            'data' => ['total' => $total, 'porMes' => $porMes]
        ]);
    }

    public function pacientesAtendidos(Request $request)
    {
        $desde = $request->get('desde', now()->subMonth()->toDateString());
        $hasta = $request->get('hasta', now()->toDateString());

        $total = CitaEloquentModel::where('estado', 'atendida')
            ->whereBetween('fecha_cita', [$desde, $hasta])
            ->distinct('paciente_id')
            ->count('paciente_id');

        return response()->json(['success' => true, 'data' => ['total' => $total]]);
    }

    public function evaluacionesIA()
    {
        $total = EvaluacionIAEloquentModel::count();
        $simuladas = EvaluacionIAEloquentModel::where('modo_simulado', true)->count();
        $reales = EvaluacionIAEloquentModel::where('modo_simulado', false)->count();
        $usadasParaCita = EvaluacionIAEloquentModel::where('estado', 'usada_para_cita')->count();

        $porEspecialidad = EvaluacionIAEloquentModel::selectRaw('especialidad_sugerida, COUNT(*) as total')
            ->whereNotNull('especialidad_sugerida')
            ->groupBy('especialidad_sugerida')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'simuladas' => $simuladas,
                'reales' => $reales,
                'usadasParaCita' => $usadasParaCita,
                'porEspecialidad' => $porEspecialidad,
            ]
        ]);
    }

    public function dashboard()
    {
        $totalPacientes = PacienteEloquentModel::count();
        $totalMedicos = MedicoEloquentModel::count();
        $totalEspecialidades = EspecialidadEloquentModel::count();

        $citasHoy = CitaEloquentModel::where('fecha_cita', now()->toDateString())->count();
        $citasPendientes = CitaEloquentModel::whereIn('estado', ['pendiente', 'confirmada'])->count();
        $citasAtendidas = CitaEloquentModel::where('estado', 'atendida')->count();
        $citasCanceladas = CitaEloquentModel::where('estado', 'cancelada')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'totalPacientes' => $totalPacientes,
                'totalMedicos' => $totalMedicos,
                'totalEspecialidades' => $totalEspecialidades,
                'citasHoy' => $citasHoy,
                'citasPendientes' => $citasPendientes,
                'citasAtendidas' => $citasAtendidas,
                'citasCanceladas' => $citasCanceladas,
            ]
        ]);
    }
}
