<script setup lang="ts">
import { ref, computed } from 'vue'
import type { DropdownMenuItem } from '@nuxt/ui'

defineProps<{
  collapsed?: boolean
}>()

const teams = ref([{
  label: 'Nuxt',
  avatar: {
    src: 'https://github.com/nuxt.png',
    alt: 'Nuxt'
  }
}, {
  label: 'NuxtHub',
  avatar: {
    src: 'https://github.com/nuxt-hub.png',
    alt: 'NuxtHub'
  }
}, {
  label: 'NuxtLabs',
  avatar: {
    src: 'https://github.com/nuxtlabs.png',
    alt: 'NuxtLabs'
  }
}])
const selectedTeam = ref(teams.value[0])

const items = computed<DropdownMenuItem[][]>(() => {
  return [teams.value.map(team => ({
    ...team,
    onSelect() {
      selectedTeam.value = team
    }
  })), [{
    label: 'Create team',
    icon: 'i-lucide-circle-plus'
  }, {
    label: 'Manage teams',
    icon: 'i-lucide-cog'
  }]]
})
</script>

<template>
  <div class="flex items-center gap-2.5 px-2 py-1.5">
    <!-- Icono Médico -->
    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
      <UIcon name="i-lucide-hospital" class="w-5 h-5" />
    </div>

    <!-- Texto MEDICITA -->
    <div v-if="!collapsed" class="flex flex-col min-w-0">
      <span class="font-bold text-slate-800 text-sm leading-tight truncate">MEDICITA</span>
      <span class="text-[10px] text-emerald-600 font-medium tracking-wide">Sistema Médico</span>
    </div>
  </div>
</template>
