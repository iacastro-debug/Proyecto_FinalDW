<script setup lang="ts">
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps<{ especialidades: any[] }>()

const form = reactive({
  name: '', email: '', password: '', password_confirmation: '',
  especialidad_id: '', telefono: '', numero_registro: ''
})
const loading = ref(false)
const submit = () => { loading.value = true; router.post(route('medicos.store'), form, { onFinish: () => loading.value = false }) }
</script>
<template>
  <UDashboardPanel>
    <template #header><UDashboardNavbar title="Nuevo Médico"><template #leading><UDashboardSidebarCollapse /></template></UDashboardNavbar></template>
    <template #body>
      <div class="p-6 max-w-2xl mx-auto">
        <form @submit.prevent="submit" class="space-y-8">
          <UCard>
            <template #header><h3 class="font-semibold">Datos de la cuenta</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Nombre completo" required>
                <p class="text-sm text-gray-500 mb-1">Nombres y apellidos del médico</p>
                <UInput v-model="form.name" placeholder="Ej: Dr. Ricardo Sánchez Mendoza" />
              </UFormGroup>
              <UFormGroup label="Correo electrónico" required>
                <p class="text-sm text-gray-500 mb-1">Se usará como usuario para iniciar sesión</p>
                <UInput v-model="form.email" type="email" placeholder="Ej: rsanchez@clinica.com" />
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
            <template #header><h3 class="font-semibold">Datos profesionales</h3></template>
            <div class="space-y-4">
              <UFormGroup label="Especialidad" required>
                <p class="text-sm text-gray-500 mb-1">Selecciona la especialidad principal del médico</p>
                <USelect v-model="form.especialidad_id" :items="especialidades.map((e: any) => ({ label: e.nombre, value: e.id }))" placeholder="Seleccionar especialidad..." />
              </UFormGroup>
              <UFormGroup label="N° de registro profesional">
                <p class="text-sm text-gray-500 mb-1">CMP (Perú) o equivalente según el país</p>
                <UInput v-model="form.numero_registro" placeholder="Ej: CMP 12345" />
              </UFormGroup>
              <UFormGroup label="Teléfono">
                <p class="text-sm text-gray-500 mb-1">Teléfono de contacto profesional</p>
                <UInput v-model="form.telefono" placeholder="Ej: +51 999 888 777" />
              </UFormGroup>
            </div>
          </UCard>

          <div class="flex gap-3 justify-end">
            <UButton label="Cancelar" variant="subtle" :to="route('medicos.index')" />
            <UButton type="submit" color="primary" label="Guardar médico" :loading="loading" icon="i-lucide-save" />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
