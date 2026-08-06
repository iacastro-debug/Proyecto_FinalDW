<script setup>
import { useForm } from '@inertiajs/vue3';

defineOptions({
  layout: null
});

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const submit = () => {
  form.post('/register', {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};

</script>
<template>
  <div class="bg-slate-900 min-h-screen font-sans relative overflow-y-auto p-4 sm:p-6 lg:p-12">
    
    <!-- Fondo Abstracto Fijo -->
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-teal-900 via-cyan-900 to-slate-950 pointer-events-none">
      <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
      <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-cyan-500/20 rounded-full blur-3xl"></div>
      <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-blue-600/20 rounded-full blur-3xl"></div>
      
      <div class="absolute right-10 bottom-10 opacity-10 text-cyan-300">
        <i class="fa-solid fa-heart-pulse text-[350px]"></i>
      </div>
    </div>

    <!-- Estructura Grid -->
    <div class="relative z-10 min-h-[calc(100vh-3rem)] flex items-center max-w-7xl mx-auto">
      <div class="w-full grid grid-cols-1 lg:grid-cols-12">
        
        <div class="lg:col-span-7 xl:col-span-6 bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/20 p-6 sm:p-8 md:p-10 my-auto">
          
          <!-- Encabezado -->
          <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <div class="w-12 h-12 sm:w-14 sm:h-14 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center text-xl sm:text-2xl shadow-inner shrink-0">
              <i class="fa-solid fa-user-doctor"></i>
            </div>
            <div>
              <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Crear Cuenta</h1>
              <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Completa el formulario para registrarte en el sistema y vincular tus notificaciones a tu perfil médico.
              </p>
            </div>
          </div>

          <!-- Formulario -->
          <form @submit.prevent="submit" class="space-y-4">

            <!-- Nombre Completo -->
            <div>
              <label for="name" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
                Nombre completo <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                  <i class="fa-regular fa-user"></i>
                </span>
                <input 
                  v-model="form.name"
                  type="text" 
                  id="name" 
                  required 
                  autofocus
                  class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
                  placeholder="Juan Pérez"
                />
              </div>
              <span v-if="form.errors?.name" class="text-xs text-red-500 mt-1 block">{{ form.errors.name }}</span>
            </div>

            <!-- Correo Electrónico (Placeholder Limpio) -->
            <div>
              <label for="email" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
                Correo electrónico <span class="text-red-500">*</span>
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                  <i class="fa-regular fa-envelope"></i>
                </span>
                <input 
                  v-model="form.email"
                  type="email" 
                  id="email" 
                  autocomplete="off"
                  required
                  class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
                  placeholder=""
                />
              </div>
              <span v-if="form.errors?.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
            </div>

            <!-- Contraseñas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="password" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
                  Contraseña <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fa-solid fa-lock"></i>
                  </span>
                  <input 
                    v-model="form.password"
                    type="password" 
                    id="password" 
                    required
                    class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
                    placeholder="••••••••"
                  />
                </div>
              </div>

              <div>
                <label for="password_confirmation" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
                  Confirmar contraseña <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fa-solid fa-shield-halved"></i>
                  </span>
                  <input 
                    v-model="form.password_confirmation"
                    type="password" 
                    id="password_confirmation" 
                    required
                    class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
                    placeholder="••••••••"
                  />
                </div>
              </div>
            </div>
            <span v-if="form.errors?.password" class="text-xs text-red-500 mt-1 block">{{ form.errors.password }}</span>

            <!-- Botón de Registro -->
            <button 
              type="submit" 
              :disabled="form.processing"
              class="w-full py-3.5 bg-teal-500 hover:bg-teal-600 disabled:opacity-50 text-white font-bold rounded-xl shadow-lg shadow-teal-500/30 transition duration-200 transform hover:-translate-y-0.5 mt-2 text-sm sm:text-base"
            >
              Registrarse
            </button>

            <!-- Redirección -->
            <p class="text-center text-xs sm:text-sm text-slate-500 pt-2">
              ¿Ya tienes una cuenta? 
              <a :href="route('login')" class="font-bold text-teal-600 hover:text-teal-700 hover:underline">
                Inicia sesión
              </a>
            </p>
          </form>

        </div>
      </div>
    </div>

  </div>
</template>