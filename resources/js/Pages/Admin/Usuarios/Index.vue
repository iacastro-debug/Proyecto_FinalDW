<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';

defineProps({
    users: Array
});

const isModalOpen = ref(false);
const isEditing = ref(false);
const editingUserId = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'paciente'
});

const openModal = () => {
    isEditing.value = false;
    editingUserId.value = null;
    form.reset();
    form.clearErrors();
    isModalOpen.value = true;
};

const openEditModal = (user) => {
    isEditing.value = true;
    editingUserId.value = user.id;
    form.clearErrors();
    form.name = user.name;
    form.email = user.email;
    form.password = ''; // Opcional al editar
    form.role = user.role;
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    isEditing.value = false;
    editingUserId.value = null;
    form.reset();
    form.clearErrors();
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.usuarios.update', editingUserId.value), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('admin.usuarios.store'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        });
    }
};

const deleteUser = (user) => {
    if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${user.name}"?`)) {
        router.delete(route('admin.usuarios.destroy', user.id));
    }
};

const getInitials = (name) => {
    if (!name) return 'U';
    return name
        .split(' ')
        .map(n => n[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();
};
</script>

<template>
    <Head title="Gestión de Usuarios" />

    <div class="p-8 bg-slate-50 min-h-screen">
        <!-- Header -->
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Gestión de Usuarios</h1>
                <p class="text-sm text-slate-500 mt-1">Administra accesos, roles y permisos de los miembros de la plataforma.</p>
            </div>
            
            <button 
                @click="openModal" 
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-600/20 transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Nuevo Usuario</span>
            </button>
        </div>
        
        <!-- Tabla -->
        <div class="max-w-7xl mx-auto bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-4 px-6">Usuario</th>
                            <th class="py-4 px-6">Identificador (ID)</th>
                            <th class="py-4 px-6">Correo Electrónico</th>
                            <th class="py-4 px-6 text-center">Rol Asignado</th>
                            <th class="py-4 px-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50/60 transition-colors group">
                            <!-- Avatar + Nombre -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center shrink-0 border border-emerald-200/60">
                                        {{ getInitials(user.name) }}
                                    </div>
                                    <span class="font-semibold text-slate-800 group-hover:text-emerald-700 transition-colors">
                                        {{ user.name }}
                                    </span>
                                </div>
                            </td>

                            <!-- ID -->
                            <td class="py-4 px-6">
                                <span class="font-mono text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-md">
                                    {{ user.id.length > 18 ? user.id.substring(0, 18) + '...' : user.id }}
                                </span>
                            </td>

                            <!-- Email -->
                            <td class="py-4 px-6 text-slate-600 font-medium">
                                {{ user.email }}
                            </td>

                            <!-- Rol -->
                            <td class="py-4 px-6 text-center">
                                <span :class="{
                                    'bg-purple-50 text-purple-700 border-purple-200': user.role === 'administrador',
                                    'bg-sky-50 text-sky-700 border-sky-200': user.role === 'medico',
                                    'bg-amber-50 text-amber-700 border-amber-200': user.role === 'recepcionista' || user.role === 'recepcinista',
                                    'bg-emerald-50 text-emerald-700 border-emerald-200': user.role === 'paciente',
                                }" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border capitalize">
                                    <span :class="{
                                        'bg-purple-500': user.role === 'administrador',
                                        'bg-sky-500': user.role === 'medico',
                                        'bg-amber-500': user.role === 'recepcionista' || user.role === 'recepcinista',
                                        'bg-emerald-500': user.role === 'paciente',
                                    }" class="w-1.5 h-1.5 rounded-full"></span>
                                    {{ user.role }}
                                </span>
                            </td>

                            <!-- Acciones -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Editar -->
                                    <button 
                                        @click="openEditModal(user)" 
                                        title="Editar Usuario"
                                        class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <!-- Eliminar -->
                                    <button 
                                        @click="deleteUser(user)" 
                                        title="Eliminar Usuario"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4 z-50 transition-all">
            <div class="bg-white rounded-2xl shadow-2xl border border-slate-100 max-w-lg w-full overflow-hidden transform transition-all">
                
                <div class="px-6 py-5 bg-slate-50/50 border-b border-slate-100 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            {{ isEditing ? 'Editar Usuario' : 'Registrar Nuevo Usuario' }}
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            {{ isEditing ? 'Modifica los datos del usuario seleccionado.' : 'Llena el formulario para crear un nuevo acceso.' }}
                        </p>
                    </div>
                    <button @click="closeModal" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form @submit.prevent="submit" class="p-6 space-y-4" autocomplete="off">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Nombre Completo</label>
                        <input 
                            v-model="form.name" 
                            type="text" 
                            placeholder="Ej. María Delgado"
                            required 
                            class="w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all placeholder:text-slate-300 py-2.5" 
                        />
                        <span v-if="form.errors.name" class="text-red-500 text-xs mt-1 block">{{ form.errors.name }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Correo Electrónico</label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            placeholder="correo@ejemplo.com"
                            autocomplete="off"
                            required 
                            class="w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all placeholder:text-slate-300 py-2.5" 
                        />
                        <span v-if="form.errors.email" class="text-red-500 text-xs mt-1 block">{{ form.errors.email }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Contraseña {{ isEditing ? '(Déjala en blanco para no cambiarla)' : '' }}
                        </label>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            placeholder="••••••••"
                            autocomplete="new-password"
                            :required="!isEditing" 
                            class="w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all placeholder:text-slate-300 py-2.5" 
                        />
                        <span v-if="form.errors.password" class="text-red-500 text-xs mt-1 block">{{ form.errors.password }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Rol de Usuario</label>
                        <select 
                            v-model="form.role" 
                            class="w-full rounded-xl border-slate-200 text-sm focus:border-emerald-500 focus:ring-emerald-500 transition-all py-2.5 bg-white capitalize">
                            <option value="administrador">Administrador</option>
                            <option value="recepcionista">Recepcionista</option>
                            <option value="medico">Médico</option>
                            <option value="paciente">Paciente</option>
                        </select>
                        <span v-if="form.errors.role" class="text-red-500 text-xs mt-1 block">{{ form.errors.role }}</span>
                    </div>

                    <div class="flex justify-end items-center gap-3 pt-4 border-t border-slate-100 mt-6">
                        <button 
                            type="button" 
                            @click="closeModal" 
                            class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            :disabled="form.processing" 
                            class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-xl shadow-md shadow-emerald-600/20 transition-all disabled:opacity-50">
                            {{ isEditing ? 'Actualizar Usuario' : 'Guardar Usuario' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>