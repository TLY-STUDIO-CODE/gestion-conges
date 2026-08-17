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
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Suivi des Demandes de Congés</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Gérez et suivez l'ensemble des requêtes de congés du personnel.</p>
                </div>
                <Link :href="route('leave-requests.create')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Nouvelle demande</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <th class="py-3.5 px-6">Employé</th>
                                    <th class="py-3.5 px-6">Type</th>
                                    <th class="py-3.5 px-6">Du / Au</th>
                                    <th class="py-3.5 px-6">Jours</th>
                                    <th class="py-3.5 px-6">Statut</th>
                                    <th class="py-3.5 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                <tr v-for="req in leaveRequests" :key="req.id" class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Employé -->
                                    <td class="py-4 px-6 whitespace-nowrap font-semibold text-gray-900">
                                        {{ req.employee ? req.employee.first_name + ' ' + req.employee.last_name : 'N/A' }}
                                    </td>

                                    <!-- Type -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-600 font-medium">
                                        {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                    </td>

                                    <!-- Période -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-500 text-xs">
                                        <span class="font-medium text-gray-800">{{ req.start_date }}</span> <span class="text-gray-400 mx-1">au</span> <span class="font-medium text-gray-800">{{ req.end_date }}</span>
                                    </td>

                                    <!-- Jours -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-900 font-bold">
                                        {{ req.days_count }} <span class="text-xs font-normal text-gray-500">j</span>
                                    </td>

                                    <!-- Statut -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span :class="{
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-amber-50 text-amber-700 border border-amber-200/60': req.status === 'en_attente',
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60': req.status === 'approved' || req.status === 'approuvé',
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-rose-50 text-rose-700 border border-rose-200/60': req.status === 'rejected' || req.status === 'rejeté'
                                        }">
                                            <span class="w-1.5 h-1.5 rounded-full" :class="{
                                                'bg-amber-500': req.status === 'en_attente',
                                                'bg-emerald-500': req.status === 'approved' || req.status === 'approuvé',
                                                'bg-rose-500': req.status === 'rejected' || req.status === 'rejeté'
                                            }"></span>
                                            <span class="capitalize">{{ req.status }}</span>
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-4 px-6 whitespace-nowrap text-right font-medium">
                                        <!-- Si Admin -->
                                        <template v-if="userRole === 'admin'">
                                            <div class="inline-flex items-center justify-end space-x-1.5">
                                                <button v-if="req.status !== 'approved' && req.status !== 'approuvé'" @click="approveRequest(req.id)" class="px-2.5 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-semibold transition border border-emerald-200/60">Approuver</button>
                                                <button v-if="req.status !== 'en_attente'" @click="pendingRequest(req.id)" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-semibold transition border border-amber-200/60">En attente</button>
                                                <button v-if="req.status !== 'rejected' && req.status !== 'rejeté'" @click="rejectRequest(req.id)" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition border border-rose-200/60">Rejeter</button>
                                                <button @click="deleteRequest(req.id)" class="p-1 text-gray-400 hover:text-rose-600 rounded-lg transition ml-1" title="Supprimer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </template>

                                        <!-- Si Employé -->
                                        <template v-else>
                                            <div v-if="req.status === 'en_attente'" class="inline-flex items-center space-x-2">
                                                <Link :href="route('leave-requests.edit', req.id)" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold transition border border-indigo-200/60">Modifier</Link>
                                                <button @click="deleteRequest(req.id)" class="px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition border border-rose-200/60">Supprimer</button>
                                            </div>
                                            <span v-else class="inline-flex items-center space-x-1 px-2.5 py-1 text-xs font-medium text-gray-400 bg-gray-100 rounded-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                <span>Verrouillé</span>
                                            </span>
                                        </template>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
