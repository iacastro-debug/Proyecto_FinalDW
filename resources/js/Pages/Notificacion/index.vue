<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
defineProps<{ notificaciones: any[] }>()
const marcarLeida = (id: string) => router.post(route('notificaciones.markAsRead', id))
</script>
<template>
  <UDashboardPanel>
    <template #header>
      <UDashboardNavbar title="Notificaciones">
        <template #leading><UDashboardSidebarCollapse /></template>
      </UDashboardNavbar>
    </template>
    <template #body>
      <div class="p-4">
        <div v-if="notificaciones.length === 0" class="text-center text-gray-500 py-8">No hay notificaciones</div>
        <div v-else class="space-y-2">
          <div v-for="n in notificaciones" :key="n.id" class="flex items-center justify-between p-3 border rounded" :class="n.leido ? 'bg-white' : 'bg-primary-50 border-primary-200'">
            <div>
              <p class="font-medium" :class="!n.leido && 'text-primary-700'">{{ n.titulo }}</p>
              <p class="text-sm text-gray-600">{{ n.mensaje }}</p>
              <p class="text-xs text-gray-400 mt-1">{{ n.created_at }}</p>
            </div>
            <div class="flex gap-2">
              <UBadge v-if="!n.leido" color="primary">Nueva</UBadge>
              <UButton v-if="!n.leido" color="info" variant="ghost" icon="i-lucide-check" size="sm" @click="marcarLeida(n.id)" />
            </div>
          </div>
        </div>
      </div>
    </template>
  </UDashboardPanel>
</template>
