<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ horarios: any[] }>()

const eliminar = (id: string) => {
  if (confirm('¿Eliminar este horario?')) router.delete(route('horarios.destroy', id))
}

const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']
const getDia = (dia: number) => diasSemana[dia - 1] || dia
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Horarios">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nuevo" color="primary" icon="i-lucide-plus" :to="route('horarios.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="horarios" :columns="[
          { accessorKey: 'medico.user.name', header: 'Médico' },
          { accessorKey: 'dia', header: 'Día', cell: ({ row }: any) => getDia(row.original.dia) },
          { accessorKey: 'hora_inicio', header: 'Inicio' },
          { accessorKey: 'hora_fin', header: 'Fin' },
          { accessorKey: 'intervalo_minutos', header: 'Intervalo' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('horarios.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
