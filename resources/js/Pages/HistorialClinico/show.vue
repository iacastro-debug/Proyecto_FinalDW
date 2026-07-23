<script setup lang="ts">
import { route } from 'ziggy-js'
defineProps<{ historial: any }>()
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Detalle Historial Clínico"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-4 max-w-2xl">
        <UCard>
          <template #header>
            <h3 class="text-lg font-semibold">Paciente: {{ historial.paciente?.user?.name }}</h3>
          </template>
          <div class="space-y-4">
            <div><strong>Tipo Registro:</strong> {{ historial.tipo_registro }}</div>
            <div><strong>Fecha:</strong> {{ historial.fecha_registro }}</div>
            <div v-if="historial.diagnostico"><strong>Diagnóstico:</strong> {{ historial.diagnostico }}</div>
            <div v-if="historial.tratamiento"><strong>Tratamiento:</strong> {{ historial.tratamiento }}</div>
            <div v-if="historial.notas"><strong>Notas:</strong> {{ historial.notas }}</div>
            <div><strong>Fecha de creación:</strong> {{ historial.created_at }}</div>
          </div>
          <template #footer>
            <UButton label="Volver" variant="subtle" :to="route('historiales-clinicos.index')" />
          </template>
        </UCard>
      </div>
    </template>
  </UDashboardPanel>
</template>
