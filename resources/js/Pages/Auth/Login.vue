<script setup>
import { useForm, Link } from '@inertiajs/vue3';

defineOptions({
  layout: null
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div class="min-h-screen bg-slate-900 flex flex-col justify-center items-center p-4 sm:p-6 relative overflow-hidden">
    
    <!-- Fondo Visual Temático -->
    <div class="absolute inset-0 opacity-10">
      <svg class="absolute w-2/3 h-2/3 -top-10 -left-10 text-teal-600 rotate-12" fill="currentColor" viewBox="0 0 24 24">
        <path d="M19.5 3h-2.25V1.5a.75.75 0 0 0-1.5 0V3H8.25V1.5a.75.75 0 0 0-1.5 0V3H4.5A2.25 2.25 0 0 0 2.25 5.25v14.25A2.25 2.25 0 0 0 4.5 21.75h15a2.25 2.25 0 0 0 2.25-2.25V5.25A2.25 2.25 0 0 0 19.5 3zM4.5 4.5h2.25V6a.75.75 0 0 0 1.5 0V4.5h7.5V6a.75.75 0 0 0 1.5 0V4.5h2.25c.414 0 .75.336.75.75v3h-15v-3c0-.414.336-.75.75-.75zm15 15.75h-15a.75.75 0 0 1-.75-.75v-9h15v9a.75.75 0 0 1-.75.75zm-6-6h3a.75.75 0 0 0 0-1.5h-3a.75.75 0 0 0 0 1.5zm0 3h3a.75.75 0 0 0 0-1.5h-3a.75.75 0 0 0 0 1.5zm-6-3h3a.75.75 0 0 0 0-1.5h-3a.75.75 0 0 0 0 1.5zm0 3h3a.75.75 0 0 0 0-1.5h-3a.75.75 0 0 0 0 1.5z"></path>
      </svg>
    </div>

    <!-- Fondo de superposición degradado -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-transparent to-slate-900 opacity-90"></div>
    
    <!-- Elementos decorativos animados en el fondo -->
    <div class="absolute w-40 h-40 bg-teal-600 rounded-full blur-[100px] top-1/4 left-1/4 opacity-30 animate-pulse"></div>
    <div class="absolute w-40 h-40 bg-slate-700 rounded-full blur-[100px] bottom-1/4 right-1/4 opacity-30"></div>

    <!-- Tarjeta Principal (con blur para efecto de cristal) -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-6 sm:p-8 space-y-6 relative z-10">
      
      <!-- Encabezado con Icono -->
      <div class="flex items-start gap-4 border-b border-slate-100 pb-5">
        <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center text-xl shrink-0">
          <i class="fa-solid fa-notes-medical"></i>
        </div>
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Iniciar Sesión</h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ingresa tus credenciales para gestionar tus citas.</p>
        </div>
      </div>

      <!-- Formulario (mantiene la estructura y clases originales) -->
      <form @submit.prevent="submit" class="space-y-4" autocomplete="off">
        
        <!-- Correo Electrónico -->
        <div>
          <label for="login_email" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
            Correo electrónico <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
              <i class="fa-regular fa-envelope"></i>
            </span>
            <input 
              v-model="form.email"
              type="text" 
              id="login_email"
              name="user_login_email"
              autocomplete="new-password"
              required
              class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
              placeholder="tu@email.com"
            />
          </div>
          <span v-if="form.errors?.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
        </div>

        <!-- Contraseña -->
        <div>
          <label for="login_password" class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1">
            Contraseña <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
              <i class="fa-solid fa-lock"></i>
            </span>
            <input 
              v-model="form.password"
              type="password" 
              id="login_password"
              required
              class="w-full pl-11 pr-4 py-2.5 sm:py-3 bg-slate-50 rounded-xl border border-slate-200 text-slate-800 text-sm placeholder-slate-400 focus:outline-none focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-500/10 transition duration-200"
              placeholder="••••••••"
            />
          </div>
          <span v-if="form.errors?.password" class="text-xs text-red-500 mt-1 block">{{ form.errors.password }}</span>
        </div>

        <!-- Opción Recordarme -->
        <div class="flex items-center justify-between pt-1">
          <label class="flex items-center space-x-2 cursor-pointer">
            <input 
              v-model="form.remember" 
              type="checkbox" 
              class="w-4 h-4 text-teal-600 rounded border-slate-300 focus:ring-teal-500 transition duration-150"
            />
            <span class="text-xs sm:text-sm text-slate-600">Recordarme</span>
          </label>
        </div>

        <!-- Botón Iniciar Sesión (mantiene clases y estilos originales) -->
        <button 
          type="submit" 
          :disabled="form.processing"
          class="w-full py-3.5 bg-teal-500 hover:bg-teal-600 active:bg-teal-700 disabled:opacity-50 text-white font-bold rounded-xl shadow-lg shadow-teal-500/30 transition duration-200 mt-2"
        >
          <span v-if="form.processing">Ingresando...</span>
          <span v-else>Iniciar Sesión</span>
        </button>

      </form>

      <!-- Pie de tarjeta -->
      <div class="text-center text-xs sm:text-sm text-slate-500 pt-2 border-t border-slate-100">
        ¿No tienes una cuenta? 
        <Link :href="route('register')" class="text-teal-600 font-semibold hover:underline">
          Regístrate
        </Link>
      </div>

    </div>
  </div>
</template>