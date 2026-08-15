<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    totalEmployees: Number,
    pendingRequestsCount: Number,
    recentRequests: Array,
});
</script>

<template>
    <Head title="Tableau de bord - Administrateur" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tableau de bord RH / Administrateur</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Indicateurs clés (KPIs) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                        <div class="text-gray-500 text-sm font-medium">Total Employés</div>
                        <div class="text-3xl font-bold text-gray-900 mt-2">{{ totalEmployees }}</div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                        <div class="text-gray-500 text-sm font-medium">Demandes en attente de validation</div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-3xl font-bold text-gray-900">{{ pendingRequestsCount }}</span>
                            <Link :href="route('leave-requests.pending')" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm hover:bg-yellow-600 transition">
                                Traiter
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Dernières demandes de l'entreprise -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dernières demandes de congés de l'entreprise</h3>

                    <div v-if="recentRequests.length === 0" class="text-gray-500 italic">Aucune demande récente.</div>

                    <table v-else class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="req in recentRequests" :key="req.id">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                    {{ req.employee ? req.employee.first_name + ' ' + req.employee.last_name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ req.start_date }} au {{ req.end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': req.status === 'en_attente',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': req.status === 'approuvé',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': req.status === 'rejeté'
                                    }">
                                        {{ req.status }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
