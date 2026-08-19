<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Tableau de Bord • Espace Agent" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                        Tableau de Bord
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">Vue d'ensemble de votre espace collaboratif et de gestion des ressources humaines.</p>
                </div>
                <div class="hidden sm:flex items-center space-x-2 bg-slate-100 border border-slate-200/80 px-3 py-1.5 rounded-xl text-xs font-medium text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Session active • Haute Matsiatra</span>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <!-- Carte principale de bienvenue -->
                <div class="bg-white border border-slate-200/80 shadow-xs sm:rounded-2xl overflow-hidden">
                    <div class="p-6 sm:p-8 flex items-center justify-between">
                        <div class="space-y-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                Statut : Connecté
                            </span>
                            <h3 class="text-lg font-bold text-slate-900">Bienvenue sur votre portail opérationnel</h3>
                            <p class="text-sm text-slate-600 max-w-xl">
                                Vous êtes authentifié avec succès sur le système de gestion des congés et du personnel de la Région Haute Matsiatra.
                            </p>
                        </div>
                        <div class="hidden md:flex flex-col items-end justify-center">
                            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Environnement</span>
                            <span class="text-sm font-bold text-slate-700">Intranet v4.2 Sécurisé</span>
                        </div>
                    </div>
                </div>

                <!-- Grille d'indicateurs rapides / Aperçu SaaS -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-slate-200/80 shadow-xs sm:rounded-2xl p-6">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Solde de congés</div>
                        <div class="text-2xl font-extrabold text-slate-900 mt-2">En cours</div>
                        <p class="text-xs text-slate-500 mt-1">Consultez vos droits et demandes en cours.</p>
                    </div>

                    <div class="bg-white border border-slate-200/80 shadow-xs sm:rounded-2xl p-6">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Dossier Administratif</div>
                        <div class="text-2xl font-extrabold text-emerald-600 mt-2">À jour</div>
                        <p class="text-xs text-slate-500 mt-1">Informations de profil vérifiées par la DRH.</p>
                    </div>

                    <div class="bg-white border border-slate-200/80 shadow-xs sm:rounded-2xl p-6">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Sécurité & Accès</div>
                        <div class="text-2xl font-extrabold text-blue-600 mt-2">Protégé</div>
                        <p class="text-xs text-slate-500 mt-1">Chiffrement SSL et authentification active.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
