<script setup lang="ts">
import { ref, shallowRef, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { sub } from 'date-fns'
import type { DropdownMenuItem } from '@nuxt/ui'
import type { Period, Range } from '../types'
import { useDashboard } from '../composables/useDashboard'
import HomeDateRangePicker from '../components/home/HomeDateRangePicker.vue'
import HomePeriodSelect from '../components/home/HomePeriodSelect.vue'
import HomeStats from '../components/home/HomeStats.vue'
import HomeChart from '../components/home/HomeChart.client.vue'
import HomeSales from '../components/home/HomeSales.vue'

const range = shallowRef<Range>({
  start: sub(new Date(), { days: 14 }),
  end: new Date()
})
const period = ref<Period>('daily')

const role = computed(() => (usePage().props.auth?.user?.role as string) ?? '')
const puedeEvaluar = computed(() => role.value === 'admin' || role.value === 'medico')
const puedeAgendarCita = computed(() => role.value === 'admin' || role.value === 'paciente')
const puedeRegistrarPaciente = computed(() => role.value === 'admin')
</script>

<template>
  <div class="p-6 space-y-6">
    
    <!-- 1. BANNER PRINCIPAL (Módulo IA) -->
    <div class="w-full p-8 bg-gradient-to-r from-teal-600 via-indigo-600 to-indigo-800 text-white rounded-2xl shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
      <div class="space-y-2">
        <div class="inline-flex items-center space-x-2 bg-white/20 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-md">
          ✨ Módulo de Inteligencia Artificial
        </div>
        <h1 class="text-3xl font-extrabold tracking-tight">Bienvenido a MEDICITA IA</h1>
        <p class="text-teal-100 text-sm max-w-xl">
          Evalúa tus síntomas con nuestro asistente inteligente para determinar la especialidad adecuada antes de agendar tu cita.
        </p>
      </div>
      <a 
        v-if="puedeEvaluar"
        href="/evaluaciones-ia/crear" 
        class="shrink-0 px-6 py-3.5 bg-white text-indigo-700 hover:bg-teal-50 font-bold rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 text-center"
      >
        🤖 Evaluar Síntomas
      </a>
    </div>

    <!-- 2. TARJETAS DE MÉTRICAS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
      <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pacientes Registrados</span>
          <div class="p-2.5 bg-teal-50 text-teal-600 rounded-xl">👥</div>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-3xl font-extrabold text-slate-800">128</span>
          <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">+12%</span>
        </div>
      </div>

      <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Citas para Hoy</span>
          <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">📅</div>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-3xl font-extrabold text-slate-800">14</span>
          <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">8 pendientes</span>
        </div>
      </div>

      <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Evaluaciones IA</span>
          <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl">🧬</div>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-3xl font-extrabold text-slate-800">45</span>
          <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md">Realizadas</span>
        </div>
      </div>

      <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
          <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Médicos Activos</span>
          <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">🩺</div>
        </div>
        <div class="mt-4 flex items-baseline justify-between">
          <span class="text-3xl font-extrabold text-slate-800">12</span>
          <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">6 áreas</span>
        </div>
      </div>
    </div>

    <!-- 3. ACCESOS RÁPIDOS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      <a v-if="puedeAgendarCita" href="/citas/create" class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-teal-500 hover:shadow-md transition-all flex items-center space-x-4">
        <div class="p-3 bg-teal-500 text-white rounded-xl">📅</div>
        <div>
          <h4 class="font-bold text-slate-800">Agendar Cita Médica</h4>
          <p class="text-xs text-slate-400">Crear cita para un paciente</p>
        </div>
      </a>

      <a v-if="puedeRegistrarPaciente" href="/pacientes/create" class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-indigo-500 hover:shadow-md transition-all flex items-center space-x-4">
        <div class="p-3 bg-indigo-500 text-white rounded-xl">👤</div>
        <div>
          <h4 class="font-bold text-slate-800">Registrar Paciente</h4>
          <p class="text-xs text-slate-400">Nuevo historial en el sistema</p>
        </div>
      </a>

      <a href="/historiales-clinicos" class="p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:border-purple-500 hover:shadow-md transition-all flex items-center space-x-4">
        <div class="p-3 bg-purple-500 text-white rounded-xl">📊</div>
        <div>
          <h4 class="font-bold text-slate-800">Historial Clínico</h4>
          <p class="text-xs text-slate-400">Informes de consulta y recetas</p>
        </div>
      </a>
    </div>

    <!-- 4. TABLA DE PRÓXIMAS CITAS -->
    <div class="p-6 bg-white border border-slate-100 rounded-2xl shadow-sm">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-slate-800 text-lg">Próximas Citas Programadas</h3>
        <span class="text-xs bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-semibold">Hoy</span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
          <thead class="bg-slate-50 text-slate-400 uppercase text-xs">
            <tr>
              <th class="p-3">Paciente</th>
              <th class="p-3">Especialidad</th>
              <th class="p-3">Médico</th>
              <th class="p-3">Hora</th>
              <th class="p-3">Estado</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-slate-600">
            <tr>
              <td class="p-3 font-medium text-slate-800">Carlos Mendoza</td>
              <td class="p-3"><span class="bg-teal-50 text-teal-700 px-2 py-0.5 rounded text-xs">Medicina General</span></td>
              <td class="p-3">Dr. Ricardo Gómez</td>
              <td class="p-3">10:30 AM</td>
              <td class="p-3"><span class="bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full text-xs font-semibold">Pendiente</span></td>
            </tr>
            <tr>
              <td class="p-3 font-medium text-slate-800">Ana Lucía Torres</td>
              <td class="p-3"><span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs">Pediatría</span></td>
              <td class="p-3">Dra. Sofia López</td>
              <td class="p-3">11:15 AM</td>
              <td class="p-3"><span class="bg-emerald-100 text-emerald-700 px-2.5 py-1 rounded-full text-xs font-semibold">Atendida</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</template>