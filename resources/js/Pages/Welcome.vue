<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
});
</script>

<template>
    <Head title="Portail Officiel • Région Haute Matsiatra" />

    <div class="min-h-screen bg-white text-slate-900 font-sans">
        <!-- Header Institutionnel -->
        <header class="border-b border-slate-100 bg-white sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Logo mis en grand -->
                    <div class="w-20 h-20">
                        <ApplicationLogo class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-slate-900">Région Haute Matsiatra</h1>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Cabinet du Gouverneur • Administration</p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex items-center gap-3">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="px-6 py-2.5 text-sm font-semibold text-white bg-slate-900 rounded-lg hover:bg-slate-700 transition">Tableau de Bord</Link>
                    <template v-else>
                        <Link :href="route('login')" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">Connexion</Link>
                        <Link v-if="canRegister" :href="route('register')" class="px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm">Enregistrement</Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-6 py-20 text-center">
            <span class="inline-block px-4 py-1.5 mb-6 text-xs font-bold text-blue-600 bg-blue-50 rounded-full tracking-widest uppercase">Intranet de Gestion Publique</span>
            <h2 class="text-6xl font-extrabold text-slate-950 tracking-tighter mb-8 leading-tight">
                Gestion Administrative <br/> <span class="text-blue-600">Simplifiée & Fiable</span>
            </h2>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Portail de référence pour le suivi des dossiers personnels et la gestion des congés au sein de la Région Haute Matsiatra.
            </p>
            <Link :href="route('login')" class="inline-flex px-10 py-4 text-sm font-bold text-white bg-slate-900 rounded-xl hover:bg-slate-800 transition shadow-xl">
                Accéder à l'Espace Collaborateur
            </Link>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24">
                <div class="p-8 border border-slate-100 rounded-3xl bg-slate-50/50">
                    <div class="text-blue-600 font-bold mb-4">01.</div>
                    <h3 class="font-bold mb-2">Transparence</h3>
                    <p class="text-sm text-slate-500">Suivi en temps réel de vos demandes administratives.</p>
                </div>
                <div class="p-8 border border-slate-100 rounded-3xl bg-slate-50/50">
                    <div class="text-blue-600 font-bold mb-4">02.</div>
                    <h3 class="font-bold mb-2">Efficacité</h3>
                    <p class="text-sm text-slate-500">Processus de validation digitalisé et rapide.</p>
                </div>
                <div class="p-8 border border-slate-100 rounded-3xl bg-slate-50/50">
                    <div class="text-blue-600 font-bold mb-4">03.</div>
                    <h3 class="font-bold mb-2">Sécurité</h3>
                    <p class="text-sm text-slate-500">Protection renforcée de vos données personnelles.</p>
                </div>
            </div>
        </main>
    </div>
</template>
