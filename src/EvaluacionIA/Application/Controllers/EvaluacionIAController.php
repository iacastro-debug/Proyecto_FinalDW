<?php

namespace Src\EvaluacionIA\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Services\GroqService;
use Src\EvaluacionIA\Infrastructure\Requests\StoreEvaluacionIARequest;
use Src\EvaluacionIA\Infrastructure\Resources\EvaluacionIAResource;
use Src\EvaluacionIA\Infrastructure\Models\EvaluacionIAEloquentModel;
use Src\Medico\Infrastructure\Models\MedicoEloquentModel;
use Illuminate\Support\Str;

class EvaluacionIAController extends Controller
{
    public function __construct(
        private GroqService $groqService
    ) {}

    public function index()
    {
        $evaluaciones = EvaluacionIAEloquentModel::with('paciente.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return EvaluacionIAResource::collection($evaluaciones);
    }

    public function store(StoreEvaluacionIARequest $request)
    {
        $data = $request->validated();

        $edad = $data['edad'] ?? $this->calcularEdadDesdePaciente($data['paciente_id']);

        $resultadoIA = $this->groqService->evaluarSintomas(array_merge($data, ['edad' => $edad]));

        $evaluacion = EvaluacionIAEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'paciente_id' => $data['paciente_id'],
            'edad' => $edad,
            'genero' => $data['genero'] ?? null,
            'sintomas_principales' => $data['sintomas_principales'],
            'duracion_sintomas' => $data['duracion_sintomas'] ?? null,
            'nivel_dolor' => $data['nivel_dolor'] ?? null,
            'fiebre' => $data['fiebre'] ?? false,
            'dificultad_respirar' => $data['dificultad_respirar'] ?? false,
            'dolor_pecho' => $data['dolor_pecho'] ?? false,
            'antecedentes' => $data['antecedentes'] ?? null,
            'urgencia_percibida' => $data['urgencia_percibida'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'especialidad_sugerida' => $resultadoIA['especialidad_sugerida'],
            'prioridad' => $resultadoIA['prioridad'],
            'motivo' => $resultadoIA['motivo'],
            'advertencia' => $resultadoIA['advertencia'],
            'respuesta_raw' => $resultadoIA['respuesta_raw'],
            'modo_simulado' => $this->groqService->isSimulated(),
            'estado' => 'generada',
        ]);

        $evaluacion->load('paciente.user');

        $medicosDisponibles = MedicoEloquentModel::with('user')
            ->whereHas('especialidad', function ($query) use ($resultadoIA) {
                $query->where('nombre', $resultadoIA['especialidad_sugerida']);
            })
            ->where('activo', true)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Evaluación realizada exitosamente',
            'data' => [
                'evaluacion' => new EvaluacionIAResource($evaluacion),
                'medicos_disponibles' => $medicosDisponibles->map(fn($m) => [
                    'id' => $m->id,
                    'nombre' => $m->user?->name,
                    'telefono' => $m->telefono,
                ]),
            ],
        ], 201);
    }

    public function show(string $id)
    {
        $evaluacion = EvaluacionIAEloquentModel::with('paciente.user')->find($id);

        if (!$evaluacion) {
            return response()->json([
                'success' => false,
                'message' => 'Evaluación no encontrada'
            ], 404);
        }

        return new EvaluacionIAResource($evaluacion);
    }

    protected function calcularEdadDesdePaciente(string $pacienteId): ?int
    {
        $paciente = \Src\Paciente\Infrastructure\Models\PacienteEloquentModel::find($pacienteId);

        if ($paciente && $paciente->fecha_nacimiento) {
            return $paciente->fecha_nacimiento->age;
        }

        return null;
    }
}
