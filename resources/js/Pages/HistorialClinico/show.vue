<script setup lang="ts">
import { route } from 'ziggy-js'
defineProps<{ historial: any }>()
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Detalle Historial Clínico"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-3xl mx-auto space-y-6">
        <UCard>
          <template #header><h3 class="text-lg font-semibold">Paciente: {{ historial.paciente?.user?.name }}</h3></template>
          <div class="space-y-3">
            <div><strong>Médico:</strong> {{ historial.medico?.user?.name }}</div>
            <div><strong>Fecha de atención:</strong> {{ historial.fecha_atencion }}</div>
            <div><strong>Motivo de consulta:</strong> {{ historial.motivo_consulta }}</div>
            <div><strong>Diagnóstico:</strong> {{ historial.diagnostico }}</div>
            <div v-if="historial.observaciones_medicas"><strong>Observaciones:</strong> {{ historial.observaciones_medicas }}</div>
            <div v-if="historial.indicaciones"><strong>Indicaciones:</strong> {{ historial.indicaciones }}</div>
          </div>
        </UCard>

        <UCard v-if="historial.medicamentos?.length">
          <template #header><h3 class="text-lg font-semibold">Medicamentos recetados</h3></template>
          <div class="space-y-3">
            <div v-for="(med, i) in historial.medicamentos" :key="i" class="border rounded-lg p-3">
              <p class="font-medium">{{ med.nombre }}</p>
              <div class="grid grid-cols-3 gap-2 mt-1 text-sm text-gray-600">
                <span v-if="med.dosis"><strong>Dosis:</strong> {{ med.dosis }}</span>
                <span v-if="med.frecuencia"><strong>Frecuencia:</strong> {{ med.frecuencia }}</span>
                <span v-if="med.duracion"><strong>Duración:</strong> {{ med.duracion }}</span>
              </div>
            </div>
          </div>
        </UCard>

        <div class="flex gap-3">
          <UButton label="Volver" variant="subtle" :to="route('historiales-clinicos.index')" />
          <UButton color="warning" variant="outline" label="Editar" icon="i-lucide-pencil" :to="route('historiales-clinicos.edit', historial.id)" />
        </div>
      </div>
    </template>
  </UDashboardPanel>
</template>
