<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

const form = reactive({
  name: '', email: '', password: '', password_confirmation: '',
  tipo_documento: 'DNI', numero_documento: '', fecha_nacimiento: '',
  telefono: '', direccion: '', grupo_sanguineo: '', alergias: '',
  contacto_emergencia_nombre: '', contacto_emergencia_telefono: ''
})
const loading = ref(false)
const submit = () => { loading.value = true; router.post(route('pacientes.store'), form, { onFinish: () => loading.value = false }) }
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nuevo Paciente"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Datos de la cuenta</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Nombre completo" required>
                <p class="text-sm text-gray-500 mb-1">Nombres y apellidos del paciente</p>
                <UInput v-model="form.name" placeholder="Ej: Juan Carlos Pérez López" />
              </UFormGroup>
              <UFormGroup label="Correo electrónico" required>
                <p class="text-sm text-gray-500 mb-1">Se usará para iniciar sesión en el sistema</p>
                <UInput v-model="form.email" type="email" placeholder="Ej: jperez@correo.com" />
              </UFormGroup>
              <UFormGroup label="Contraseña" required>
                <p class="text-sm text-gray-500 mb-1">Mínimo 8 caracteres</p>
                <UInput v-model="form.password" type="password" placeholder="••••••••" />
              </UFormGroup>
              <UFormGroup label="Confirmar contraseña" required>
                <UInput v-model="form.password_confirmation" type="password" placeholder="Repite la contraseña" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Datos personales</h3></template>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Tipo de documento" required>
                  <p class="text-sm text-gray-500 mb-1">DNI, CE o Pasaporte</p>
                  <USelect v-model="form.tipo_documento" :items="['DNI', 'CE', 'Pasaporte']" />
                </UFormGroup>
                <UFormGroup label="N° de documento" required>
                  <p class="text-sm text-gray-500 mb-1">Según el tipo de documento seleccionado</p>
                  <UInput v-model="form.numero_documento" placeholder="Ej: 12345678" />
                </UFormGroup>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormGroup label="Fecha de nacimiento">
                  <p class="text-sm text-gray-500 mb-1">Para calcular la edad automáticamente</p>
                  <UInput v-model="form.fecha_nacimiento" type="date" />
                </UFormGroup>
                <UFormGroup label="Teléfono">
                  <p class="text-sm text-gray-500 mb-1">Teléfono de contacto del paciente</p>
                  <UInput v-model="form.telefono" placeholder="Ej: +51 999 888 777" />
                </UFormGroup>
              </div>
              <UFormGroup label="Dirección">
                <p class="text-sm text-gray-500 mb-1">Dirección de residencia actual</p>
                <UTextarea v-model="form.direccion" placeholder="Ej: Av. Principal 123, Lima" :rows="2" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Información médica</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Grupo sanguíneo">
                <p class="text-sm text-gray-500 mb-1">Importante para emergencias</p>
                <USelect v-model="form.grupo_sanguineo" :items="['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']" placeholder="Seleccionar..." />
              </UFormGroup>
              <UFormGroup label="Alergias conocidas">
                <p class="text-sm text-gray-500 mb-1">Medicamentos, alimentos u otras sustancias</p>
                <UTextarea v-model="form.alergias" placeholder="Ej: Penicilina, aspirina, mariscos" :rows="2" />
              </UFormGroup>
            </div>
          </UCard>

          <UCard>
            <template #header><h3 class="font-semibold">Contacto de emergencia</h3></template>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <UFormGroup label="Nombre del contacto">
                <p class="text-sm text-gray-500 mb-1">Persona a contactar en caso de emergencia</p>
                <UInput v-model="form.contacto_emergencia_nombre" placeholder="Ej: María López" />
              </UFormGroup>
              <UFormGroup label="Teléfono del contacto">
                <p class="text-sm text-gray-500 mb-1">Teléfono del contacto de emergencia</p>
                <UInput v-model="form.contacto_emergencia_telefono" placeholder="Ej: +51 999 111 222" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('pacientes.index')" />
            <UButton type="submit" color="primary" label="Guardar paciente" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
