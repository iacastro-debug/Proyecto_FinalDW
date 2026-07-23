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
          { accessorKey: 'medico.user.name', header: 'Médico' },
          { accessorKey: 'diagnostico', header: 'Diagnóstico' },
          { accessorKey: 'fecha_atencion', header: 'Fecha' },
          { accessorKey: 'created_at', header: 'Registrado' },
        ]">
          <template #cell-acciones="{ row }">
            <div class="flex gap-1">
              <UButton color="info" variant="ghost" icon="i-lucide-eye" :to="route('historiales-clinicos.show', row.original.id)" />
              <UButton color="warning" variant="ghost" icon="i-lucide-pencil" :to="route('historiales-clinicos.edit', row.original.id)" />
            </div>
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
