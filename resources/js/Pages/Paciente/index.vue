<script setup>
import { ref, watch } from 'vue'
import { router, Link } from '@inertiajs/vue3'

const props = defineProps({
  pacientes: Object,
  filters: Object,
})

const search = ref(props.filters?.search || '')
const tipoDoc = ref(props.filters?.tipo_doc || '')

watch([search, tipoDoc], ([newSearch, newTipoDoc]) => {
  router.get('/pacientes', { search: newSearch, tipo_doc: newTipoDoc }, {
    preserveState: true,
    replace: true,
  })
})

// AGREGAR ESTA FUNCIÓN AQUÍ ABAJO:
const eliminarPaciente = (paciente) => {
  const nombre = `${paciente.nombres} ${paciente.apellidos || ''}`.trim()
  
  if (confirm(`¿Estás seguro de eliminar a "${nombre}"?`)) {
    const id = paciente.id || paciente.uuid
    router.delete(`/pacientes/${id}`, {
      preserveScroll: true,
    })
  }
}
</script>

<template>
  <div class="max-w-7xl mx-auto space-y-6 p-2">

    <!-- Header del Módulo -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm">
      <div class="flex items-center gap-3">
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-xl font-bold text-gray-900">Directorio de Pacientes</h1>
          <p class="text-xs text-gray-500">Gestión de expedientes, historial de atenciones y datos personales.</p>
        </div>
      </div>

      <Link 
        href="/pacientes/crear" 
        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition-all duration-200 active:scale-95"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Registrar Paciente
      </Link>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-sm flex flex-col md:flex-row gap-3 items-center justify-between">
      <div class="relative w-full md:w-96">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </span>
        <input 
          v-model="search"
          type="text" 
          placeholder="Buscar por nombre, documento o teléfono..."
          class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:border-transparent outline-none transition"
        />
      </div>

      <div class="flex items-center gap-3 w-full md:w-auto">
        <select 
          v-model="tipoDoc"
          class="w-full md:w-48 py-2 px-3 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition"
        >
          <option value="">Todos los documentos</option>
          <option value="DNI">DNI / Cédula</option>
          <option value="PASAPORTE">Pasaporte</option>
          <option value="CARNET_EXT">Carnet Extranjería</option>
        </select>
      </div>
    </div>

    <!-- Tabla Clínica de Pacientes -->
    <div class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
          <thead class="bg-gray-50/80 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider font-semibold">
            <tr>
              <th class="px-6 py-4">Paciente</th>
              <th class="px-6 py-4">Documento</th>
              <th class="px-6 py-4">Contacto</th>
              <th class="px-6 py-4">Estado</th>
              <th class="px-6 py-4 text-right">Opciones</th>
            </tr>
          </thead>

          <tbody>
  <tr v-for="p in (pacientes.data || pacientes)" :key="p?.id" class="hover:bg-emerald-50/30 transition-colors">
    <!-- Paciente -->
    <td class="px-6 py-4 whitespace-nowrap">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-sm shrink-0 border border-emerald-200">
          {{ (p?.nombres || 'P').charAt(0).toUpperCase() }}
        </div>
        <div>
          <div class="font-semibold text-gray-900">{{ p?.nombres }} {{ p?.apellidos }}</div>
          <div class="text-xs text-gray-400">{{ p?.email || 'Sin correo registrado' }}</div>
        </div>
      </div>
    </td>

    <!-- Documento -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
      <span class="font-medium text-gray-900">{{ p?.tipo_documento }}:</span> {{ p?.numero_documento }}
    </td>

    <!-- Contacto -->
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
      <div>{{ p?.telefono || 'Sin teléfono' }}</div>
      <div class="text-xs text-gray-400">{{ p?.direccion || 'Sin dirección' }}</div>
    </td>

    <!-- Estado -->
    <td class="px-6 py-4 whitespace-nowrap">
      <span 
        :class="p?.activo ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'" 
        class="px-2.5 py-1 rounded-full text-xs font-medium inline-block"
      >
        {{ p?.activo ? 'Activo' : 'Inactivo' }}
      </span>
    </td>

    <!-- Opciones -->
<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
  <div class="flex items-center justify-end gap-1">
    
    <!-- Botón Editar (Tu Link actual) -->
    <Link
      :href="`/pacientes/${p?.id}/editar`"
      title="Editar Datos"
      class="inline-flex items-center p-2 text-gray-500 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
    </Link>

    <!-- Botón Eliminar -->
    <button
      type="button"
      @click="eliminarPaciente(p)"
      title="Eliminar Paciente"
      class="inline-flex items-center p-2 text-gray-500 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors cursor-pointer"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>
    </button>

  </div>
</td>
  </tr>

  <!-- Estado Vacío -->
  <tr v-if="!pacientes?.data?.length && !pacientes?.length">
    <td colspan="5" class="px-6 py-12 text-center">
      <div class="max-w-xs mx-auto space-y-3">
        <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
          </svg>
        </div>
        <div class="text-sm font-semibold text-gray-900">No hay pacientes registrados</div>
        <p class="text-xs text-gray-500">No se encontraron registros que coincidan con la búsqueda.</p>
      </div>
    </td>
  </tr>
</tbody>
        </table>
      </div>

      <!-- Footer Paginación -->
      <div v-if="pacientes.links && pacientes.links.length > 3" class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
        <span class="text-xs text-gray-500">
          Mostrando resultados de la consulta clínica
        </span>
        <div class="flex gap-1">
          <Component 
            :is="link.url ? 'Link' : 'span'"
            v-for="(link, key) in pacientes.links" 
            :key="key"
            :href="link.url"
            v-html="link.label"
            class="px-3 py-1.5 text-xs rounded-lg border font-medium transition"
            :class="{
              'bg-emerald-600 text-white border-emerald-600 shadow-xs': link.active,
              'bg-white text-gray-700 hover:bg-gray-50 border-gray-200': !link.active && link.url,
              'text-gray-300 border-gray-100 cursor-not-allowed': !link.url
            }"
          />
        </div>
      </div>

    </div>
  </div>
</template>