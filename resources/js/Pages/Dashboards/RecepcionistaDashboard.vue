<template>
  <div class="p-6 space-y-6">
    <div class="bg-teal-700 text-white p-6 rounded-xl shadow">
      <h1 class="text-2xl font-bold">Panel de Recepción y Atención</h1>
      <p class="text-teal-100">Gestión de citas del día, registro de llegada de pacientes y asignación de turnos.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Citas por Confirmar</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">8</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Pacientes en Espera</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">5</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow border border-gray-100">
        <h3 class="text-gray-500 text-sm font-semibold">Citas Finalizadas Hoy</h3>
        <p class="text-3xl font-bold text-gray-800 mt-2">12</p>
      </div>
    </div>
  </div>
</template>