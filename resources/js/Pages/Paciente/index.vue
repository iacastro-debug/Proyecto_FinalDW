<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
defineProps<{ pacientes: any[] }>()
const eliminar = (id: string) => { if (confirm('¿Eliminar?')) router.delete(route('pacientes.destroy', id)) }
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Pacientes">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nuevo" color="primary" icon="i-lucide-plus" :to="route('pacientes.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="pacientes" :columns="[
          { accessorKey: 'nombres', header: 'Nombre' },
          { accessorKey: 'email', header: 'Email' },
          { accessorKey: 'tipo_documento', header: 'Tipo Doc.' },
          { accessorKey: 'numero_documento', header: 'N° Documento' },
          { accessorKey: 'telefono', header: 'Teléfono' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('pacientes.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
