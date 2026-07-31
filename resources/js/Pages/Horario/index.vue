<script setup lang="ts">
import { computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ horarios: any[] }>()

const role = computed(() => (usePage().props.auth?.user?.role as string) ?? '')
const isAdmin = computed(() => role.value === 'admin')

const columns = computed(() => {
  const cols = [
    { accessorKey: 'medico.user.name', header: 'Médico' },
    { accessorKey: 'dia', header: 'Día', cell: ({ row }: any) => getDia(row.original.dia) },
    { accessorKey: 'hora_inicio', header: 'Inicio' },
    { accessorKey: 'hora_fin', header: 'Fin' },
    { accessorKey: 'intervalo_minutos', header: 'Intervalo' },
  ]
  if (isAdmin.value) cols.push({ accessorKey: 'acciones', header: 'Acciones' })
  return cols
})

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
          <UButton v-if="isAdmin" label="Nuevo" color="primary" icon="i-lucide-plus" :to="route('horarios.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="horarios" :columns="columns">
          <template v-if="isAdmin" #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('horarios.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
