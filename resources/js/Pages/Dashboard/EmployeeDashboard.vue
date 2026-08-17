<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    employee: Object,
    myRequests: Array,
});

const page = usePage();
const authUser = computed(() => page.props.auth.user);

// Récupération sécurisée du nom (employé ou utilisateur connecté)
const employeeName = computed(() => {
    return props.employee?.name || authUser.value?.name || 'Collaborateur';
});

// Récupération sécurisée du département (relation objet ou texte direct)
const employeeDepartment = computed(() => {
    if (!props.employee) return 'Non assigné';
    if (typeof props.employee.department === 'string') return props.employee.department;
    return props.employee.department?.name || props.employee.service || 'Informatique & Tech';
});

// Horloge en temps réel automatique
const currentDateTime = ref('');
let timer = null;

const updateDateTime = () => {
    const now = new Date();
    currentDateTime.value = now.toLocaleDateString('fr-FR', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
};

onMounted(() => {
    updateDateTime();
    timer = setInterval(updateDateTime, 1000);
});

onUnmounted(() => {
    clearInterval(timer);
});

// Calculs automatiques des compteurs basés sur les demandes de l'employé
const pendingCount = computed(() => {
    return props.myRequests ? props.myRequests.filter(r => r.status === 'en_attente').length : 0;
});

const approvedCount = computed(() => {
    return props.myRequests ? props.myRequests.filter(r => r.status === 'approuvé' || r.status === 'approved').length : 0;
});

const rejectedCount = computed(() => {
    return props.myRequests ? props.myRequests.filter(r => r.status === 'rejeté' || r.status === 'rejected').length : 0;
});

const totalRequestsCount = computed(() => {
    return props.myRequests ? props.myRequests.length : 0;
});
</script>

<template>
    <Head title="Mon Espace Salarié" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Espace Personnel</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Bienvenue sur votre tableau de bord collaborateur.</p>
                </div>
                <Link :href="route('leave-requests.create')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Nouvelle demande de congé</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                <!-- Alerte si le compte user n'est pas lié à un profil employé -->
                <div v-if="!employee" class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-2xl shadow-sm flex items-start space-x-3" role="alert">
                    <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="font-semibold text-sm">Profil non lié</p>
                        <p class="text-sm text-amber-700 mt-0.5">Votre compte utilisateur n'est pas encore associé à un profil employé. Veuillez contacter le service des ressources humaines.</p>
                    </div>
                </div>

                <!-- Contenu principal si l'employé existe -->
                <template v-else>

                    <!-- Ligne 1 : Informations Profil & Temps -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <!-- Nom du Collaborateur -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Collaborateur</span>
                                    <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm">
                                        {{ employeeName.charAt(0) }}
                                    </div>
                                </div>
                                <div class="text-lg font-bold text-gray-900 truncate">{{ employeeName }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Statut</span>
                                <span class="font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Actif</span>
                            </div>
                        </div>

                        <!-- Date d'embauche -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Date d'embauche</span>
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="text-lg font-bold text-gray-900">{{ employee.hire_date ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Ancienneté</span>
                                <span class="font-medium text-blue-600">Vérifiée</span>
                            </div>
                        </div>

                        <!-- Département -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Département</span>
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div class="text-lg font-bold text-gray-900 truncate">{{ employeeDepartment }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Région</span>
                                <span class="font-medium text-gray-700">Haute Matsiatra</span>
                            </div>
                        </div>

                    </div>

                    <!-- Ligne 2 : Solde & Horloge Système -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <!-- Solde de congés payés -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Solde de congés payés</span>
                                <div class="flex items-baseline space-x-2 mt-2">
                                    <span class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ employee.leave_balance ?? 0 }}</span>
                                    <span class="text-sm font-medium text-gray-500">jours disponibles</span>
                                </div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Droits acquis</span>
                                <span class="font-medium text-emerald-600">À jour</span>
                            </div>
                        </div>

                        <!-- Date et Heure Automatique -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Heure Locale</span>
                                    <span class="flex h-2 w-2 relative">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                </div>
                                <div class="text-sm font-bold text-gray-800 mt-3 capitalize leading-snug">{{ currentDateTime }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Fuseau</span>
                                <span class="font-medium text-purple-600">Synchro Live</span>
                            </div>
                        </div>

                        <!-- Total Demandes -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Demandes</span>
                                <div class="text-3xl font-extrabold text-gray-900 tracking-tight mt-2">{{ totalRequestsCount }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 flex items-center justify-between text-xs">
                                <span class="text-gray-500">Historique global</span>
                                <span class="font-medium text-gray-600">Toutes périodes</span>
                            </div>
                        </div>

                    </div>

                    <!-- Ligne 3 : Statistiques des Demandes -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <!-- En attente -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-amber-600/80">En attente</span>
                                <div class="text-3xl font-extrabold text-amber-600 tracking-tight mt-2">{{ pendingCount }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 text-xs text-gray-500 font-medium">
                                En cours de traitement par le management
                            </div>
                        </div>

                        <!-- Approuvées -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-emerald-600/80">Approuvées</span>
                                <div class="text-3xl font-extrabold text-emerald-600 tracking-tight mt-2">{{ approvedCount }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 text-xs text-gray-500 font-medium">
                                Validées et enregistrées
                            </div>
                        </div>

                        <!-- Rejetées -->
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600/80">Rejetées</span>
                                <div class="text-3xl font-extrabold text-rose-600 tracking-tight mt-2">{{ rejectedCount }}</div>
                            </div>
                            <div class="mt-6 pt-3 border-t border-gray-50 text-xs text-gray-500 font-medium">
                                Refusées ou archivées
                            </div>
                        </div>

                    </div>

                </template>

                <!-- Historique des demandes personnelles -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-xs p-6 mt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-lg text-gray-900 tracking-tight">Historique de mes demandes</h3>
                        <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2.5 py-1 rounded-lg">{{ totalRequestsCount }} enregistrement(s)</span>
                    </div>

                    <div v-if="!myRequests || myRequests.length === 0" class="text-center py-12">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p class="text-gray-500 text-sm font-medium">Aucune demande de congé effectuée pour le moment.</p>
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 px-3">Type</th>
                                    <th class="pb-3 px-3">Période</th>
                                    <th class="pb-3 px-3">Durée</th>
                                    <th class="pb-3 px-3">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                <tr v-for="req in myRequests" :key="req.id" class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-3 font-semibold text-gray-900">
                                        {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-3 text-gray-600">
                                        {{ req.start_date }} au {{ req.end_date }}
                                    </td>
                                    <td class="py-4 px-3 font-bold text-gray-900">
                                        {{ req.days_count }} j
                                    </td>
                                    <td class="py-4 px-3">
                                        <span :class="{
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-amber-50 text-amber-700 border border-amber-200/60': req.status === 'en_attente',
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60': req.status === 'approuvé' || req.status === 'approved',
                                            'px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-rose-50 text-rose-700 border border-rose-200/60': req.status === 'rejeté' || req.status === 'rejected'
                                        }">
                                            <span class="w-1.5 h-1.5 rounded-full" :class="{
                                                'bg-amber-500': req.status === 'en_attente',
                                                'bg-emerald-500': req.status === 'approuvé' || req.status === 'approved',
                                                'bg-rose-500': req.status === 'rejeté' || req.status === 'rejected'
                                            }"></span>
                                            <span>{{ req.status }}</span>
                                        </span>
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
