<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ medicos: any[] }>()

const eliminar = (id: string) => {
  if (confirm('¿Eliminar?')) router.delete(route('medicos.destroy', id))
}
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
        <!-- Grid de Tarjetas -->
        <div v-if="medicos && medicos.length > 0" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          
          <UCard 
            v-for="medico in medicos" 
            :key="medico.id" 
            class="shadow-sm border border-gray-100 hover:border-emerald-100 transition duration-300"
          >
            <div class="space-y-4">
              <!-- Encabezado con Nombre y Estado -->
              <div class="flex justify-between items-start">
                <div>
                  <h3 class="text-lg font-bold text-gray-900">
                    {{ medico.user?.name || medico.nombre }}
                  </h3>
                  <p class="text-emerald-700 font-medium text-sm">
                    {{ medico.especialidad?.nombre || medico.especialidad }}
                  </p>
                </div>
                <UBadge 
                  :color="medico.estado === 'activo' ? 'success' : 'error'" 
                  variant="subtle"
                  size="xs"
                  class="capitalize"
                >
                  {{ medico.estado || 'activo' }}
                </UBadge>
              </div>

              <!-- Contacto e Info -->
              <div class="space-y-2.5 text-sm text-gray-600">
                <div class="flex items-center gap-2.5">
                  <UIcon name="i-lucide-mail" class="w-4 h-4 text-gray-400" />
                  <span>{{ medico.user?.email || medico.email }}</span>
                </div>
                <div class="flex items-center gap-2.5">
                  <UIcon name="i-lucide-phone" class="w-4 h-4 text-gray-400" />
                  <span>{{ medico.telefono }}</span>
                </div>
                <div class="flex items-center gap-2.5">
                  <UIcon name="i-lucide-file-signature" class="w-4 h-4 text-gray-400" />
                  <span>N° Reg: <strong>{{ medico.numero_registro || 'N/A' }}</strong></span>
                </div>
              </div>
            </div>

            <!-- Botones de Acción usando tus rutas Ziggy -->
            <template #footer>
              <div class="flex justify-end gap-2 -m-2">
                <UButton 
                  color="info" 
                  variant="ghost" 
                  icon="i-lucide-pencil" 
                  size="sm"
                  :to="route('medicos.edit', medico.id)" 
                  label="Editar"
                />
                <UButton 
                  color="error" 
                  variant="ghost" 
                  icon="i-lucide-trash" 
                  size="sm"
                  @click="eliminar(medico.id)" 
                  label="Eliminar"
                />
              </div>
            </template>
          </UCard>
        </div>

        <!-- Vista cuando no hay médicos -->
        <div v-else class="flex justify-center items-center h-96 text-center text-gray-400 bg-white rounded-xl border border-gray-100">
          <div class="space-y-3">
            <UIcon name="i-lucide-users" class="w-16 h-16 mx-auto text-gray-300" />
            <p>No hay médicos registrados aún.</p>
          </div>
        </div>

      </div>
    </template>
  </UDashboardPanel>
</template>