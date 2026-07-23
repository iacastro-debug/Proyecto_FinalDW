<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{ horario: any, medicos: any[] }>()
const form = reactive({
  medico_id: props.horario.medico_id, dia: props.horario.dia,
  hora_inicio: props.horario.hora_inicio, hora_fin: props.horario.hora_fin,
  intervalo_minutos: props.horario.intervalo_minutos, activo: props.horario.activo
})
const loading = ref(false)
const submit = () => { loading.value = true; router.put(route('horarios.update', props.horario.id), form, { onFinish: () => loading.value = false }) }

const dias = [
  { label: 'Lunes', value: 1 }, { label: 'Martes', value: 2 }, { label: 'Miércoles', value: 3 },
  { label: 'Jueves', value: 4 }, { label: 'Viernes', value: 5 }, { label: 'Sábado', value: 6 }, { label: 'Domingo', value: 7 },
]
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Editar Horario"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Configuración del horario</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Médico" required>
                <USelect v-model="form.medico_id" :items="medicos.map((m: any) => ({ label: m.user.name, value: m.id }))" placeholder="Seleccionar médico..." />
                <p class="text-sm text-gray-500 mt-1">Selecciona el médico para este horario</p>
              </UFormGroup>
              <UFormGroup label="Día de la semana" required>
                <p class="text-sm text-gray-500 mb-1">Día en que aplica este horario</p>`n                <USelect v-model="form.dia" :items="dias" />
              </UFormGroup>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Hora de inicio" required>
                  <p class="text-sm text-gray-500 mb-1">Ej: 08:00 (formato 24h)</p>`n                <UInput v-model="form.hora_inicio" type="time" />
                </UFormGroup>
                <UFormGroup label="Hora de fin" required>
                  <p class="text-sm text-gray-500 mb-1">Ej: 17:00 (formato 24h)</p>`n                <UInput v-model="form.hora_fin" type="time" />
                </UFormGroup>
              </div>
              <UFormGroup label="Intervalo entre citas (minutos)">
                <p class="text-sm text-gray-500 mb-1">Duración de cada espacio de atención</p>`n                <UInput v-model="form.intervalo_minutos" type="number" min="5" max="120" placeholder="Ej: 30" />
              </UFormGroup>
              <UFormGroup label="Estado">
                <UCheckbox v-model="form.activo" label="Horario activo" />
                <p class="text-sm text-gray-500 mt-1">Desactiva temporalmente este horario si es necesario</p>
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('horarios.index')" />
            <UButton type="submit" color="primary" label="Actualizar horario" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
