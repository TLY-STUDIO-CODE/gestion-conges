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
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Espace RH : Validation des Congés</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Traitez rapidement les demandes de congés en attente de validation.</p>
                </div>
                <Link :href="route('leave-requests.index')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Voir l'historique global</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Message Flash de succès sécurisé -->
                <div v-if="flash.success" class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl shadow-sm flex items-center space-x-3" role="alert">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-sm font-medium">{{ flash.success }}</span>
                </div>

                <!-- Message Flash d'erreur sécurisé -->
                <div v-if="flash.error" class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl shadow-sm flex items-center space-x-3" role="alert">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="text-sm font-medium">{{ flash.error }}</span>
                </div>

                <!-- Contenu principal -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 tracking-tight">Demandes nécessitant une action</h3>
                            <p class="text-xs text-gray-500 mt-0.5">{{ pendingRequests?.length || 0 }} requête(s) en attente de décision</p>
                        </div>
                    </div>

                    <div v-if="!pendingRequests || pendingRequests.length === 0" class="text-center py-16">
                        <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-gray-100 shadow-sm">
                            <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-gray-900 font-semibold text-base">Tout est à jour !</p>
                        <p class="text-gray-500 text-sm mt-1">Aucune demande en attente pour le moment. Bon travail !</p>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="py-3.5 px-6">Employé</th>
                                    <th class="py-3.5 px-6">Type</th>
                                    <th class="py-3.5 px-6">Période</th>
                                    <th class="py-3.5 px-6">Durée</th>
                                    <th class="py-3.5 px-6">Motif</th>
                                    <th class="py-3.5 px-6 text-right">Décision</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                <tr v-for="req in pendingRequests" :key="req.id" class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Employé -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs flex-shrink-0 border border-indigo-100/50">
                                                {{ req.employee && req.employee.first_name ? req.employee.first_name.charAt(0) : '' }}{{ req.employee && req.employee.last_name ? req.employee.last_name.charAt(0) : '' }}
                                            </div>
                                            <span class="font-semibold text-gray-900">
                                                {{ req.employee ? req.employee.first_name + ' ' + req.employee.last_name : 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Type -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-600 font-medium">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-medium">
                                            {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                        </span>
                                    </td>

                                    <!-- Période -->
                                    <td class="py-4 px-6 whitespace-nowrap text-xs text-gray-500">
                                        <span class="font-medium text-gray-800">{{ req.start_date }}</span> <span class="text-gray-400 mx-1">au</span> <span class="font-medium text-gray-800">{{ req.end_date }}</span>
                                    </td>

                                    <!-- Durée -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-900 font-bold">
                                        {{ req.days_count }} <span class="text-xs font-normal text-gray-500">j</span>
                                    </td>

                                    <!-- Motif -->
                                    <td class="py-4 px-6 text-gray-500 max-w-xs truncate text-xs">
                                        {{ req.reason || 'Aucun motif' }}
                                    </td>

                                    <!-- Décision / Actions -->
                                    <td class="py-4 px-6 whitespace-nowrap text-right font-medium">
                                        <div class="inline-flex items-center justify-end space-x-2">
                                            <button @click="approveRequest(req.id)" class="px-3.5 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-xl text-xs font-semibold transition border border-emerald-200/60 shadow-sm flex items-center space-x-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                <span>Approuver</span>
                                            </button>
                                            <button @click="rejectRequest(req.id)" class="px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl text-xs font-semibold transition border border-rose-200/60 shadow-sm flex items-center space-x-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                <span>Rejeter</span>
                                            </button>
                                        </div>
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
