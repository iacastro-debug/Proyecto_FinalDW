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
          <TeamsMenu :collapsed="collapsed" />
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

      <UDashboardSearch :groups="groups" />

      <slot />

    </UDashboardGroup>
  </UApp>
</template>
