<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ pacientes: any[], medicos: any[], especialidades: any[] }>()

const form = reactive({
  paciente_id: '', medico_id: '', especialidad_id: '',
  fecha_cita: '', hora_cita: '', estado: 'pendiente',
  motivo_consulta: '', observaciones: ''
})
const loading = ref(false)
const submit = () => { loading.value = true; router.post(route('citas.store'), form, { onFinish: () => loading.value = false }) }
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nueva Cita"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Datos de la cita</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Paciente" required>
                <p class="text-sm text-gray-500 mb-1">Busca y selecciona el paciente que será atendido</p>
                <USelect v-model="form.paciente_id" :items="pacientes.map((p: any) => ({ label: `${p.user.name} - ${p.numero_documento}`, value: p.id }))" placeholder="Seleccionar paciente..." />
              </UFormGroup>
              <UFormGroup label="Especialidad" required>
                <p class="text-sm text-gray-500 mb-1">Selecciona la especialidad para la consulta</p>
                <USelect v-model="form.especialidad_id" :items="especialidades.map((e: any) => ({ label: e.nombre, value: e.id }))" placeholder="Seleccionar especialidad..." />
              </UFormGroup>
              <UFormGroup label="Médico" required>
                <p class="text-sm text-gray-500 mb-1">Selecciona el médico que atenderá la cita</p>
                <USelect v-model="form.medico_id" :items="medicos.map((m: any) => ({ label: `${m.user.name} - ${m.especialidad?.nombre || ''}`, value: m.id }))" placeholder="Seleccionar médico..." />
              </UFormGroup>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Fecha de la cita" required>
                  <p class="text-sm text-gray-500 mb-1">Selecciona el día de atención</p>
                  <UInput v-model="form.fecha_cita" type="date" />
                </UFormGroup>
                <UFormGroup label="Hora de la cita" required>
                  <p class="text-sm text-gray-500 mb-1">Selecciona la hora de atención (formato 24h)</p>
                  <UInput v-model="form.hora_cita" type="time" />
                </UFormGroup>
              </div>
              <UFormGroup label="Estado inicial">
                <p class="text-sm text-gray-500 mb-1">La cita se crea como 'pendiente' por defecto</p>
                <USelect v-model="form.estado" :items="[
                  { label: 'Pendiente', value: 'pendiente' },
                  { label: 'Confirmada', value: 'confirmada' },
                ]" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Detalles de la consulta</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Motivo de la consulta" required>
                <p class="text-sm text-gray-500 mb-1">Describe brevemente el motivo por el que el paciente solicita la cita</p>
                <UTextarea v-model="form.motivo_consulta" placeholder="Ej: Control de presión arterial, dolor de cabeza persistente, revisión general..." :rows="3" />
              </UFormGroup>
              <UFormGroup label="Observaciones">
                <p class="text-sm text-gray-500 mb-1">Información adicional relevante para la atención</p>
                <UTextarea v-model="form.observaciones" placeholder="Ej: Paciente requiere atención preferencial, traer resultados de exámenes anteriores..." :rows="2" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('citas.index')" />
            <UButton type="submit" color="primary" label="Guardar cita" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
