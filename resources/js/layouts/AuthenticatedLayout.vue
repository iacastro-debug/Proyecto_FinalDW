<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>

<template>
  <nav class="space-y-1">
    
    <!-- Dashboard -->
    <Link
      :href="route('dashboard')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('dashboard') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Dashboard
    </Link>

    <!-- Usuarios y Roles -->
    <Link
      :href="route('admin.usuarios.index')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('admin.usuarios.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Usuarios y Roles
    </Link>

    <!-- Especialidades -->
    <Link
      :href="route('admin.especialidades.index')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('admin.especialidades.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Especialidades
    </Link>

    <!-- Médicos -->
    <Link
      :href="route('admin.medicos.index')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('admin.medicos.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Médicos
    </Link>

    <!-- Horarios -->
    <Link
      :href="route('admin.horarios.index')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('admin.horarios.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Horarios
    </Link>

    <!-- Reportes -->
    <Link
      :href="route('admin.reportes.index')"
      class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors"
      :class="route().current('admin.reportes.*') ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-gray-600 hover:bg-gray-50'"
    >
      Reportes
    </Link>

  </nav>
</template>