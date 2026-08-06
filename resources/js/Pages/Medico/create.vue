<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { computed } from 'vue'

const props = defineProps<{
  especialidades?: any[]
}>()

const especialidadesItems = computed(() => {
  if (!props.especialidades || !Array.isArray(props.especialidades)) return []
  
  return props.especialidades.map((esp: any) => {
    if (typeof esp === 'string') {
      return { label: esp, value: esp }
    }
    return {
      label: esp.nombre || esp.name || esp.label || 'Sin nombre',
      value: esp.nombre || esp.id || esp.value
    }
  })
})

const form = useForm({
  name: '',
  email: '',
  especialidad: '',
  numero_registro: '',
  telefono: '',
  estado: 'activo'
})

const submit = () => {
  form.post(route('medicos.store'))
}
</script>

<template>
  <UDashboardPanel>
    <!-- Encabezado -->
    <template #header>
      <UDashboardNavbar>
        <template #leading>
          <div class="flex items-center gap-3">
            <UButton 
              icon="i-lucide-arrow-left" 
              color="neutral" 
              variant="ghost" 
              :to="route('medicos.index')" 
            />
            <div>
              <h1 class="text-xl font-bold text-gray-900">Registrar Nuevo Médico</h1>
              <p class="text-xs text-gray-500">Ingresa la información personal y credenciales profesionales</p>
            </div>
          </div>
        </template>

        <template #right>
          <div class="flex items-center gap-2">
            <UButton 
              label="Cancelar" 
              color="neutral" 
              variant="ghost" 
              :to="route('medicos.index')" 
            />
            <UButton 
              label="Guardar Médico" 
              color="neutral" 
              class="bg-gray-900 hover:bg-gray-800 text-white cursor-pointer" 
              :loading="form.processing"
              @click="submit"
            />
          </div>
        </template>
      </UDashboardNavbar>
    </template>

    <!-- Cuerpo del formulario -->
    <template #body>
      <form @submit.prevent="submit" class="p-6 max-w-7xl mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
          
          <!-- COLUMNA IZQUIERDA: Datos de la Cuenta -->
          <UCard class="shadow-sm border border-gray-200/80">
            <template #header>
              <div class="flex justify-between items-center py-1">
                <h2 class="text-base font-bold text-gray-900">Datos de la Cuenta</h2>
                <UBadge color="emerald" variant="subtle" size="xs">Paso 1</UBadge>
              </div>
            </template>

            <div class="space-y-6 py-2">
              <UFormField 
                label="NOMBRES Y APELLIDOS DEL MÉDICO *" 
                :error="form.errors.name"
                class="text-xs font-semibold uppercase text-gray-500"
              >
                <UInput 
                  v-model="form.name" 
                  placeholder="Ej: Dr. Ricardo Sánchez Mendoza" 
                  icon="i-lucide-user"
                  size="md"
                  class="w-full mt-1.5"
                />
              </UFormField>

              <UFormField 
                label="CORREO ELECTRÓNICO *" 
                :error="form.errors.email"
                class="text-xs font-semibold uppercase text-gray-500"
              >
                <UInput 
                  v-model="form.email" 
                  type="email" 
                  placeholder="Ej: doctor@ejemplo.com" 
                  icon="i-lucide-mail"
                  size="md"
                  class="w-full mt-1.5"
                />
              </UFormField>
            </div>
          </UCard>

          <!-- COLUMNA DERECHA: Información Profesional -->
          <UCard class="shadow-sm border border-gray-200/80">
            <template #header>
              <div class="flex justify-between items-center py-1">
                <h2 class="text-base font-bold text-gray-900">Información Profesional</h2>
                <UBadge color="emerald" variant="subtle" size="xs">Paso 2</UBadge>
              </div>
            </template>

            <div class="space-y-6 py-2">
              <UFormField 
                label="ESPECIALIDAD PRINCIPAL *" 
                :error="form.errors.especialidad"
                class="text-xs font-semibold uppercase text-gray-500"
              >
                <USelect 
                  v-model="form.especialidad" 
                  :items="especialidadesItems" 
                  placeholder="Seleccionar especialidad..." 
                  icon="i-lucide-stethoscope"
                  size="md"
                  class="w-full mt-1.5"
                />
              </UFormField>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <UFormField 
                  label="N° REGISTRO PROFESIONAL (CMP)" 
                  :error="form.errors.numero_registro"
                  class="text-xs font-semibold uppercase text-gray-500"
                >
                  <UInput 
                    v-model="form.numero_registro" 
                    placeholder="Ej: CMP 12345" 
                    icon="i-lucide-file-signature"
                    size="md"
                    class="w-full mt-1.5"
                  />
                </UFormField>

                <UFormField 
                  label="TELÉFONO DE CONTACTO *" 
                  :error="form.errors.telefono"
                  class="text-xs font-semibold uppercase text-gray-500"
                >
                  <UInput 
                    v-model="form.telefono" 
                    placeholder="Ej: +51 999 888 777" 
                    icon="i-lucide-phone"
                    size="md"
                    class="w-full mt-1.5"
                  />
                </UFormField>
              </div>

              <UFormField 
                label="ESTADO DEL MÉDICO EN EL SISTEMA *" 
                :error="form.errors.estado"
                class="text-xs font-semibold uppercase text-gray-500"
              >
                <div class="flex items-center gap-6 pt-3">
                  <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-700">
                    <input 
                      type="radio" 
                      v-model="form.estado" 
                      value="activo" 
                      class="text-emerald-600 focus:ring-emerald-500 h-4 w-4"
                    />
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Activo
                  </label>

                  <label class="flex items-center gap-2 cursor-pointer text-sm font-medium text-gray-700">
                    <input 
                      type="radio" 
                      v-model="form.estado" 
                      value="inactivo" 
                      class="text-red-600 focus:ring-red-500 h-4 w-4"
                    />
                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    Inactivo
                  </label>
                </div>
              </UFormField>
            </div>
          </UCard>

        </div>
      </form>
    </template>
  </UDashboardPanel>
</template>