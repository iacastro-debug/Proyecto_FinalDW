<script setup>
import { ref, reactive } from 'vue'

const cargando = ref(false)
const resultado = ref(null)

const form = reactive({
  paciente: '',
  edad: 23,
  genero: 'Masculino',
  sintomas: '',
  duracion: '',
  nivelDolor: 'Bajo',
  fiebre: 'No',
  respiracion: 'No',
  pecho: 'No',
  antecedentes: ''
})

const generarEvaluacion = () => {
  // 1. Activar estado de carga
  cargando.value = true
  resultado.value = null

  // 2. Simular respuesta de la IA
  setTimeout(() => {
    cargando.value = false
    resultado.value = {
      especialidad: form.sintomas.toLowerCase().includes('cabeza') ? 'Neurología / Medicina General' : 'Medicina General',
      prioridad: (form.pecho === 'Si' || form.respiracion === 'Si') ? 'Alta' : 'Media',
      justificacion: `Evaluación simulada para el paciente ${form.paciente || 'Registrado'} (${form.edad} años). Presenta: "${form.sintomas || 'Sin síntomas especificados'}". Se sugiere consulta médica para valoración.`
    }
  }, 1000)
}
</script>

<template>
  <div class="w-full p-6 space-y-6">
    
    <!-- ENCABEZADO -->
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-slate-800">Evaluación de Síntomas con IA</h1>
        <p class="text-slate-500 text-sm">Asistente inteligente para la orientación de especialidad médica</p>
      </div>
      <a href="/evaluaciones-ia" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition-all">
        ← Volver a la Lista
      </a>
    </div>

    <!-- ADVERTENCIA OBLIGATORIA -->
    <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-2xl text-amber-900 text-sm flex items-start space-x-3 shadow-sm">
      <span class="text-xl">⚠️</span>
      <div>
        <strong class="font-bold">Aviso Importante:</strong>
        <p class="mt-0.5 text-amber-800">
          La sugerencia generada por Inteligencia Artificial no representa un diagnóstico médico ni reemplaza la atención de un profesional de salud. Ante síntomas graves, acuda a emergencia.
        </p>
      </div>
    </div>

    <!-- FORMULARIO PRINCIPAL -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-8">
      
      <!-- SECCIÓN 1: DATOS DEL PACIENTE -->
      <div>
        <h2 class="text-lg font-bold text-indigo-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <span>👤</span> Sección 1: Datos del Paciente
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nombre del Paciente *</label>
            <input 
              v-model="form.paciente" 
              type="text" 
              placeholder="Ingrese el nombre completo" 
              class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" 
            />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Edad *</label>
            <input v-model="form.edad" type="number" placeholder="Ej. 23" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Género</label>
            <select v-model="form.genero" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
              <option>Masculino</option>
              <option>Femenino</option>
              <option>Otro</option>
            </select>
          </div>
        </div>
      </div>

      <!-- SECCIÓN 2: SÍNTOMAS -->
      <div>
        <h2 class="text-lg font-bold text-indigo-900 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <span>🩺</span> Sección 2: Detalle de Síntomas
        </h2>
        
        <div class="space-y-4">
          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Síntomas Principales *</label>
            <textarea v-model="form.sintomas" rows="3" placeholder="Ej. Dolor de cabeza intenso, fotofobia y mareo" class="w-full border border-slate-200 rounded-xl p-3 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Duración de Síntomas</label>
              <input v-model="form.duracion" type="text" placeholder="Ej. 2 días" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nivel de Dolor</label>
              <select v-model="form.nivelDolor" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                <option>Bajo</option>
                <option>Medio</option>
                <option>Alto</option>
              </select>
            </div>
          </div>

          <!-- Preguntas clave -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span class="block text-xs font-bold text-slate-600 mb-2">¿Tiene Fiebre?</span>
              <div class="flex gap-4 text-sm font-medium">
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.fiebre" value="Si" /> Sí</label>
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.fiebre" value="No" /> No</label>
              </div>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span class="block text-xs font-bold text-slate-600 mb-2">¿Dificultad para respirar?</span>
              <div class="flex gap-4 text-sm font-medium">
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.respiracion" value="Si" /> Sí</label>
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.respiracion" value="No" /> No</label>
              </div>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
              <span class="block text-xs font-bold text-slate-600 mb-2">¿Dolor en el Pecho?</span>
              <div class="flex gap-4 text-sm font-medium">
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.pecho" value="Si" /> Sí</label>
                <label class="flex items-center gap-1 cursor-pointer"><input type="radio" v-model="form.pecho" value="No" /> No</label>
              </div>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Antecedentes Relevantes / Observaciones</label>
            <input v-model="form.antecedentes" type="text" placeholder="Ninguna" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-slate-800 text-sm focus:ring-2 focus:ring-indigo-500 outline-none" />
          </div>
        </div>
      </div>

      <!-- BOTÓN GENERAR CON EVENTO @CLICK -->
      <div class="flex justify-end pt-4 border-t border-slate-100">
        <button 
          type="button" 
          @click="generarEvaluacion"
          :disabled="cargando"
          class="px-6 py-3 bg-gradient-to-r from-teal-600 to-indigo-600 hover:from-teal-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all flex items-center gap-2 disabled:opacity-50 cursor-pointer"
        >
          <span v-if="!cargando">✨ Generar Orientación con IA</span>
          <span v-else class="flex items-center gap-2">🔄 Procesando evaluación...</span>
        </button>
      </div>

    </div>

    <!-- RESULTADO GENERADO POR LA IA -->
    <div v-if="resultado" class="p-6 bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-2xl shadow-xl space-y-4 transition-all">
      <div class="flex items-center justify-between border-b border-indigo-700/50 pb-3">
        <div class="flex items-center gap-2">
          <span class="text-2xl">🤖</span>
          <h3 class="text-xl font-bold">Resultado de la Orientación IA</h3>
        </div>
        <span class="px-3 py-1 bg-teal-500/20 text-teal-300 border border-teal-500/30 text-xs font-bold rounded-full uppercase">
          Especialidad Recomendada
        </span>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 bg-white/5 rounded-xl border border-white/10">
          <span class="text-xs text-indigo-200 uppercase font-bold block mb-1">Especialidad Sugerida</span>
          <p class="text-2xl font-extrabold text-teal-300">{{ resultado.especialidad }}</p>
        </div>
        <div class="p-4 bg-white/5 rounded-xl border border-white/10">
          <span class="text-xs text-indigo-200 uppercase font-bold block mb-1">Nivel de Prioridad</span>
          <p class="text-xl font-bold" :class="resultado.prioridad === 'Alta' ? 'text-amber-400' : 'text-emerald-400'">
            {{ resultado.prioridad }}
          </p>
        </div>
      </div>

      <div class="p-4 bg-white/5 rounded-xl border border-white/10">
        <span class="text-xs text-indigo-200 uppercase font-bold block mb-1">Justificación del Análisis</span>
        <p class="text-sm text-slate-200 leading-relaxed">{{ resultado.justificacion }}</p>
      </div>

      <div class="flex justify-end pt-2">
        <a href="/citas/nueva" class="px-5 py-2.5 bg-teal-500 hover:bg-teal-600 font-bold text-white text-sm rounded-xl transition-all shadow">
          📅 Agendar Cita con esta Especialidad
        </a>
      </div>
    </div>

  </div>
</template>