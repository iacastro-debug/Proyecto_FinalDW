<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'

const props = defineProps<{ paciente: any }>()

const form = useForm({
  email: props.paciente.email,
  nombres: props.paciente.nombres,
  apellidos: props.paciente.apellidos,
  tipo_documento: props.paciente.tipo_documento || 'DNI',
  numero_documento: props.paciente.numero_documento,
  fecha_nacimiento: props.paciente.fecha_nacimiento || '',
  genero: props.paciente.genero || 'Masculino',
  telefono: props.paciente.telefono || '',
  direccion: props.paciente.direccion || '',
  grupo_sanguineo: props.paciente.grupo_sanguineo || 'O+',
  alergias: props.paciente.alergias || '',
  enfermedades_cronicas: props.paciente.enfermedades_cronicas || '',
  medicamentos_actuales: props.paciente.medicamentos_actuales || '',
  contacto_emergencia_nombre: props.paciente.contacto_emergencia_nombre || '',
  contacto_emergencia_telefono: props.paciente.contacto_emergencia_telefono || '',
  seguro_medico: props.paciente.seguro_medico || ''
})

const actualizar = () => {
  form.put(`/pacientes/${props.paciente.id}`, {
    onError: (errors) => {
      console.error('Errores al actualizar:', errors)
    }
  })
}
</script>

<template>
  <UDashboardPanel grow class="w-full min-h-screen bg-slate-50/60 dark:bg-gray-900">
    <template #header>
      <UDashboardNavbar>
        <template #leading>
          <UButton
            icon="i-lucide-arrow-left"
            color="gray"
            variant="ghost"
            to="/pacientes"
            label="Volver a la lista"
            size="sm"
          />
        </template>
      </UDashboardNavbar>
    </template>

    <template #body>
      <div class="w-full max-w-7xl mx-auto p-4 md:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
          <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
              Editar Paciente
            </h1>
            <UBadge color="warning" variant="soft" size="md">Actualizar Ficha</UBadge>
          </div>
        </div>

        <form @submit.prevent="actualizar" class="w-full space-y-6">
          <UCard class="w-full shadow-sm hover:shadow-md transition-shadow border border-gray-200/80 dark:border-gray-800">
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-primary-500/10 text-primary-600 dark:text-primary-400">
                  <UIcon name="i-lucide-user" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Información Personal</h2>
              </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Nombres <span class="text-red-500">*</span>
                </label>
                <UInput v-model="form.nombres" icon="i-lucide-user" required size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Apellidos <span class="text-red-500">*</span>
                </label>
                <UInput v-model="form.apellidos" required size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Fecha de Nacimiento
                </label>
                <UInput v-model="form.fecha_nacimiento" type="date" size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Tipo de Documento
                </label>
                <select
                  v-model="form.tipo_documento"
                  class="w-full h-[38px] px-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                >
                  <option value="DNI">DNI</option>
                  <option value="Pasaporte">Pasaporte</option>
                  <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                </select>
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  N° de Documento <span class="text-red-500">*</span>
                </label>
                <UInput v-model="form.numero_documento" icon="i-lucide-id-card" required size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Género
                </label>
                <select
                  v-model="form.genero"
                  class="w-full h-[38px] px-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition cursor-pointer"
                >
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>
          </UCard>

          <UCard class="w-full shadow-sm hover:shadow-md transition-shadow border border-gray-200/80 dark:border-gray-800">
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                  <UIcon name="i-lucide-map-pin" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Contacto y Ubicación</h2>
              </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Correo Electrónico <span class="text-red-500">*</span>
                </label>
                <UInput v-model="form.email" type="email" icon="i-lucide-mail" required size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Teléfono / Celular
                </label>
                <UInput v-model="form.telefono" icon="i-lucide-phone" size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Dirección de Domicilio
                </label>
                <UInput v-model="form.direccion" icon="i-lucide-home" size="md" />
              </div>
            </div>
          </UCard>

          <UCard class="w-full shadow-sm hover:shadow-md transition-shadow border border-gray-200/80 dark:border-gray-800">
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400">
                  <UIcon name="i-lucide-heart-pulse" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Información Médica</h2>
              </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Grupo Sanguíneo
                </label>
                <select
                  v-model="form.grupo_sanguineo"
                  class="w-full h-[38px] px-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition cursor-pointer"
                >
                  <option value="A+">A+</option>
                  <option value="A-">A-</option>
                  <option value="B+">B+</option>
                  <option value="B-">B-</option>
                  <option value="AB+">AB+</option>
                  <option value="AB-">AB-</option>
                  <option value="O+">O+</option>
                  <option value="O-">O-</option>
                </select>
              </div>

              <div class="md:col-span-3">
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Seguro Médico
                </label>
                <UInput v-model="form.seguro_medico" icon="i-lucide-shield-check" size="md" />
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Alergias Conocidas
                </label>
                <UTextarea v-model="form.alergias" rows="3" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Enfermedades Crónicas
                </label>
                <UTextarea v-model="form.enfermedades_cronicas" rows="3" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Medicamentos Actuales
                </label>
                <UTextarea v-model="form.medicamentos_actuales" rows="3" />
              </div>
            </div>
          </UCard>

          <UCard class="w-full shadow-sm hover:shadow-md transition-shadow border border-gray-200/80 dark:border-gray-800">
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400">
                  <UIcon name="i-lucide-shield-alert" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Contacto de Emergencia</h2>
              </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Nombre Completo del Contacto
                </label>
                <UInput v-model="form.contacto_emergencia_nombre" icon="i-lucide-user-check" size="md" />
              </div>

              <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-gray-700 dark:text-gray-300">
                  Teléfono de Emergencia
                </label>
                <UInput v-model="form.contacto_emergencia_telefono" icon="i-lucide-phone-call" size="md" />
              </div>
            </div>
          </UCard>

          <div class="flex items-center justify-end gap-3 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-200/80 dark:border-gray-700 shadow-sm">
            <UButton label="Cancelar" color="gray" variant="ghost" to="/pacientes" size="lg" />
            <UButton
              type="submit"
              label="Actualizar Paciente"
              color="primary"
              icon="i-lucide-check-circle"
              size="lg"
              :loading="form.processing"
            />
          </div>
        </form>
      </div>
    </template>
  </UDashboardPanel>
</template>
