<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const props = defineProps<{ paciente: any }>()
const form = reactive({
  name: props.paciente.user.name, email: props.paciente.user.email,
  tipo_documento: props.paciente.tipo_documento, numero_documento: props.paciente.numero_documento,
  telefono: props.paciente.telefono, direccion: props.paciente.direccion,
  fecha_nacimiento: props.paciente.fecha_nacimiento, genero: props.paciente.genero
})
const loading = ref(false)
const submit = () => { loading.value = true; router.put(route('pacientes.update', props.paciente.id), form, { onFinish: () => loading.value = false }) }
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Editar Paciente"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Datos de la cuenta</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Nombre completo" required>
                <p class="text-sm text-gray-500 mb-1">Nombres y apellidos del paciente</p>`n                <UInput v-model="form.name" placeholder="Ej: Juan Carlos Pérez López" />
              </UFormGroup>
              <UFormGroup label="Correo electrónico" required>
                <p class="text-sm text-gray-500 mb-1">Se usará como usuario para iniciar sesión</p>`n                <UInput v-model="form.email" type="email" placeholder="Ej: juan.perez@correo.com" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Datos personales</h3></template>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Tipo de documento">
                  <p class="text-sm text-gray-500 mb-1">DNI, Carné de Extranjería o Pasaporte</p>`n                <USelect v-model="form.tipo_documento" :items="['DNI', 'CE', 'Pasaporte']" />
                </UFormGroup>
                <UFormGroup label="N° de documento">
                  <p class="text-sm text-gray-500 mb-1">Ingresa el número sin guiones ni espacios</p>`n                <UInput v-model="form.numero_documento" placeholder="Ej: 12345678" />
                </UFormGroup>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Teléfono">
                  <p class="text-sm text-gray-500 mb-1">Incluye código de país si es necesario</p>`n                <UInput v-model="form.telefono" placeholder="Ej: +51 999 888 777" />
                </UFormGroup>
                <UFormGroup label="Fecha de nacimiento">
                  <UInput v-model="form.fecha_nacimiento" type="date" />
                </UFormGroup>
              </div>
              <UFormGroup label="Género">
                <USelect v-model="form.genero" :items="['M', 'F', 'Otro']" />
              </UFormGroup>
              <UFormGroup label="Dirección">
                <UTextarea v-model="form.direccion" placeholder="Ej: Av. Principal 123, Urb. Las Flores" :rows="2" />
                <p class="text-sm text-gray-500 mt-1">Dirección de residencia actual</p>
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('pacientes.index')" />
            <UButton type="submit" color="primary" label="Actualizar paciente" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
