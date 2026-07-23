<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{ historial: any, medico: any }>()

const form = reactive({
  motivo_consulta: props.historial.motivo_consulta,
  observaciones_medicas: props.historial.observaciones_medicas || '',
  diagnostico: props.historial.diagnostico,
  medicamentos: (props.historial.medicamentos || []) as { nombre: string; dosis: string; frecuencia: string; duracion: string }[],
  indicaciones: props.historial.indicaciones || '',
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
  router.put(route('historiales-clinicos.update', props.historial.id), form, { onFinish: () => loading.value = false })
}
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Editar Informe de Consulta"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-3xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
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
                <p class="text-sm">No hay medicamentos agregados.</p>
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
            <template #header><h3 class="font-semibold">Datos de la consulta</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Motivo de consulta" required>
                <p class="text-sm text-gray-500 mb-1">Motivo por el cual el paciente solicitó la consulta</p>
                <UTextarea v-model="form.motivo_consulta" placeholder="Motivo de consulta" :rows="2" />
              </UFormGroup>
              <UFormGroup label="Diagnóstico" required>
                <p class="text-sm text-gray-500 mb-1">Diagnóstico principal del médico</p>
                <UTextarea v-model="form.diagnostico" placeholder="Diagnóstico" :rows="3" />
              </UFormGroup>
              <UFormGroup label="Observaciones médicas">
                <p class="text-sm text-gray-500 mb-1">Notas adicionales sobre el estado del paciente</p>
                <UTextarea v-model="form.observaciones_medicas" placeholder="Observaciones" :rows="3" />
              </UFormGroup>
              <UFormGroup label="Indicaciones">
                <p class="text-sm text-gray-500 mb-1">Recomendaciones y cuidados para el paciente</p>
                <UTextarea v-model="form.indicaciones" placeholder="Indicaciones" :rows="3" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('historiales-clinicos.index')" />
            <UButton type="submit" color="primary" label="Actualizar informe" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
