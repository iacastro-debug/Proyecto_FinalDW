<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  // Datos Generales
  nombres: '',
  apellidos: '',
  tipo_documento: 'DNI',
  numero_documento: '',
  email: '',
  telefono: '',
  direccion: '',
  estado: 'Activo',

  // Información Médica
  grupo_sanguineo: 'O+',
  seguro_medico: '',
  alergias: '',
  enfermedades_cronicas: '',
  medicamentos_actuales: '',

  // Contacto de Emergencia
  contacto_emergencia_nombre: '',
  contacto_emergencia_telefono: '',
})

const submit = () => {
  form.post('/pacientes')
}
</script>


<template>
  <div class="max-w-6xl mx-auto space-y-6 p-2 pb-12">
    
    <!-- Enlace Volver y Título -->
    <a
      href="/pacientes"
      class="inline-flex items-center gap-1 text-xs font-semibold text-gray-500 hover:text-emerald-600 transition cursor-pointer"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Volver a la lista
    </a>
  
  
      
      <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-gray-900">Registro General de Pacientes</h1>
        <span class="px-2.5 py-0.5 text-xs font-semibold bg-emerald-100 text-emerald-700 rounded-full border border-emerald-200">
          Nueva Ficha
        </span>
      </div>
    </div>

    <form @submit.prevent="submit" class="space-y-6">
      
      <!-- Seccion 1: Información Personal -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm space-y-4">
        <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
          <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <h2 class="font-bold text-gray-800 text-base">Información Personal</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Nombres -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nombres *</label>
            <input 
              v-model="form.nombres"
              type="text" 
              placeholder="Ej. Juan Carlos"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.nombres }"
            />
            <span v-if="form.errors.nombres" class="text-xs text-red-500 mt-1 block">{{ form.errors.nombres }}</span>
          </div>

          <!-- Apellidos -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Apellidos *</label>
            <input 
              v-model="form.apellidos"
              type="text" 
              placeholder="Ej. Pérez Gómez"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.apellidos }"
            />
            <span v-if="form.errors.apellidos" class="text-xs text-red-500 mt-1 block">{{ form.errors.apellidos }}</span>
          </div>

          <!-- Fecha de Nacimiento -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Fecha de Nacimiento *</label>
            <input 
              v-model="form.fecha_nacimiento"
              type="date" 
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.fecha_nacimiento }"
            />
            <span v-if="form.errors.fecha_nacimiento" class="text-xs text-red-500 mt-1 block">{{ form.errors.fecha_nacimiento }}</span>
          </div>

          <!-- Tipo de Documento -->
          <div>            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tipo de Documento *</label>
            <select 
              v-model="form.tipo_documento"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
            >
              <option value="DNI">DNI / Cédula</option>
              <option value="PASAPORTE">Pasaporte</option>
              <option value="CARNET_EXT">Carnet de Extranjería</option>
            </select>
          </div>

          <!-- N° de Documento -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">N° de Documento *</label>
            <input 
              v-model="form.numero_documento"
              type="text" 
              placeholder="12345678"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.numero_documento }"
            />
            <span v-if="form.errors.numero_documento" class="text-xs text-red-500 mt-1 block">{{ form.errors.numero_documento }}</span>
          </div>

          <!-- Género -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Género *</label>
            <select 
              v-model="form.genero"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
            >
              <option value="Masculino">Masculino</option>
              <option value="Femenino">Femenino</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Seccion 2: Contacto y Ubicación -->
      <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm space-y-4">
        <div class="flex items-center gap-2 border-b border-gray-100 pb-3">
          <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <h2 class="font-bold text-gray-800 text-base">Contacto y Ubicación</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Correo Electrónico -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Correo Electrónico *</label>
            <input 
              v-model="form.email"
              type="email" 
              placeholder="paciente@correo.com"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.email }"
            />
            <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
          </div>

          <!-- Teléfono -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Teléfono / Celular *</label>
            <input 
              v-model="form.telefono"
              type="text" 
              placeholder="+51 987 654 321"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
              :class="{ 'border-red-500': form.errors.telefono }"
            />
            <span v-if="form.errors.telefono" class="text-xs text-red-500 mt-1 block">{{ form.errors.telefono }}</span>
          </div>

          <!-- Dirección -->
          <div>
            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Dirección de Domicilio</label>
            <input 
              v-model="form.direccion"
              type="text" 
              placeholder="Av. Las Flores #123"
              class="w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition"
            />
          </div>
        </div>
      </div>

      <!-- Sección 3: Estado y Guardado -->
<div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
  <div class="flex items-center gap-3 w-full sm:w-auto">
    <label class="text-xs font-bold text-gray-600 uppercase">Estado del Paciente:</label>
    <select
      v-model="form.estado"
      class="py-1.5 px-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 outline-none focus:ring-2 focus:ring-emerald-500"
    >
      <option value="Activo">Activo</option>
      <option value="Inactivo">Inactivo</option>
    </select>
  </div>

  <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
    <!-- 1. CAMBIADO: Ahora es un <button type="button"> que ejecuta volver() -->
       <a
        href="/pacientes"
        class="px-5 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-xl transition cursor-pointer inline-block text-center"
      >
         Cancelar
      </a> 
    

    <!-- 2. Mantenemos el botón de guardar tal como lo tenías -->
    <button
      type="submit"
      :disabled="form.processing"
      class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-xl shadow-sm transition active:scale-95 disabled:opacity-50 cursor-pointer"

      >
      {{ form.processing ? 'Guardando...' : 'Guardar Paciente' }}
    </button>
  </div>
</div>
    </form>
</template>