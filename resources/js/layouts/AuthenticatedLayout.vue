<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar / Menú Lateral -->
    <aside class="w-64 bg-white shadow-md flex flex-col justify-between">
      <div class="p-4">
        <!-- Logo / Titulo -->
        <div class="flex items-center gap-2 mb-6">
          <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold">
            M
          </div>
          <span class="font-bold text-gray-800 text-lg">MEDICITA IA</span>
        </div>

        <!-- Menú de Navegación -->
        <nav class="space-y-1">
          <Link :href="route('dashboard')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
            Dashboard
          </Link>

          <!-- RUTAS EXCLUSIVAS DEL ADMINISTRADOR -->
          <template v-if="user?.role === 'Admin'">
            <div class="pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">
              Administración
            </div>
            
            <Link :href="route('usuarios.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
              Gestión Usuarios y Roles
            </Link>

            <Link :href="route('especialidades.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
              Especialidades
            </Link>

            <Link :href="route('medicos.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
              Gestión de Médicos
            </Link>

            <Link :href="route('horarios.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
              Configuración Horarios
            </Link>

            <Link :href="route('reportes.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
              Reportes
            </Link>
          </template>

          <!-- Rutas Comunes -->
          <div class="pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider px-4">
            Gestión Médica
          </div>

          <Link :href="route('citas.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
            Citas
          </Link>

          <Link :href="route('historial.index')" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 rounded-md">
            Historial Clínico
          </Link>
        </nav>
      </div>

      <!-- Perfil de usuario / Logout -->
      <div class="p-4 border-t border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-800">{{ user?.name }}</p>
            <p class="text-xs text-gray-500 capitalize">{{ user?.role }}</p>
          </div>
          <Link :href="route('logout')" method="post" as="button" class="text-sm text-red-600 hover:underline">
            Salir
          </Link>
        </div>
      </div>
    </aside>

    <!-- Contenido Principal de las Vistas -->
    <main class="flex-1 p-8">
      <slot />
    </main>
  </div>
</template>