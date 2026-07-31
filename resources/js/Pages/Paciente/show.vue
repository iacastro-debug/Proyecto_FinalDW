<script setup lang="ts">
defineProps<{ paciente: any }>()
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
      <div class="w-full max-w-5xl mx-auto p-4 md:p-8 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-800">
          <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
              {{ paciente.nombres }} {{ paciente.apellidos }}
            </h1>
            <UBadge color="primary" variant="soft" size="md">Ficha del Paciente</UBadge>
          </div>
          <UButton label="Editar" color="warning" icon="i-lucide-pencil" :to="`/pacientes/${paciente.id}/edit`" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <UCard>
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-primary-500/10 text-primary-600 dark:text-primary-400">
                  <UIcon name="i-lucide-user" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Información Personal</h2>
              </div>
            </template>
            <div class="space-y-3 text-sm">
              <div><strong>Documento:</strong> {{ paciente.tipo_documento }} - {{ paciente.numero_documento }}</div>
              <div><strong>Fecha de nacimiento:</strong> {{ paciente.fecha_nacimiento || 'No registrada' }}</div>
              <div><strong>Género:</strong> {{ paciente.genero || 'No registrado' }}</div>
              <div><strong>Grupo sanguíneo:</strong> {{ paciente.grupo_sanguineo || 'No registrado' }}</div>
              <div><strong>Seguro médico:</strong> {{ paciente.seguro_medico || 'No registrado' }}</div>
            </div>
          </UCard>

          <UCard>
            <template #header>
              <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                  <UIcon name="i-lucide-map-pin" class="w-5 h-5" />
                </div>
                <h2 class="text-base font-bold text-gray-900 dark:text-white">Contacto</h2>
              </div>
            </template>
            <div class="space-y-3 text-sm">
              <div><strong>Email:</strong> {{ paciente.email }}</div>
              <div><strong>Teléfono:</strong> {{ paciente.telefono || 'No registrado' }}</div>
              <div><strong>Dirección:</strong> {{ paciente.direccion || 'No registrada' }}</div>
              <div><strong>Contacto de emergencia:</strong> {{ paciente.contacto_emergencia_nombre || 'No registrado' }}</div>
              <div><strong>Tel. emergencia:</strong> {{ paciente.contacto_emergencia_telefono || 'No registrado' }}</div>
            </div>
          </UCard>
        </div>

        <UCard>
          <template #header>
            <div class="flex items-center gap-2.5">
              <div class="p-2 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400">
                <UIcon name="i-lucide-heart-pulse" class="w-5 h-5" />
              </div>
              <h2 class="text-base font-bold text-gray-900 dark:text-white">Información Médica</h2>
            </div>
          </template>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div><strong>Alergias:</strong><p class="text-gray-600">{{ paciente.alergias || 'Ninguna' }}</p></div>
            <div><strong>Enfermedades crónicas:</strong><p class="text-gray-600">{{ paciente.enfermedades_cronicas || 'Ninguna' }}</p></div>
            <div><strong>Medicamentos actuales:</strong><p class="text-gray-600">{{ paciente.medicamentos_actuales || 'Ninguno' }}</p></div>
          </div>
        </UCard>
      </div>
    </template>
  </UDashboardPanel>
</template>
