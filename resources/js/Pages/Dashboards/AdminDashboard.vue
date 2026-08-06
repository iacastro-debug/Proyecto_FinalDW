<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { OhVueIcon, addIcons } from 'oh-vue-icons'
import { 
  FaCalendarPlus, 
  FaUserPlus, 
  FaFileMedical, 
  FaChevronRight, 
  FaMagic 
} from 'oh-vue-icons/icons/fa'

addIcons(FaCalendarPlus, FaUserPlus, FaFileMedical, FaChevronRight, FaMagic)

defineProps<{
  auth?: Record<string, any>
}>()

interface Cita {
  id: number
  paciente: string
  medico: string
  especialidad: string
  hora: string
  estado: 'Confirmada' | 'Pendiente' | 'En Espera' | 'Cancelada'
}

const proximasCitas: Cita[] = [
  { id: 1, paciente: 'Ana Gómez', medico: 'Dr. Carlos Mendoza', especialidad: 'Cardiología', hora: '09:00 AM', estado: 'Confirmada' },
  { id: 2, paciente: 'Roberto Silva', medico: 'Dra. Elena Ramos', especialidad: 'Pediatría', hora: '10:30 AM', estado: 'Pendiente' },
  { id: 3, paciente: 'Lucía Fernández', medico: 'Dr. Javier López', especialidad: 'Dermatología', hora: '11:15 AM', estado: 'Confirmada' },
  { id: 4, paciente: 'Miguel Torres', medico: 'Dra. Sofía Castro', especialidad: 'Medicina General', hora: '02:00 PM', estado: 'En Espera' },
]

const getEstadoBadgeClass = (estado: Cita['estado']) => {
  switch (estado) {
    case 'Confirmada':
      return 'bg-emerald-100 text-emerald-800'
    case 'Pendiente':
      return 'bg-amber-100 text-amber-800'
    case 'En Espera':
      return 'bg-blue-100 text-blue-800'
    case 'Cancelada':
      return 'bg-rose-100 text-rose-800'
    default:
      return 'bg-gray-100 text-gray-800'
  }
}
</script>

