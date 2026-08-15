<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    employee: Object,
    myRequests: Array,
});
</script>

<template>
    <Head title="Mon Espace Salarié" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mon Espace Personnel</h2>
                <Link :href="route('leave-requests.create')" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                    + Faire une demande de congé
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Alerte si le compte user n'est pas lié à un profil employé -->
                <div v-if="!employee" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                    <p class="font-bold">Attention</p>
                    <p>Votre compte utilisateur n'est pas encore lié à un profil employé dans le système. Contactez les RH.</p>
                </div>

                <!-- Solde de congés personnel -->
                <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                        <div class="text-gray-500 text-sm font-medium">Solde de congés payés</div>
                        <div class="text-3xl font-bold text-gray-900 mt-2">{{ employee.leave_balance }} jours</div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                        <div class="text-gray-500 text-sm font-medium">Date d'embauche</div>
                        <div class="text-xl font-bold text-gray-900 mt-2">{{ employee.hire_date }}</div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <div class="text-gray-500 text-sm font-medium">Département</div>
                        <div class="text-xl font-bold text-gray-900 mt-2">Salarié</div>
                    </div>
                </div>

                <!-- Historique des demandes personnelles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Mes demandes de congés</h3>

                    <div v-if="myRequests.length === 0" class="text-gray-500 italic">Vous n'avez effectué aucune demande pour le moment.</div>

                    <table v-else class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="req in myRequests" :key="req.id">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
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
