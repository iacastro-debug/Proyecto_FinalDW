<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ pacientes: any[] }>()

const form = reactive({
  paciente_id: '', edad: null, genero: '', sintomas_principales: '', duracion_sintomas: '',
  nivel_dolor: 5, fiebre: false, dificultad_respirar: false, dolor_pecho: false,
  antecedentes: '', urgencia_percibida: 'media', observaciones: ''
})
const loading = ref(false)

const submit = () => {
  loading.value = true
  router.post(route('evaluaciones-ia.store'), form, { onFinish: () => loading.value = false })
}
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nueva Evaluación IA"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 text-sm text-primary-800">
            <strong>¿Cómo funciona?</strong> Completa los síntomas del paciente y la IA analizará la información para sugerir una especialidad médica y nivel de prioridad.
          </div>

          <UCard>
            <template #header><h3 class="font-semibold">Datos del paciente</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Paciente" required>
                <p class="text-sm text-gray-500 mb-1">Selecciona el paciente a evaluar</p>
                <USelect v-model="form.paciente_id" :items="pacientes.map((p: any) => ({ label: `${p.user.name} - ${p.numero_documento}`, value: p.id }))" placeholder="Seleccionar paciente..." />
              </UFormGroup>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Edad">
                  <p class="text-sm text-gray-500 mb-1">En años cumplidos. Si no ingresas, se calculará automáticamente</p>
                  <UInput v-model="form.edad" type="number" min="0" max="150" placeholder="Ej: 35" />
                </UFormGroup>
                <UFormGroup label="Género">
                  <p class="text-sm text-gray-500 mb-1">Género del paciente</p>
                  <USelect v-model="form.genero" :items="['M', 'F', 'Otro']" placeholder="Seleccionar..." />
                </UFormGroup>
              </div>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Síntomas y signos</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Síntomas principales" required>
                <p class="text-sm text-gray-500 mb-1">Describe los síntomas que presenta el paciente de forma detallada</p>
                <UTextarea v-model="form.sintomas_principales" placeholder="Ej: Dolor de cabeza intenso y persistente desde hace 3 días, acompañado de náuseas y sensibilidad a la luz. El dolor empeora con el movimiento." :rows="4" />
              </UFormGroup>
              <UFormGroup label="Duración de los síntomas">
                <p class="text-sm text-gray-500 mb-1">¿Desde cuándo presenta estos síntomas?</p>
                <UInput v-model="form.duracion_sintomas" placeholder="Ej: 3 días, 2 semanas, 1 mes" />
              </UFormGroup>
              <UFormGroup label="Nivel de dolor (1-10)">
                <p class="text-sm text-gray-500 mb-1">1 = dolor leve, 10 = dolor insoportable</p>
                <div class="flex items-center gap-3">
                  <UInput v-model="form.nivel_dolor" type="range" min="1" max="10" class="flex-1" />
                  <span class="text-lg font-bold w-8 text-center">{{ form.nivel_dolor }}</span>
                </div>
              </UFormGroup>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <UFormGroup label="Fiebre">
                  <UCheckbox v-model="form.fiebre" label="Sí, tiene fiebre" />
                  <p class="text-sm text-gray-500 mt-1">¿Tiene temperatura elevada?</p>
                </UFormGroup>
                <UFormGroup label="Dificultad respirar">
                  <UCheckbox v-model="form.dificultad_respirar" label="Sí, dificultad" />
                  <p class="text-sm text-gray-500 mt-1">¿Respira con dificultad?</p>
                </UFormGroup>
                <UFormGroup label="Dolor en el pecho">
                  <UCheckbox v-model="form.dolor_pecho" label="Sí, dolor en el pecho" />
                  <p class="text-sm text-gray-500 mt-1">¿Siente dolor en el pecho?</p>
                </UFormGroup>
              </div>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Información adicional</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Antecedentes">
                <p class="text-sm text-gray-500 mb-1">Enfermedades preexistentes, alergias, medicamentos actuales</p>
                <UTextarea v-model="form.antecedentes" placeholder="Ej: Hipertensión controlada, alergia a la penicilina, toma Losartán 50mg/día" :rows="3" />
              </UFormGroup>
              <UFormGroup label="Urgencia percibida">
                <p class="text-sm text-gray-500 mb-1">¿Qué tan urgente considera que es la atención?</p>
                <USelect v-model="form.urgencia_percibida" :items="[
                  { label: 'Baja - Puede esperar', value: 'baja' },
                  { label: 'Media - Debería atenderse pronto', value: 'media' },
                  { label: 'Alta - Requiere atención inmediata', value: 'alta' },
                ]" />
              </UFormGroup>
              <UFormGroup label="Observaciones">
                <p class="text-sm text-gray-500 mb-1">Cualquier otro dato relevante</p>
                <UTextarea v-model="form.observaciones" placeholder="Ej: El paciente ha perdido 5 kg en el último mes sin causa aparente" :rows="2" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('evaluaciones-ia.index')" />
            <UButton type="submit" color="primary" label="Evaluar con IA" :loading="loading" icon="i-lucide-brain" size="lg" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
