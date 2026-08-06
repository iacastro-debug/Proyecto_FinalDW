<template>
  <div class="p-6 space-y-6">
    <div class="bg-emerald-800 text-white p-6 rounded-xl shadow flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold">Bienvenido a tu Portal de Salud</h1>
        <p class="text-emerald-100">Evalúa tus síntomas con Inteligencia Artificial o consulta el estado de tus citas.</p>
      </div>
      <button class="bg-white text-emerald-800 px-4 py-2 rounded-lg font-semibold hover:bg-emerald-50">
        Evaluar Síntomas con IA
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Próxima Cita</h3>
        <p class="text-lg font-bold text-emerald-700 mt-2">Cardiología - Dr. Carlos Mendoza</p>
        <p class="text-sm text-gray-500">Hoy a las 09:00 AM</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Diagnósticos de IA Recientes</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">2 completados</p>
      </div>
    </div>
  </div>
</template>