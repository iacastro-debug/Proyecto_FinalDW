<script setup lang="ts">
import { route } from 'ziggy-js'
defineProps<{ evaluacion: any }>()
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Evaluación IA"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-4 max-w-2xl">
        <UCard>
          <template #header>
            <div class="flex justify-between items-center">
              <h3 class="text-lg font-semibold">Evaluación de {{ evaluacion.paciente?.user?.name }}</h3>
              <UBadge :color="evaluacion.prioridad === 'alta' ? 'error' : evaluacion.prioridad === 'media' ? 'warning' : 'success'">{{ evaluacion.prioridad?.toUpperCase() }}</UBadge>
            </div>
          </template>
          <div class="space-y-4">
            <div><strong>Síntomas:</strong> {{ evaluacion.sintomas_principales }}</div>
            <div><strong>Duración:</strong> {{ evaluacion.duracion_sintomas || 'No especificado' }}</div>
            <div><strong>Nivel Dolor:</strong> {{ evaluacion.nivel_dolor ?? 'N/A' }}/10</div>
            <div><strong>Severidad:</strong>
              <UBadge v-if="evaluacion.fiebre" color="warning">Fiebre</UBadge>
              <UBadge v-if="evaluacion.dificultad_respirar" color="error">Dificultad Respirar</UBadge>
              <UBadge v-if="evaluacion.dolor_pecho" color="error">Dolor Pecho</UBadge>
              <UBadge v-if="!evaluacion.fiebre && !evaluacion.dificultad_respirar && !evaluacion.dolor_pecho" color="neutral">Sin signos de alarma</UBadge>
            </div>
            <div><strong>Antecedentes:</strong> {{ evaluacion.antecedentes || 'No especificado' }}</div>
            <UDivider />
            <div><strong>Especialidad Sugerida:</strong> {{ evaluacion.especialidad_sugerida || 'No determinada' }}</div>
            <div><strong>Motivo:</strong> {{ evaluacion.motivo || 'Sin motivo específico' }}</div>
            <div v-if="evaluacion.advertencia" class="bg-red-50 border border-red-200 rounded p-3 text-red-700">{{ evaluacion.advertencia }}</div>
            <div v-if="evaluacion.modo_simulado" class="bg-yellow-50 border border-yellow-200 rounded p-3 text-yellow-700 text-sm">
              * Evaluación generada en modo simulado (sin conexión a Groq)
            </div>
          </div>
          <template #footer>
            <UButton label="Volver" variant="subtle" :to="route('evaluaciones-ia.index')" />
          </template>
        </UCard>
      </div>
    </template>
  </UDashboardPanel>
</template>