<template>
  <!-- Contenedor Principal -->
  <div class="flex flex-col w-full flex-1 p-6 space-y-6">

    <!-- BANNER DE BIENVENIDA -->
    <div class="w-full relative overflow-hidden rounded-2xl p-6 text-white bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 shadow-sm">
      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
        
        <!-- Lado Izquierdo: Textos -->
        <div class="space-y-2">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-emerald-100 border border-white/20">
            <OhVueIcon name="fa-magic" class="w-3.5 h-3.5 text-amber-300" />
            Módulo de Inteligencia Artificial
          </span>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
            Bienvenido a MEDICITA IA
          </h1>
          <p class="text-emerald-100 text-sm max-w-xl">
            Evalúa tus síntomas con nuestro asistente inteligente para determinar la especialidad adecuada antes de agendar tu cita médica.
          </p>
        </div>

        <!-- Lado Derecho: Botón Único -->
        <div>
          <Link
            href="/evaluacion-ia"
            class="inline-flex items-center gap-2 bg-white text-emerald-900 px-5 py-2.5 rounded-xl font-bold shadow-md hover:bg-emerald-50 transition"
          >
            Evaluar Síntomas
          </Link>
        </div>

      </div>
    </div>

    <!-- TARJETAS DE ESTADÍSTICAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase">Pacientes Registrados</p>
          <p class="text-2xl font-extrabold text-gray-800">128</p>
        </div>
        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
          <OhVueIcon name="fa-user-plus" class="w-5 h-5" />
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase">Citas para hoy</p>
          <p class="text-2xl font-extrabold text-gray-800">14</p>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
          <OhVueIcon name="fa-calendar-plus" class="w-5 h-5" />
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase">Evaluaciones IA</p>
          <p class="text-2xl font-extrabold text-gray-800">45</p>
        </div>
        <div class="p-3 bg-pink-50 text-pink-600 rounded-xl">
          <OhVueIcon name="fa-file-medical" class="w-5 h-5" />
        </div>
      </div>

      <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-bold text-gray-400 uppercase">Médicos Activos</p>
          <p class="text-2xl font-extrabold text-gray-800">12</p>
        </div>
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
          <OhVueIcon name="fa-user-plus" class="w-5 h-5" />
        </div>
      </div>
    </div>

    <!-- SECCIÓN INFERIOR: TABLA Y ACCIONES RÁPIDAS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- TABLA PRÓXIMAS CITAS (2 Columnas) -->
      <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h3 class="text-lg font-bold text-gray-900">Próximas Citas del Día</h3>
            <p class="text-sm text-gray-500">Listado de consultas agendadas para hoy</p>
          </div>
          <Link href="/citas" class="text-sm font-semibold text-emerald-600 hover:underline">
            Ver todas
          </Link>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="text-xs text-gray-400 uppercase border-b border-gray-100">
              <tr>
                <th class="pb-3">Paciente</th>
                <th class="pb-3">Especialidad / Médico</th>
                <th class="pb-3">Hora</th>
                <th class="pb-3">Estado</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="cita in proximasCitas" :key="cita.id" class="hover:bg-gray-50/50">
                <td class="py-3 font-semibold text-gray-800">{{ cita.paciente }}</td>
                <td class="py-3">
                  <div class="font-medium text-gray-800">{{ cita.especialidad }}</div>
                  <div class="text-xs text-gray-400">{{ cita.medico }}</div>
                </td>
                <td class="py-3 text-gray-600">{{ cita.hora }}</td>
                <td class="py-3">
                  <span 
                    class="px-2.5 py-1 text-xs font-semibold rounded-full"
                    :class="getEstadoBadgeClass(cita.estado)"
                  >
                    {{ cita.estado }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- SECCIÓN ACCIONES RÁPIDAS (1 Columna) -->
      <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col space-y-4">
        <h3 class="text-lg font-bold text-gray-900">Acciones Rápidas</h3>

        <!-- Agendar Nueva Cita -->
        <Link 
          href="/citas/crear" 
          class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-100/80 rounded-xl border border-gray-100 transition"
        >
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center text-white shadow-sm">
              <OhVueIcon name="fa-calendar-plus" class="w-6 h-6" />
            </div>
            <div>
              <h4 class="font-bold text-gray-900 group-hover:text-emerald-600 transition">Agendar Nueva Cita</h4>
              <p class="text-sm text-gray-500">Registrar cita médica</p>
            </div>
          </div>
          <OhVueIcon name="fa-chevron-right" class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition" />
        </Link>

        <!-- Nuevo Paciente -->
        <Link 
          href="/pacientes/crear" 
          class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-100/80 rounded-xl border border-gray-100 transition"
        >
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-sm">
              <OhVueIcon name="fa-user-plus" class="w-6 h-6" />
            </div>
            <div>
              <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">Nuevo Paciente</h4>
              <p class="text-sm text-gray-500">Crear expediente</p>
            </div>
          </div>
          <OhVueIcon name="fa-chevron-right" class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition" />
        </Link>

        <!-- Historial Clínico -->
        <Link 
          href="/historial-clinico" 
          class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-100/80 rounded-xl border border-gray-100 transition"
        >
          <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center text-white shadow-sm">
              <OhVueIcon name="fa-file-medical" class="w-6 h-6" />
            </div>
            <div>
              <h4 class="font-bold text-gray-900 group-hover:text-teal-600 transition">Historial Clínico</h4>
              <p class="text-sm text-gray-500">Consultar antecedentes</p>
            </div>
          </div>
          <OhVueIcon name="fa-chevron-right" class="w-4 h-4 text-gray-400 group-hover:translate-x-1 transition" />
        </Link>

      </div>

    </div>

  </div>
</template>