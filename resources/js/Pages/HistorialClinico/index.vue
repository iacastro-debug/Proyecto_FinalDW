<script setup lang="ts">
import { route } from 'ziggy-js'
defineProps<{ historiales: any[] }>()
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Historial Clínico">
        <template #leading><UDashboardSidebarCollapse /></template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="historiales" :columns="[
          { accessorKey: 'paciente.user.name', header: 'Paciente' },
          { accessorKey: 'tipo_registro', header: 'Tipo' },
          { accessorKey: 'fecha_registro', header: 'Fecha' },
          { accessorKey: 'diagnostico', header: 'Diagnóstico' },
          { accessorKey: 'created_at', header: 'Creado' },
        ]">
          <template #cell-acciones="{ row }">
            <UButton color="info" variant="ghost" icon="i-lucide-eye" :to="route('historiales-clinicos.show', row.original.id)" />
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
