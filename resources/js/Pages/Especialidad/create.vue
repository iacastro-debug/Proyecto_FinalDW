<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const form = reactive({ nombre: '', descripcion: '', activo: true })
const loading = ref(false)
const submit = () => { loading.value = true; router.post(route('especialidades.store'), form, { onFinish: () => loading.value = false }) }
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nueva Especialidad"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Información de la especialidad</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Nombre de la especialidad" required>
                <p class="text-sm text-gray-500 mb-1">Ej: Cardiología, Pediatría, Traumatología</p>
                <UInput v-model="form.nombre" placeholder="Ej: Medicina General" />
              </UFormGroup>
              <UFormGroup label="Descripción">
                <p class="text-sm text-gray-500 mb-1">Describe brevemente el alcance de esta especialidad</p>
                <UTextarea v-model="form.descripcion" placeholder="Ej: Atención médica integral para pacientes adultos, diagnóstico y tratamiento de enfermedades comunes." :rows="3" />
              </UFormGroup>
              <UFormGroup label="Estado">
                <UCheckbox v-model="form.activo" label="Especialidad activa" />
                <p class="text-sm text-gray-500 mt-1">Si está activa, aparecerá en los listados del sistema</p>
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('especialidades.index')" />
            <UButton type="submit" color="primary" label="Guardar especialidad" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
