<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Tableau de Bord • Espace Collaborateur" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold text-slate-950">Tableau de Bord</h2>
            <p class="text-sm text-slate-500">Bienvenue dans votre environnement de travail numérique.</p>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto px-6 space-y-8">

                <!-- Carte Bienvenue -->
                <div class="bg-slate-900 text-white p-10 rounded-3xl flex items-center justify-between shadow-2xl">
                    <div class="max-w-xl">
                        <h3 class="text-2xl font-bold mb-3">Espace Opérationnel • Haute Matsiatra</h3>
                        <p class="text-slate-400">Accédez à l'ensemble de vos outils RH, gérez vos congés et consultez votre historique professionnel.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-500">Statut</div>
                        <div class="text-emerald-400 font-bold text-lg">Session Active</div>
                    </div>
                </div>

                <!-- Indicateurs -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Temps</div>
                        <div class="text-3xl font-extrabold mt-3">Gestion des Congés</div>
                        <div class="mt-4 text-sm text-slate-500">Visualisez votre solde et soumettez vos requêtes.</div>
                    </div>
                    <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pôle RH</div>
                        <div class="text-3xl font-extrabold mt-3 text-emerald-600">Dossier à jour</div>
                        <div class="mt-4 text-sm text-slate-500">Vos informations sont conformes.</div>
                    </div>
                    <div class="bg-white border border-slate-100 p-8 rounded-3xl shadow-sm">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Intranet</div>
                        <div class="text-3xl font-extrabold mt-3 text-blue-600">Sécurisé v4.2</div>
                        <div class="mt-4 text-sm text-slate-500">Connexion chiffrée et protégée.</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
