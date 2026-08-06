<template>
  <div class="p-6 space-y-6">
    <div class="bg-blue-800 text-white p-6 rounded-xl shadow">
      <h1 class="text-2xl font-bold">Panel Médico</h1>
      <p class="text-blue-100">Consulta tu agenda del día, historial clínico de pacientes y evaluaciones de la IA.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Consultas Programadas</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">6</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Paciente Actual</h3>
        <p class="text-lg font-bold text-blue-600 mt-2">Ana Gómez (09:00 AM)</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Evaluaciones IA Recibidas</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">3</p>
      </div>
    </div>
  </div>
</template>