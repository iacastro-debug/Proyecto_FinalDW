<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
defineProps<{ especialidades: any[] }>()
const eliminar = (id: string) => { if (confirm('¿Eliminar?')) router.delete(route('especialidades.destroy', id)) }
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Especialidades Médicas">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nueva" color="primary" icon="i-lucide-plus" :to="route('especialidades.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="especialidades" :columns="[
          { accessorKey: 'nombre', header: 'Nombre' },
          { accessorKey: 'descripcion', header: 'Descripción' },
          { accessorKey: 'activo', header: 'Activo', cell: ({ row }: any) => row.original.activo ? 'Sí' : 'No' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('especialidades.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
