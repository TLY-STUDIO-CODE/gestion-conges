<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    leaveRequests: Array,
    employees: Array,
    leaveTypes: Array,
});

// Fonction pour styliser les badges de statut
const getStatusBadge = (status) => {
    switch (status) {
        case 'approved': return 'bg-green-100 text-green-800';
        case 'rejected': return 'bg-red-100 text-red-800';
        default: return 'bg-yellow-100 text-yellow-800';
    }
};

const getStatusLabel = (status) => {
    switch (status) {
        case 'approved': return 'Approuvé';
        case 'rejected': return 'Refusé';
        default: return 'En attente';
    }
};
</script>

<template>
    <Head title="Gestion des Congés" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Suivi des Demandes de Congés
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Suivi des Demandes de Congés</h3>
                        <Link :href="route('leave-requests.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                            + Nouvelle demande
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Employé</th>
                                    <th class="px-6 py-3">Type</th>
                                    <th class="px-6 py-3">Du / Au</th>
                                    <th class="px-6 py-3">Statut</th>
                                    <th class="px-6 py-3">Motif</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="req in leaveRequests" :key="req.id">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        {{ req.employee ? req.employee.last_name + ' ' + req.employee.first_name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                        {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ req.start_date }} ➔ {{ req.end_date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', getStatusBadge(req.status)]">
                                            {{ getStatusLabel(req.status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ req.reason || 'Aucun motif renseigné' }}
                                    </td>
                                </tr>
                                <tr v-if="leaveRequests.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune demande de congé enregistrée.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
