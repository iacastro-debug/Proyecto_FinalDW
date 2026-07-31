<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ historiales: any[] }>()

const role = computed(() => (usePage().props.auth?.user?.role as string) ?? '')
const canCreate = computed(() => role.value === 'admin' || role.value === 'medico')
const canEdit = computed(() => role.value === 'admin' || role.value === 'medico')

const columns = computed(() => {
  const cols = [
    { accessorKey: 'paciente.user.name', header: 'Paciente' },
    { accessorKey: 'medico.user.name', header: 'Médico' },
    { accessorKey: 'diagnostico', header: 'Diagnóstico' },
    { accessorKey: 'fecha_atencion', header: 'Fecha' },
    { accessorKey: 'created_at', header: 'Registrado' },
  ]
  cols.push({ accessorKey: 'acciones', header: 'Acciones' })
  return cols
})
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Historial Clínico">
        <template #leading><UDashboardSidebarCollapse /></template>
        <template #right>
          <UButton v-if="canCreate" label="Nuevo Informe" color="primary" icon="i-lucide-plus" :to="route('historiales-clinicos.create')" />
        </template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <UTable :data="historiales" :columns="columns">
          <template #cell-acciones="{ row }">
            <div class="flex gap-1">
              <UButton color="info" variant="ghost" icon="i-lucide-eye" :to="route('historiales-clinicos.show', row.original.id)" />
              <UButton v-if="canEdit" color="warning" variant="ghost" icon="i-lucide-pencil" :to="route('historiales-clinicos.edit', row.original.id)" />
            </div>
          </template>
        </UTable>
      </div>
    </template>
  </UDashboardPanel>
</template>
