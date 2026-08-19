<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    leaveRequest: Object,
    employees: Array,
    leaveTypes: Array,
});

// Initialisation du formulaire avec les données existantes de la demande
const form = useForm({
    employee_id: props.leaveRequest.employee_id,
    leave_type_id: props.leaveRequest.leave_type_id,
    start_date: props.leaveRequest.start_date,
    end_date: props.leaveRequest.end_date,
    reason: props.leaveRequest.reason || '',
});

const submit = () => {
    form.put(route('leave-requests.update', props.leaveRequest.id));
};
</script>

<template>
    <Head title="Modifier la demande de congé" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Modifier la demande de congé</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Mettez à jour les informations de la requête #{{ leaveRequest.id }}.</p>
                </div>
                <Link :href="route('leave-requests.index')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Retour à la liste</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">

                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-bold text-lg text-gray-900 tracking-tight">Détails de la requête</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Modifiez les champs nécessaires ci-dessous.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">

                        <!-- Sélection du collaborateur (Visible surtout pour l'admin) -->
                        <div>
                            <label class="block font-medium text-xs text-gray-700 uppercase tracking-wider mb-1.5">Collaborateur</label>
                            <select v-model="form.employee_id" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all">
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.first_name }} {{ emp.last_name }}
                                </option>
                            </select>
                            <span v-if="form.errors.employee_id" class="text-rose-600 text-xs mt-1.5 block font-medium">{{ form.errors.employee_id }}</span>
                        </div>

                        <!-- Type de congé -->
                        <div>
                            <label class="block font-medium text-xs text-gray-700 uppercase tracking-wider mb-1.5">Type de congé</label>
                            <select v-model="form.leave_type_id" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all">
                                <option v-for="type in leaveTypes" :key="type.id" :value="type.id">
                                    {{ type.name }}
                                </option>
                            </select>
                            <span v-if="form.errors.leave_type_id" class="text-rose-600 text-xs mt-1.5 block font-medium">{{ form.errors.leave_type_id }}</span>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-xs text-gray-700 uppercase tracking-wider mb-1.5">Date de début</label>
                                <input type="date" v-model="form.start_date" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" />
                                <span v-if="form.errors.start_date" class="text-rose-600 text-xs mt-1.5 block font-medium">{{ form.errors.start_date }}</span>
                            </div>

                            <div>
                                <label class="block font-medium text-xs text-gray-700 uppercase tracking-wider mb-1.5">Date de fin</label>
                                <input type="date" v-model="form.end_date" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" />
                                <span v-if="form.errors.end_date" class="text-rose-600 text-xs mt-1.5 block font-medium">{{ form.errors.end_date }}</span>
                            </div>
                        </div>

                        <!-- Motif -->
                        <div>
                            <label class="block font-medium text-xs text-gray-700 uppercase tracking-wider mb-1.5">Motif (Optionnel)</label>
                            <textarea v-model="form.reason" rows="3" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3.5 transition-all"></textarea>
                            <span v-if="form.errors.reason" class="text-rose-600 text-xs mt-1.5 block font-medium">{{ form.errors.reason }}</span>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <Link :href="route('leave-requests.index')" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                                Annuler
                            </Link>
                            <button type="submit" :disabled="form.processing" :class="{ 'opacity-25': form.processing }" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150">
                                Mettre à jour
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
