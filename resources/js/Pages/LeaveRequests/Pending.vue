<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    pendingRequests: Array,
});

const page = usePage();
const flash = computed(() => page.props.flash || {});

const actionForm = useForm({});

const approveRequest = (id) => {
    actionForm.patch(route('leave-requests.approve', id));
};

const rejectRequest = (id) => {
    actionForm.patch(route('leave-requests.reject', id));
};
</script>

<template>
    <Head title="Validation RH - Demandes en attente" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Espace RH : Validation des Congés</h2>
                <Link :href="route('leave-requests.index')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                    Voir l'historique global
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Message Flash de succès ou d'erreur sécurisé -->
                <div v-if="flash.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ flash.success }}
                </div>
                <div v-if="flash.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ flash.error }}
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Demandes nécessitant une action ({{ pendingRequests?.length || 0 }})</h3>

                    <div v-if="!pendingRequests || pendingRequests.length === 0" class="text-gray-500 italic py-4">
                        Aucune demande en attente pour le moment. Bon travail !
                    </div>

                    <table v-else class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Période</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Durée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motif</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Décision</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="req in pendingRequests" :key="req.id">
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
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ req.reason || 'Aucun motif' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <button @click="approveRequest(req.id)" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Approuver</button>
                                    <button @click="rejectRequest(req.id)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Rejeter</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
