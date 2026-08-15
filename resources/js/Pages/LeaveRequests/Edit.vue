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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Modifier la demande de congé #{{ leaveRequest.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-6 max-w-xl">

                        <!-- Sélection de l'employé (Visible surtout pour l'admin) -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Employé</label>
                            <select v-model="form.employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.first_name }} {{ emp.last_name }}
                                </option>
                            </select>
                            <span v-if="form.errors.employee_id" class="text-red-600 text-xs">{{ form.errors.employee_id }}</span>
                        </div>

                        <!-- Type de congé -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Type de congé</label>
                            <select v-model="form.leave_type_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option v-for="type in leaveTypes" :key="type.id" :value="type.id">
                                    {{ type.name }}
                                </option>
                            </select>
                            <span v-if="form.errors.leave_type_id" class="text-red-600 text-xs">{{ form.errors.leave_type_id }}</span>
                        </div>

                        <!-- Date de début -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Date de début</label>
                            <input type="date" v-model="form.start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            <span v-if="form.errors.start_date" class="text-red-600 text-xs">{{ form.errors.start_date }}</span>
                        </div>

                        <!-- Date de fin -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Date de fin</label>
                            <input type="date" v-model="form.end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                            <span v-if="form.errors.end_date" class="text-red-600 text-xs">{{ form.errors.end_date }}</span>
                        </div>

                        <!-- Motif -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Motif (Optionnel)</label>
                            <textarea v-model="form.reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            <span v-if="form.errors.reason" class="text-red-600 text-xs">{{ form.errors.reason }}</span>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center space-x-4">
                            <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                Mettre à jour
                            </button>
                            <Link :href="route('leave-requests.index')" class="text-gray-600 hover:underline">
                                Annuler
                            </Link>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
