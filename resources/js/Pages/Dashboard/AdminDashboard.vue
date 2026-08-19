<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref } from 'vue';

defineProps({
    totalEmployees: Number,
    pendingRequestsCount: Number,
    totalLeaveRequests: Number,
    approvedRequestsCount: Number,
    rejectedRequestsCount: Number,
    adminLeaveBalance: Number,
    totalAdmins: Number, // Ajout de la prop pour le total des administrateurs
    recentRequests: Array,
});

// Horloge dynamique en temps réel
const currentDateTime = ref('');
let timer = null;

const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleDateString('fr-FR', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    }) + ' • ' + now.toLocaleTimeString('fr-FR');
};

onMounted(() => {
    updateDateTime();
    timer = setInterval(updateDateTime, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});
</script>

<template>
    <Head title="Tableau de bord - Administrateur" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <!-- Titre expert et concis -->
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 leading-tight">Tableau de bord exécutif</h2>
                    <p class="text-sm text-gray-500 font-medium">Gestion centralisée des ressources humaines</p>
                </div>

                <!-- Indicateur de session moderne -->
                <div class="flex items-center px-4 py-2 bg-white rounded-lg border border-gray-200 shadow-sm space-x-2">
                    <!-- Point vert animé -->
                    <div class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Actif</span>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Grille des 8 Indicateurs clés (KPIs Ultra Pro Max) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- 1. Total Employés -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Collaborateurs Actifs</span>
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ totalEmployees }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('employees.index')" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition flex items-center space-x-1">
                                <span>Annuaire</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                        </div>
                    </div>

                    <!-- 2. Total Administrateurs -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-teal-600 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Administrateurs</span>
                                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-teal-700 mt-2">{{ totalAdmins ?? 0 }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 text-right text-xs text-teal-600 font-medium">
                            Accès & Sécurité
                        </div>
                    </div>

                    <!-- 3. Nombre total de congés -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Volume Global des Congés</span>
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ totalLeaveRequests ?? 0 }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('leave-requests.index')" class="px-3 py-1 bg-purple-50 text-purple-600 rounded text-xs font-semibold hover:bg-purple-100 transition flex items-center space-x-1">
                                <span>Historique</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                        </div>
                    </div>

                    <!-- 4. Date et heure en cours -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Aujourd'hui</span>
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-gray-800 mt-3 bg-blue-50/50 p-2 rounded border border-blue-100 text-center">
                                {{ currentDateTime || 'Chargement...' }}
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 text-right text-xs text-blue-600 font-medium">
                            Heure locale
                        </div>
                    </div>

                    <!-- 5. Nombre congés approuvés -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Demandes Validées</span>
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ approvedRequestsCount ?? 0 }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('leave-requests.index')" class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded text-xs font-semibold hover:bg-emerald-100 transition flex items-center space-x-1">
                                <span>Consulter</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                        </div>
                    </div>

                    <!-- 6. Nombre congés rejetés -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>Demandes Refusées</span>
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ rejectedRequestsCount ?? 0 }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('leave-requests.index')" class="px-3 py-1 bg-red-50 text-red-600 rounded text-xs font-semibold hover:bg-red-100 transition flex items-center space-x-1">
                                <span>Consulter</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                        </div>
                    </div>

                    <!-- 7. Nombre congé en attente -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <span>En attente de révision</span>
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ pendingRequestsCount }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('leave-requests.pending')" class="px-3 py-1 bg-amber-50 text-amber-600 rounded text-xs font-semibold hover:bg-amber-100 transition flex items-center space-x-1">
                                <span>Examiner</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                        </div>
                    </div>

                    <!-- 8. Actions Requises -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500 flex flex-col justify-between hover:shadow-md transition">
                        <div>
                            <div class="flex items-center justify-between text-gray-500 text-sm font-medium mb-1">
                                <div class="flex items-center space-x-2">
                                    <span>Actions Requises</span>
                                    <!-- Pastille rouge conditionnelle : s'affiche uniquement si supérieur à 0 -->
                                    <span v-if="pendingRequestsCount > 0" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-600 animate-pulse">
                                        {{ pendingRequestsCount }}
                                    </span>
                                </div>
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="text-3xl font-bold text-gray-900 mt-2">{{ pendingRequestsCount }}</div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                            <Link :href="route('leave-requests.pending')" class="px-3 py-1 bg-yellow-500 text-white rounded text-xs font-semibold hover:bg-yellow-600 transition shadow-sm">
                                Traiter en priorité
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Dernières demandes de l'entreprise -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Flux récent des requêtes RH</h3>

                    <div v-if="recentRequests.length === 0" class="text-gray-500 italic">Aucune activité récente enregistrée pour le moment.</div>

                    <table v-else class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collaborateur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de congé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période demandée</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État d'avancement</th>
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
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': req.status === 'approuvé' || req.status === 'approved',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': req.status === 'rejeté' || req.status === 'rejected'
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
