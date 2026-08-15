<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    leaveRequests: Array,
});

// Récupération de l'utilisateur connecté via Inertia page props
const page = usePage();
const userRole = computed(() => page.props.auth.user.role);

const actionForm = useForm({});

const approveRequest = (id) => {
    actionForm.patch(route('leave-requests.approve', id));
};

const rejectRequest = (id) => {
    actionForm.patch(route('leave-requests.reject', id));
};
</script>

<template>
    <Head title="Gestion des Congés" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Suivi des Demandes de Congés</h2>
                <Link :href="route('leave-requests.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    + Nouvelle demande
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <!-- Tableau des demandes -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Du / Au</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <!-- Colonne Actions RH visible uniquement pour les administrateurs -->
                                <th v-if="userRole === 'admin'" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions RH</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="req in leaveRequests" :key="req.id">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ req.employee ? req.employee.first_name + ' ' + req.employee.last_name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ req.start_date }} au {{ req.end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                    {{ req.days_count }} j
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': req.status === 'en_attente',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': req.status === 'approuve' || req.status === 'approuvé',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': req.status === 'refuse' || req.status === 'rejeté'
                                    }">
                                        {{ req.status }}
                                    </span>
                                </td>
                                <!-- Cellule Actions RH conditionnée par le rôle de l'utilisateur -->
                                <td v-if="userRole === 'admin'" class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <div v-if="req.status === 'en_attente'" class="flex space-x-2">
                                        <button @click="approveRequest(req.id)" class="text-green-600 hover:text-green-900 font-bold">Approuver</button>
                                        <button @click="rejectRequest(req.id)" class="text-red-600 hover:text-red-900 font-bold">Rejeter</button>
                                    </div>
                                    <span v-else class="text-gray-400 italic text-xs">Traité</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
