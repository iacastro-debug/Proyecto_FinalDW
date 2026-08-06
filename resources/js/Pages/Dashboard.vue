<script setup lang="ts">
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '../Layouts/AuthenticatedLayout.vue'
import AdminDashboard from './Dashboards/AdminDashboard.vue'
import RecepcionistaDashboard from './Dashboards/RecepcionistaDashboard.vue'
import MedicoDashboard from './Dashboards/MedicoDashboard.vue'
import PacienteDashboard from './Dashboards/PacienteDashboard.vue'

const page = usePage()

const userRole = computed(() => {
  const user = page.props.auth?.user as any
  if (!user) return ''

  // 1. Si el rol viene como string directo: user.role = 'medico'
  if (typeof user.role === 'string') {
    return user.role.toLowerCase().trim()
  }

  // 2. Si el rol viene como objeto: user.role = { name: 'medico' } o { nombre: 'medico' }
  if (typeof user.role === 'object' && user.role !== null) {
    return (user.role.name || user.role.nombre || '').toLowerCase().trim()
  }

  // 3. Si usas Spatie / Roles como array: user.roles = [{ name: 'medico' }]
  if (Array.isArray(user.roles) && user.roles.length > 0) {
    return (user.roles[0].name || user.roles[0].nombre || '').toLowerCase().trim()
  }

  return ''
})
</script>

<template>
  <AuthenticatedLayout>
    <RecepcionistaDashboard v-if="['recepcionista', 'recep'].includes(userRole)" />
    <MedicoDashboard v-else-if="['medico', 'doctor'].includes(userRole)" />
    <PacienteDashboard v-else-if="userRole === 'paciente'" />
    <AdminDashboard v-else-if="['admin', 'administrador'].includes(userRole)" />
    
    <!-- Vista de respaldo en caso de que el rol no coincida con ninguno -->
    <div v-else class="p-6 bg-white rounded-xl shadow-sm text-center">
      <h2 class="text-xl font-bold text-gray-800">Rol no reconocido ({{ userRole || 'Sin Rol' }})</h2>
      <p class="text-gray-500 mt-2">Por favor contacta al administrador del sistema.</p>
    </div>
  </AuthenticatedLayout>
</template>