<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ citas: any[] }>()

const eliminar = (id: string) => {
  if (confirm('¿Eliminar esta cita?')) router.delete(route('citas.destroy', id))
}

const estadoColor = (estado: string) => {
  const colors: Record<string, string> = { pendiente: 'warning', confirmada: 'info', completada: 'success', cancelada: 'error' }
  return colors[estado] || 'neutral'
}
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Citas">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nueva" color="primary" icon="i-lucide-plus" :to="route('citas.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="citas" :columns="[
          { accessorKey: 'paciente.user.name', header: 'Paciente' },
          { accessorKey: 'medico.user.name', header: 'Médico' },
          { accessorKey: 'especialidad.nombre', header: 'Especialidad' },
          { accessorKey: 'fecha_cita', header: 'Fecha' },
          { accessorKey: 'hora_cita', header: 'Hora' },
          { accessorKey: 'estado', header: 'Estado' },
          { accessorKey: 'motivo_consulta', header: 'Motivo' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('citas.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
