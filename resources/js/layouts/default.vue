<script setup lang="ts">
import { computed, ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const page = usePage()
const open = ref(true)

// Datos del usuario logueado
const user = computed(() => page.props.auth?.user || {})

// Normalizamos el rol del usuario a minúsculas
const userRole = computed(() => {
  const role = user.value?.role || ''
  return String(role)
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .trim()
})

// Función para cerrar sesión
const logout = () => {
  router.post('/logout')
}

// 1. Enlaces para Administrador
const adminLinks = [
  { label: 'Dashboard', icon: 'i-lucide-home', to: '/dashboard' },
  { label: 'Usuarios y Roles', icon: 'i-lucide-users', to: '/admin/usuarios' },
  { label: 'Especialidades', icon: 'i-lucide-briefcase', to: '/specialties' },
  { label: 'Médicos', icon: 'i-lucide-stethoscope', to: '/doctors' },
  { label: 'Horarios', icon: 'i-lucide-calendar', to: '/schedules' },
  { label: 'Reportes', icon: 'i-lucide-bar-chart-3', to: '/reports' },
]

// 2. Enlaces para Recepcionista
const recepcionistaLinks = [
  { label: 'Dashboard', icon: 'i-lucide-home', to: '/dashboard' },
  { label: 'Registra pacientes', icon: 'i-lucide-user-plus', to: '/patients' },
  { label: 'Agenda citas', icon: 'i-lucide-calendar', to: '/appointments' },
  { label: 'Reprograma citas', icon: 'i-lucide-calendar-range', to: '/appointments/reschedule' },
  { label: 'Consulta disponibilidad de médicos', icon: 'i-lucide-clock', to: '/doctors/availability' },
  { label: 'Confirma asistencia', icon: 'i-lucide-check-circle', to: '/attendance' },
]

// 3. Enlaces para Médico
const medicoLinks = [
  { label: 'Dashboard', icon: 'i-lucide-home', to: '/dashboard' },
  { label: 'Consulta citas asignadas', icon: 'i-lucide-calendar-check', to: '/doctor/appointments' },
  { label: 'Revisa síntomas ingresados', icon: 'i-lucide-brain', to: '/doctor/symptoms' },
  { label: 'Registra historial clínico', icon: 'i-lucide-file-text', to: '/doctor/medical-history' },
  { label: 'Marca citas como atendidas', icon: 'i-lucide-check-square', to: '/doctor/appointments/complete' },
  { label: 'Consulta historial de sus pacientes atendidos', icon: 'i-lucide-users', to: '/doctor/patients' },
]

// 4. Enlaces para Paciente
const pacienteLinks = [
  { label: 'Dashboard', icon: 'i-lucide-home', to: '/dashboard' },
  { label: 'Registra o actualiza sus datos', icon: 'i-lucide-user', to: '/patient/profile' },
  { label: 'Ingresa síntomas en el módulo IA', icon: 'i-lucide-bot', to: '/patient/ai-symptoms' },
  { label: 'Agenda citas', icon: 'i-lucide-calendar-plus', to: '/patient/book' },
  { label: 'Consulta citas propias', icon: 'i-lucide-calendar', to: '/patient/my-appointments' },
  { label: 'Consulta historial autorizado', icon: 'i-lucide-folder-heart', to: '/patient/history' },
  { label: 'Cancela o reprograma citas', icon: 'i-lucide-calendar-x', to: '/patient/appointments/manage' },
]

// Selección dinámica del menú
const links = computed(() => {
  const role = userRole.value

  if (role === 'recepcionista' || role === 'recep') {
    return recepcionistaLinks
  }
  if (role === 'medico' || role === 'doctor') {
    return medicoLinks
  }
  if (role === 'paciente') {
    return pacienteLinks
  }
  return adminLinks
})
</script>

<template>
  <UApp>
    <UDashboardGroup unit="rem">
      <UDashboardSidebar
        id="default"
        v-model:open="open"
        collapsible
        resizable
        class="bg-elevated/25"
        :ui="{ footer: 'lg:border-t lg:border-default' }"
      >
        <template #header="{ collapsed }">
          <div class="flex items-center gap-3 px-3 py-2">
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 shadow-sm">
              <UIcon name="i-lucide-hospital" class="w-5 h-5 text-white" />
            </div>
            <div v-if="!collapsed" class="flex flex-col">
              <span class="font-bold text-slate-800 text-sm leading-none">MEDICITA</span>
              <span class="text-[10px] text-emerald-600 font-semibold tracking-wider mt-0.5">SISTEMA MÉDICO</span>
            </div>
          </div>
        </template>

        <template #default="{ collapsed }">
          <UNavigationMenu
            :collapsed="collapsed"
            :items="links"
            orientation="vertical"
            tooltip
            popover
          />
        </template>

        <template #footer="{ collapsed }">
          <div class="flex items-center justify-between gap-2 p-2 w-full overflow-hidden">
            <div class="flex items-center gap-2 min-w-0">
              <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                {{ user?.name ? user.name.charAt(0).toUpperCase() : 'U' }}
              </div>
              <div v-if="!collapsed" class="flex flex-col truncate">
                <span class="text-xs font-semibold text-slate-700 truncate">{{ user?.name || 'Usuario' }}</span>
                <span class="text-[10px] text-slate-500 capitalize">{{ user?.role || 'Rol' }}</span>
              </div>
            </div>

            <!-- Botón de Cerrar Sesión -->
            <button
              v-if="!collapsed"
              @click="logout"
              type="button"
              title="Cerrar sesión"
              class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors shrink-0"
            >
              <UIcon name="i-lucide-log-out" class="w-4 h-4" />
            </button>
          </div>
        </template>
      </UDashboardSidebar>

      <UDashboardSearch grow />
      <main class="flex-1 overflow-y-auto h-full p-6">
        <slot />
      </main>
    </UDashboardGroup>
  </UApp>
</template>