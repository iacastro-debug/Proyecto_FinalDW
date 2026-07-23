<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{ medico: any, cita: any | null, pacientes: any[] }>()

const form = reactive({
  cita_id: props.cita?.id || '',
  paciente_id: props.cita?.paciente?.id || '',
  motivo_consulta: props.cita?.motivo_consulta || '',
  observaciones_medicas: '',
  diagnostico: '',
  medicamentos: [] as { nombre: string; dosis: string; frecuencia: string; duracion: string }[],
  indicaciones: '',
})
const loading = ref(false)

const addMedicamento = () => {
  form.medicamentos.push({ nombre: '', dosis: '', frecuencia: '', duracion: '' })
}
const removeMedicamento = (index: number) => {
  form.medicamentos.splice(index, 1)
}

const submit = () => {
  loading.value = true
  router.post(route('historiales-clinicos.store'), form, { onFinish: () => loading.value = false })
}
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nuevo Informe de Consulta"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-3xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Información de la consulta</h3></template>
            <div class="space-y-4">
              <div v-if="cita" class="bg-primary-50 border border-primary-200 rounded-lg p-4 text-sm text-primary-800">
                <p><strong>Paciente:</strong> {{ cita.paciente?.user?.name }}</p>
                <p><strong>Fecha:</strong> {{ cita.fecha_cita }} - {{ cita.hora_cita }}</p>
                <p><strong>Motivo:</strong> {{ cita.motivo_consulta }}</p>
              </div>

              <UFormGroup v-if="!cita" label="Paciente" required>
                <p class="text-sm text-gray-500 mb-1">Selecciona el paciente de la consulta</p>
                <USelect v-model="form.paciente_id" :items="pacientes.map((p: any) => ({ label: `${p.user.name} - ${p.numero_documento}`, value: p.id }))" placeholder="Seleccionar paciente..." />
              </UFormGroup>

              <UFormGroup label="Motivo de consulta" required>
                <p class="text-sm text-gray-500 mb-1">Motivo por el cual el paciente solicitó la consulta</p>
                <UTextarea v-model="form.motivo_consulta" placeholder="Ej: Dolor de cabeza persistente, revisión general..." :rows="2" />
              </UFormGroup>

              <UFormGroup label="Diagnóstico" required>
                <p class="text-sm text-gray-500 mb-1">Diagnóstico principal del médico</p>
                <UTextarea v-model="form.diagnostico" placeholder="Ej: Migraña crónica con aura. Se descartan causas neurológicas mayores." :rows="3" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header>
              <div class="flex items-center justify-between">
                <h3 class="font-semibold">Medicamentos recetados</h3>
                <UButton label="Agregar medicamento" color="secondary" variant="outline" size="sm" icon="i-lucide-plus" @click="addMedicamento" />
              </div>
            </template>
            <div class="space-y-4">
              <div v-if="form.medicamentos.length === 0" class="text-center py-6 text-gray-400">
                <i class="i-lucide-pill text-3xl mb-2 block"></i>
                <p class="text-sm">No hay medicamentos agregados. Haz clic en "Agregar medicamento".</p>
              </div>

              <div v-for="(med, index) in form.medicamentos" :key="index" class="border rounded-lg p-4 space-y-3 relative">
                <UButton color="error" variant="ghost" icon="i-lucide-x" size="xs" class="absolute top-2 right-2" @click="removeMedicamento(index)" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                  <UFormGroup :label="`Medicamento #${index + 1}`" required>
                    <p class="text-sm text-gray-500 mb-1">Nombre del medicamento</p>
                    <UInput v-model="med.nombre" placeholder="Ej: Paracetamol" />
                  </UFormGroup>
                  <UFormGroup label="Dosis">
                    <p class="text-sm text-gray-500 mb-1">Cantidad y concentración</p>
                    <UInput v-model="med.dosis" placeholder="Ej: 500mg" />
                  </UFormGroup>
                  <UFormGroup label="Frecuencia">
                    <p class="text-sm text-gray-500 mb-1">Cada cuánto tomarlo</p>
                    <UInput v-model="med.frecuencia" placeholder="Ej: Cada 8 horas" />
                  </UFormGroup>
                  <UFormGroup label="Duración">
                    <p class="text-sm text-gray-500 mb-1">Por cuánto tiempo</p>
                    <UInput v-model="med.duracion" placeholder="Ej: 7 días" />
                  </UFormGroup>
                </div>
              </div>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Observaciones e indicaciones</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Observaciones médicas">
                <p class="text-sm text-gray-500 mb-1">Notas adicionales sobre el estado del paciente</p>
                <UTextarea v-model="form.observaciones_medicas" placeholder="Ej: Paciente presenta sensibilidad a la luz. Se recomienda reposo en ambiente oscuro." :rows="3" />
              </UFormGroup>
              <UFormGroup label="Indicaciones">
                <p class="text-sm text-gray-500 mb-1">Recomendaciones y cuidados para el paciente</p>
                <UTextarea v-model="form.indicaciones" placeholder="Ej: Evitar esfuerzo físico por 48 horas. Mantener hidratación. Volver a consulta si el dolor persiste." :rows="3" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('historiales-clinicos.index')" />
            <UButton type="submit" color="primary" label="Guardar informe" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
