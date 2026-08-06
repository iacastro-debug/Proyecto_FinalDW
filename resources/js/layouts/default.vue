<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import type { NavigationMenuItem } from '@nuxt/ui'
import TeamsMenu from '../components/TeamsMenu.vue'
import UserMenu from '../components/UserMenu.vue'
import { useAppConfig } from '../composables/useAppConfig'
import { useFlash } from '../composables/useFlash'

const open = ref(false)
const appConfig = useAppConfig()

onMounted(() => {
  console.log('Layout mounted with colors:', appConfig.value.ui.colors)
  // Initialize flash messages
  useFlash()
})

const navigateTo = (url: string) => {
  router.visit(url)
  open.value = false
}

const role = computed(() => (usePage().props.auth?.user?.role as string) ?? '')

const navLink = (label: string, icon: string, to: string): NavigationMenuItem => ({
  label, icon, to,
  onSelect: () => navigateTo(to)
})

const allLinks: NavigationMenuItem[] = [
  navLink('Dashboard', 'i-lucide-house', '/dashboard'),
  navLink('Pacientes', 'i-lucide-users-round', '/pacientes'),
  navLink('Médicos', 'i-lucide-stethoscope', '/medicos'),
  navLink('Especialidades', 'i-lucide-clipboard-list', '/especialidades'),
  navLink('Horarios', 'i-lucide-calendar-clock', '/horarios'),
  navLink('Citas', 'i-lucide-calendar-check', '/citas'),
  navLink('Evaluación IA', 'i-lucide-brain', '/evaluaciones-ia'),
  navLink('Historial Clínico', 'i-lucide-file-text', '/historiales-clinicos'),
  navLink('Notificaciones', 'i-lucide-bell', '/notificaciones')
]

const medicoLinks = allLinks.filter(l => [
  '/dashboard', '/citas', '/horarios', '/evaluaciones-ia', '/historiales-clinicos'
].includes(l.to))

const pacienteLinks = allLinks.filter(l => [
  '/dashboard', '/citas', '/historiales-clinicos'
].includes(l.to))

const links = computed<NavigationMenuItem[][]>(() => {
  if (role.value === 'medico') return [medicoLinks]
  if (role.value === 'paciente') return [pacienteLinks]
  return [allLinks]
})

const groups = computed(() => [{
  id: 'links',
  label: 'Go to',
  items: links.value.flat()
}])
</script>

<template>
  <UApp :primary="appConfig.ui.colors.primary" :neutral="appConfig.ui.colors.neutral">
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
          <!-- Icono médico -->
            <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-base shrink-0 shadow-sm">
      <UIcon name="i-lucide-hospital" class="w-5 h-5 text-white" />
      </div>

    <!-- Nombre del sistema -->
    <div v-if="!collapsed" class="flex flex-col">
      <span class="font-bold text-slate-800 text-sm leading-none">MEDICITA</span>
      <span class="text-[10px] text-emerald-600 font-semibold tracking-wider mt-0.5">SISTEMA MÉDICO</span>
    </div>
  </div>
</template>

        <template #default="{ collapsed }">
          <UNavigationMenu
            :collapsed="collapsed"
            :items="links[0]"
            orientation="vertical"
            tooltip
            popover
          />
        </template>

        <template #footer="{ collapsed }">
          <UserMenu :collapsed="collapsed" />
        </template>
      </UDashboardSidebar>

      <UDashboardSearch grow />
        <main class="flex-1 overflow-y-auto h-full p-6">

      <slot />
    </main>

    </UDashboardGroup>
  </UApp>
</template>
