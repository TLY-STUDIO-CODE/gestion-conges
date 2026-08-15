<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
    leaveRequests: Array,
});

const page = usePage();
const userRole = computed(() => page.props.auth.user.role);

const actionForm = useForm({});

const approveRequest = (id) => {
    actionForm.patch(route('leave-requests.approve', id));
};

const rejectRequest = (id) => {
    actionForm.patch(route('leave-requests.reject', id));
};

const pendingRequest = (id) => {
    actionForm.patch(route('leave-requests.pending-status', id));
};

const deleteRequest = (id) => {
    if (confirm('Voulez-vous vraiment supprimer cette demande de congé ?')) {
        actionForm.delete(route('leave-requests.destroy', id));
    }
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

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Du / Au</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jours</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
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
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': req.status === 'approved' || req.status === 'approuvé',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': req.status === 'rejected' || req.status === 'rejeté'
                                    }">
                                        {{ req.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <!-- Si Admin : Basculement permanent des statuts + Suppression -->
                                    <template v-if="userRole === 'admin'">
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center space-x-2">
                                                <button v-if="req.status !== 'approved'" @click="approveRequest(req.id)" class="text-green-600 hover:text-green-900 font-bold text-xs bg-green-50 px-2 py-1 rounded border border-green-200">Approuver</button>
                                                <button v-if="req.status !== 'en_attente'" @click="pendingRequest(req.id)" class="text-yellow-600 hover:text-yellow-900 font-bold text-xs bg-yellow-50 px-2 py-1 rounded border border-yellow-200">En attente</button>
                                                <button v-if="req.status !== 'rejected'" @click="rejectRequest(req.id)" class="text-red-600 hover:text-red-900 font-bold text-xs bg-red-50 px-2 py-1 rounded border border-red-200">Rejeter</button>
                                            </div>
                                            <div>
                                                <button @click="deleteRequest(req.id)" class="text-red-500 hover:text-red-700 text-xs font-semibold underline mt-1">Supprimer</button>
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Si Employé : Modification/Suppression autorisée uniquement si 'en_attente' et que c'est sa demande -->
                                    <template v-else>
                                        <div v-if="req.status === 'en_attente'" class="space-x-2">
                                            <Link :href="route('leave-requests.edit', req.id)" class="text-indigo-600 hover:text-indigo-900 font-bold">Modifier</Link>
                                            <button @click="deleteRequest(req.id)" class="text-red-600 hover:text-red-900 font-bold">Supprimer</button>
                                        </div>
                                        <span v-else class="text-gray-400 italic text-xs">Verrouillé</span>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
