<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $model;
    protected bool $useSimulatedMode;

    public function __construct()
    {
        $this->apiKey = config('groq.api_key');
        $this->apiUrl = config('groq.api_url');
        $this->model = config('groq.model');
        $this->useSimulatedMode = empty($this->apiKey) || app()->environment('local');
    }

    public function isSimulated(): bool
    {
        return $this->useSimulatedMode;
    }

    public function evaluarSintomas(array $data): array
    {
        if ($this->useSimulatedMode) {
            return $this->simularEvaluacion($data);
        }

        try {
            return $this->consultarGroq($data);
        } catch (\Exception $e) {
            Log::error('Error al consultar Groq API: ' . $e->getMessage());
            return $this->simularEvaluacion($data);
        }
    }

    protected function consultarGroq(array $data): array
    {
        $prompt = $this->construirPrompt($data);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/chat/completions', [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Eres un asistente de orientación médica. Tu única función es sugerir especialidades médicas basadas en síntomas. No diagnostiques enfermedades, no indiques tratamientos, no recomiendes medicamentos. Siempre incluye una advertencia de que esto no reemplaza la atención profesional.',
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
            'temperature' => 0.3,
            'max_tokens' => 500,
        ]);

        if ($response->failed()) {
            Log::error('Groq API error: ' . $response->body());
            return $this->simularEvaluacion($data);
        }

        $result = $response->json();
        $content = $result['choices'][0]['message']['content'] ?? '';

        return $this->parsearRespuestaGroq($content, $result);
    }

    protected function construirPrompt(array $data): string
    {
        $edad = $data['edad'] ?? 'No especificada';
        $sintomas = $data['sintomas_principales'] ?? '';
        $duracion = $data['duracion_sintomas'] ?? 'No especificada';
        $nivelDolor = $data['nivel_dolor'] ?? 'No especificado';
        $fiebre = isset($data['fiebre']) && $data['fiebre'] ? 'Sí' : 'No';
        $dificultadRespirar = isset($data['dificultad_respirar']) && $data['dificultad_respirar'] ? 'Sí' : 'No';
        $dolorPeche = isset($data['dolor_pecho']) && $data['dolor_pecho'] ? 'Sí' : 'No';
        $antecedentes = $data['antecedentes'] ?? 'Ninguno';
        $urgencia = $data['urgencia_percibida'] ?? 'No especificada';

        return "Analiza los siguientes síntomas y sugiere únicamente una especialidad médica para agendar una cita.
No emitas diagnóstico. No indiques tratamiento. No menciones medicamentos. Devuelve especialidad sugerida, prioridad, motivo y advertencia. Si hay señales críticas, sugiere atención de emergencia.

Datos del paciente:
Edad: {$edad} años
Síntomas: {$sintomas}
Duración: {$duracion}
Nivel de dolor: {$nivelDolor}
Fiebre: {$fiebre}
Dificultad para respirar: {$dificultadRespirar}
Dolor en el pecho: {$dolorPeche}
Antecedentes relevantes: {$antecedentes}
Urgencia percibida: {$urgencia}";
    }

    protected function parsearRespuestaGroq(string $content, array $rawResponse): array
    {
        $especialidad = 'Medicina General';
        $prioridad = 'Media';
        $motivo = 'Evaluación realizada por IA';
        $advertencia = 'Esta sugerencia no representa un diagnóstico médico ni reemplaza la atención de un profesional de salud.';

        if (preg_match('/Especialidad sugerida:\s*(.+)/i', $content, $matches)) {
            $especialidad = trim($matches[1]);
        } elseif (preg_match('/especialidad[:\s]+(.+)/i', $content, $matches)) {
            $especialidad = trim($matches[1]);
        }

        if (preg_match('/Prioridad:\s*(.+)/i', $content, $matches)) {
            $prioridad = trim($matches[1]);
        }

        if (preg_match('/Motivo:\s*(.+)/i', $content, $matches)) {
            $motivo = trim($matches[1]);
        }

        if (preg_match('/Advertencia:\s*(.+)/i', $content, $matches)) {
            $advertencia = trim($matches[1]);
        }

        $especialidad = $this->normalizarEspecialidad($especialidad);
        $prioridad = $this->normalizarPrioridad($prioridad);

        return [
            'especialidad_sugerida' => $especialidad,
            'prioridad' => $prioridad,
            'motivo' => $motivo,
            'advertencia' => $advertencia,
            'respuesta_raw' => json_encode($rawResponse),
        ];
    }

    protected function simularEvaluacion(array $data): array
    {
        $dolorPeche = isset($data['dolor_pecho']) && $data['dolor_pecho'];
        $dificultadRespirar = isset($data['dificultad_respirar']) && $data['dificultad_respirar'];
        $fiebre = isset($data['fiebre']) && $data['fiebre'];
        $nivelDolor = $data['nivel_dolor'] ?? 'bajo';
        $sintomas = strtolower($data['sintomas_principales'] ?? '');
        $edad = $data['edad'] ?? 0;
        $duracion = $data['duracion_sintomas'] ?? '';

        $advertencia = 'Esta sugerencia no representa un diagnóstico médico ni reemplaza la atención de un profesional de salud. Ante síntomas graves, acuda a emergencia o contacte a un profesional de salud.';

        if ($dolorPeche || $dificultadRespirar || $nivelDolor === 'alto') {
            return [
                'especialidad_sugerida' => 'Emergencia',
                'prioridad' => 'Alta',
                'motivo' => 'Los síntomas incluyen señales críticas que requieren atención inmediata.',
                'advertencia' => $advertencia,
                'respuesta_raw' => null,
            ];
        }

        if (str_contains($sintomas, 'piel') || str_contains($sintomas, 'erupcion') || str_contains($sintomas, 'mancha') || str_contains($sintomas, 'roncha')) {
            return [
                'especialidad_sugerida' => 'Dermatología',
                'prioridad' => 'Media',
                'motivo' => 'Los síntomas descritos están relacionados con la piel y pueden requerir evaluación dermatológica.',
                'advertencia' => $advertencia,
                'respuesta_raw' => null,
            ];
        }

        if ($edad < 15) {
            return [
                'especialidad_sugerida' => 'Pediatría',
                'prioridad' => 'Media',
                'motivo' => 'El paciente es menor de edad y requiere atención pediátrica.',
                'advertencia' => $advertencia,
                'respuesta_raw' => null,
            ];
        }

        if (str_contains($sintomas, 'hueso') || str_contains($sintomas, 'fractura') || str_contains($sintomas, 'articulacion') || str_contains($sintomas, 'esguince')) {
            return [
                'especialidad_sugerida' => 'Traumatología',
                'prioridad' => 'Media',
                'motivo' => 'Los síntomas describen lesiones del sistema musculoesquelético.',
                'advertencia' => $advertencia,
                'respuesta_raw' => null,
            ];
        }

        if ($fiebre || str_contains($sintomas, 'fiebre') || str_contains($sintomas, 'dolor') || str_contains($sintomas, 'malestar')) {
            return [
                'especialidad_sugerida' => 'Medicina General',
                'prioridad' => 'Media',
                'motivo' => 'Los síntomas descritos pueden requerir una valoración médica inicial.',
                'advertencia' => $advertencia,
                'respuesta_raw' => null,
            ];
        }

        return [
            'especialidad_sugerida' => 'Medicina General',
            'prioridad' => 'Baja',
            'motivo' => 'Se recomienda una evaluación médica general para determinar el tratamiento adecuado.',
            'advertencia' => $advertencia,
            'respuesta_raw' => null,
        ];
    }

    protected function normalizarEspecialidad(string $especialidad): string
    {
        $mapa = [
            'medicina general' => 'Medicina General',
            'medicina interna' => 'Medicina General',
            'pediatría' => 'Pediatría',
            'pediatria' => 'Pediatría',
            'ginecología' => 'Ginecología',
            'ginecologia' => 'Ginecología',
            'cardiología' => 'Cardiología',
            'cardiologia' => 'Cardiología',
            'dermatología' => 'Dermatología',
            'dermatologia' => 'Dermatología',
            'traumatología' => 'Traumatología',
            'traumatologia' => 'Traumatología',
            'odontología' => 'Odontología',
            'odontologia' => 'Odontología',
            'psicología' => 'Psicología',
            'psicologia' => 'Psicología',
            'emergencia' => 'Emergencia',
            'urgencia' => 'Emergencia',
        ];

        $key = strtolower(trim($especialidad));

        return $mapa[$key] ?? ucfirst($especialidad);
    }

    protected function normalizarPrioridad(string $prioridad): string
    {
        $prioridad = strtolower(trim($prioridad));

        if (in_array($prioridad, ['alta', 'media', 'baja'])) {
            return ucfirst($prioridad);
        }

        return 'Media';
    }
}
