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
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mon Espace Personnel</h2>
                <Link :href="route('leave-requests.create')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Faire une demande de congé</span>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Alerte si le compte user n'est pas lié à un profil employé -->
                <div v-if="!employee" class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm" role="alert">
                    <p class="font-bold">Attention</p>
                    <p>Votre compte utilisateur n'est pas encore lié à un profil employé dans le système. Contactez les RH.</p>
                </div>

                <!-- Contenu principal si l'employé existe -->
                <template v-else>

                    <!-- Ligne 1 : Informations Profil & Temps (3 par 3) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Nom du Collaborateur (BDD) -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-indigo-600 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Collaborateur</div>
                                <div class="text-xl font-bold text-gray-900 truncate">{{ employeeName }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-indigo-600 font-semibold">
                                Compte Salarié Actif
                            </div>
                        </div>

                        <!-- Date d'embauche (BDD) -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-blue-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Date d'embauche</div>
                                <div class="text-xl font-bold text-gray-900">{{ employee.hire_date ?? 'N/A' }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-blue-600 font-semibold">
                                Ancienneté active
                            </div>
                        </div>

                        <!-- Département Réel issu de la BDD (ex: Informatique & Tech) -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-sky-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Département</div>
                                <div class="text-xl font-bold text-gray-900 truncate">
                                    {{ employeeDepartment }}
                                </div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-sky-600 font-semibold">
                                Région Haute Matsiatra
                            </div>
                        </div>

                    </div>

                    <!-- Ligne 2 : Solde & Horloge Système (3 par 3) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Solde de congés payés -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-emerald-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Solde de congés payés</div>
                                <div class="text-3xl font-extrabold text-gray-900 mt-1">{{ employee.leave_balance ?? 0 }} <span class="text-sm font-normal text-gray-500">jours</span></div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-emerald-600 font-semibold">
                                Disponible immédiatement
                            </div>
                        </div>

                        <!-- Date et Heure Automatique -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-purple-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Heure Système</div>
                                <div class="text-sm font-bold text-gray-800 mt-2 capitalize">{{ currentDateTime }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-purple-600 font-semibold flex items-center space-x-1">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span>En direct</span>
                            </div>
                        </div>

                        <!-- Total Demandes -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-gray-600 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Total Demandes</div>
                                <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ totalRequestsCount }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-gray-600 font-semibold">
                                Historique global
                            </div>
                        </div>

                    </div>

                    <!-- Ligne 3 : Statistiques des Demandes (3 par 3) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- En attente -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-amber-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Demandes en attente</div>
                                <div class="text-3xl font-extrabold text-amber-600 mt-1">{{ pendingCount }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-amber-600 font-semibold">
                                En cours de traitement
                            </div>
                        </div>

                        <!-- Approuvées -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-green-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Demandes approuvées</div>
                                <div class="text-3xl font-extrabold text-green-600 mt-1">{{ approvedCount }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-green-600 font-semibold">
                                Validées par les RH
                            </div>
                        </div>

                        <!-- Rejetées -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border-l-4 border-red-500 flex flex-col justify-between">
                            <div>
                                <div class="text-gray-400 text-xs font-semibold uppercase tracking-wider mb-1">Demandes rejetées</div>
                                <div class="text-3xl font-extrabold text-red-600 mt-1">{{ rejectedCount }}</div>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100 text-xs text-red-600 font-semibold">
                                Refusées
                            </div>
                        </div>

                    </div>

                </template>

                <!-- Historique des demandes personnelles -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Mes demandes de congés</h3>

                    <div v-if="!myRequests || myRequests.length === 0" class="text-gray-500 italic py-4 text-center">Vous n'avez effectué aucune demande pour le moment.</div>

                    <table v-else class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Période</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Durée</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="req in myRequests" :key="req.id" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                    {{ req.leave_type ? req.leave_type.name : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ req.start_date }} au {{ req.end_date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                    {{ req.days_count }} j
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="{
                                        'px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': req.status === 'en_attente',
                                        'px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': req.status === 'approuvé' || req.status === 'approved',
                                        'px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': req.status === 'rejeté' || req.status === 'rejected'
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
