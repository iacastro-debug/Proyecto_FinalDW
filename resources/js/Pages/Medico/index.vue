<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
defineProps<{ medicos: any[] }>()
const eliminar = (id: string) => { if (confirm('¿Eliminar?')) router.delete(route('medicos.destroy', id)) }
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Médicos">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton label="Nuevo" color="primary" icon="i-lucide-plus" :to="route('medicos.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="medicos" :columns="[
          { accessorKey: 'user.name', header: 'Nombre' },
          { accessorKey: 'user.email', header: 'Email' },
          { accessorKey: 'especialidad.nombre', header: 'Especialidad' },
          { accessorKey: 'telefono', header: 'Teléfono' },
          { accessorKey: 'numero_registro', header: 'N° Registro' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-pencil" :to="route('medicos.edit', row.original.id)" />
            <UButton color="error" variant="ghost" icon="i-lucide-trash" @click="eliminar(row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
