<?php

namespace Src\EvaluacionIA\Application\Controllers;

use App\Http\Controllers\Controller;
use Src\EvaluacionIA\Infrastructure\Models\EvaluacionIAEloquentModel;
use App\Services\GroqService;
use Src\Paciente\Infrastructure\Models\PacienteEloquentModel;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class EvaluacionIAWebController extends Controller
{
    public function index(): Response
    {
        $evaluaciones = EvaluacionIAEloquentModel::with('paciente.user')->latest()->get();
        return Inertia::render('EvaluacionIA/index', ['evaluaciones' => $evaluaciones]);
    }

    public function create(): Response
    {
        $pacientes = PacienteEloquentModel::with('user')->where('activo', true)->get();
        return Inertia::render('EvaluacionIA/create', ['pacientes' => $pacientes]);
    }

    public function store(): RedirectResponse
    {
        $data = request()->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'edad' => 'nullable|integer|min:0|max:150',
            'genero' => 'nullable|string|max:20',
            'sintomas_principales' => 'required|string|max:2000',
            'duracion_sintomas' => 'nullable|string|max:255',
            'nivel_dolor' => 'nullable|integer|min:1|max:10',
            'fiebre' => 'boolean',
            'dificultad_respirar' => 'boolean',
            'dolor_pecho' => 'boolean',
            'antecedentes' => 'nullable|string|max:2000',
            'urgencia_percibida' => 'nullable|in:baja,media,alta',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $data['fiebre'] = $data['fiebre'] ?? false;
        $data['dificultad_respirar'] = $data['dificultad_respirar'] ?? false;
        $data['dolor_pecho'] = $data['dolor_pecho'] ?? false;

        $paciente = PacienteEloquentModel::find($data['paciente_id']);
        $edad = $data['edad'] ?? ($paciente && $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->age : null);

        $groq = app(GroqService::class);
        $resultadoIA = $groq->evaluarSintomas(array_merge($data, ['edad' => $edad]));

        $evaluacion = EvaluacionIAEloquentModel::create([
            'id' => Str::uuid()->toString(),
            'paciente_id' => $data['paciente_id'],
            'edad' => $edad,
            'genero' => $data['genero'] ?? null,
            'sintomas_principales' => $data['sintomas_principales'],
            'duracion_sintomas' => $data['duracion_sintomas'] ?? null,
            'nivel_dolor' => $data['nivel_dolor'] ?? null,
            'fiebre' => $data['fiebre'],
            'dificultad_respirar' => $data['dificultad_respirar'],
            'dolor_pecho' => $data['dolor_pecho'],
            'antecedentes' => $data['antecedentes'] ?? null,
            'urgencia_percibida' => $data['urgencia_percibida'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'especialidad_sugerida' => $resultadoIA['especialidad_sugerida'],
            'prioridad' => $resultadoIA['prioridad'],
            'motivo' => $resultadoIA['motivo'],
            'advertencia' => $resultadoIA['advertencia'],
            'respuesta_raw' => $resultadoIA['respuesta_raw'],
            'modo_simulado' => $groq->isSimulated(),
            'estado' => 'generada',
        ]);

        $evaluacion->load('paciente.user');

        return redirect()->route('evaluaciones-ia.show', $evaluacion->id)
            ->with('success', 'Evaluación completada exitosamente');
    }

    public function show(string $id): Response
    {
        $evaluacion = EvaluacionIAEloquentModel::with('paciente.user')->findOrFail($id);
        return Inertia::render('EvaluacionIA/show', ['evaluacion' => $evaluacion]);
    }
}
