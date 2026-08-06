<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  pacientes: Array,
  medicos: Array,
  especialidades: Array,
  esPaciente: Boolean,
  pacienteActual: Object,
})

const form = useForm({
  paciente_id: props.esPaciente ? props.pacienteActual?.id : '',
  especialidad_id: '',
  medico_id: '',
  fecha_cita: '',
  hora_cita: '',
  estado: 'pendiente',
  motivo_consulta: '',
  observaciones: '',
})

const submit = () => {
  form.post('/citas')
}
</script>

<template>
  <div class="flex flex-col w-full min-h-screen bg-gray-50 p-6">
    
    <!-- Navbar Superior -->
    <div class="flex items-center justify-between mb-6 bg-white px-6 py-4 rounded-2xl shadow-sm border border-gray-100">
      <h1 class="text-xl font-bold text-gray-900">Nueva Cita</h1>
      <Link href="/citas" class="text-sm font-semibold text-gray-500 hover:text-gray-700">Volver</Link>
    </div>

    <!-- Formulario Principal -->
    <div class="max-w-3xl mx-auto w-full">
      <form @submit.prevent="submit" class="space-y-6">
        
        <!-- Tarjeta 1: Datos de la Cita -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
          <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Datos de la cita</h3>

          <!-- Paciente -->
          <div v-if="esPaciente" class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Paciente <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500">Tú serás el paciente de esta cita</p>
            <input 
              type="text" 
              :value="pacienteActual?.user?.name || 'Tú'" 
              disabled 
              class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-xl text-gray-500 cursor-not-allowed outline-none"
            />
          </div>

          <div v-else class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Paciente <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500">Busca y selecciona el paciente que será atendido</p>
            <select 
              v-model="form.paciente_id" 
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-white"
            >
              <option value="" disabled selected>Seleccionar paciente...</option>
              <option v-for="p in pacientes" :key="p.id" :value="p.id">
                {{ p.user?.name }} - {{ p.numero_documento }}
              </option>
            </select>
          </div>

          <!-- Especialidad -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Especialidad <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500">Selecciona la especialidad para la consulta</p>
            <select 
              v-model="form.especialidad_id" 
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-white"
            >
              <option value="" disabled selected>Seleccionar especialidad...</option>
              <option v-for="e in especialidades" :key="e.id" :value="e.id">
                {{ e.nombre }}
              </option>
            </select>
          </div>

          <!-- Médico -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Médico <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500">Selecciona el médico que atenderá la cita</p>
            <select 
              v-model="form.medico_id" 
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-white"
            >
              <option value="" disabled selected>Seleccionar médico...</option>
              <option v-for="m in medicos" :key="m.id" :value="m.id">
                {{ m.user?.name }} - {{ m.especialidad?.nombre || '' }}
              </option>
            </select>
          </div>

          <!-- Fecha y Hora -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700">Fecha de la cita <span class="text-red-500">*</span></label>
              <p class="text-sm text-gray-500">Selecciona el día de atención</p>
              <input 
                type="date" 
                v-model="form.fecha_cita" 
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
              />
            </div>

            <div class="space-y-1">
              <label class="block text-sm font-medium text-gray-700">Hora de la cita <span class="text-red-500">*</span></label>
              <p class="text-sm text-gray-500">Selecciona la hora (24h)</p>
              <input 
                type="time" 
                v-model="form.hora_cita" 
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
              />
            </div>
          </div>

          <!-- Estado inicial -->
          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Estado inicial</label>
            <p class="text-sm text-gray-500">La cita se crea como 'pendiente' por defecto</p>
            <select 
              v-model="form.estado" 
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition bg-white"
            >
              <option value="pendiente">Pendiente</option>
              <option value="confirmada">Confirmada</option>
            </select>
          </div>
        </div>

        <!-- Tarjeta 2: Detalles de la consulta -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-4">
          <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-3">Detalles de la consulta</h3>

          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Motivo de la consulta <span class="text-red-500">*</span></label>
            <p class="text-sm text-gray-500">Describe brevemente el motivo de la cita</p>
            <textarea 
              v-model="form.motivo_consulta" 
              rows="3" 
              placeholder="Ej: Control de presión arterial, dolor de cabeza..."
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
            ></textarea>
          </div>

          <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
            <p class="text-sm text-gray-500">Información adicional relevante</p>
            <textarea 
              v-model="form.observaciones" 
              rows="2" 
              placeholder="Ej: Paciente requiere atención preferencial..."
              class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
            ></textarea>
          </div>
        </div>

        <!-- Botones de Acción -->
        <div class="flex gap-3 justify-end">
          <Link 
            href="/citas" 
            class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition"
          >
            Cancelar
          </Link>
          <button 
            type="submit" 
            :disabled="form.processing"
            class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition disabled:opacity-50"
          >
            Guardar cita
          </button>
        </div>

      </form>
    </div>

  </div>
</template>