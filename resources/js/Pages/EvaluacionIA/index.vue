<script setup lang="ts">
import { route } from 'ziggy-js'

defineProps<{ evaluaciones: any[] }>()

const prioridadColor = (p: string) => {
  const colors: Record<string, string> = { alta: 'error', media: 'warning', baja: 'success' }
  return colors[p] || 'neutral'
}
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Evaluaciones IA">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nueva Evaluación" color="primary" icon="i-lucide-plus" :to="route('evaluaciones-ia.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="evaluaciones" :columns="[
          { accessorKey: 'paciente.user.name', header: 'Paciente' },
          { accessorKey: 'sintomas_principales', header: 'Síntomas' },
          { accessorKey: 'prioridad', header: 'Prioridad' },
          { accessorKey: 'especialidad_sugerida', header: 'Especialidad Sugerida' },
          { accessorKey: 'estado', header: 'Estado' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-eye" :to="route('evaluaciones-ia.show', row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
