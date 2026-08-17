<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Portail Officiel des Ressources Humaines • Région Haute Matsiatra" />

    <div class="min-h-screen bg-[#070b14] text-slate-100 flex flex-col justify-between selection:bg-blue-600 selection:text-white relative overflow-hidden font-sans">

        <!-- Bandeau supérieur institutionnel officiel (Standard Gouvernemental International) -->
        <div class="bg-[#0b1329] border-b border-slate-800/80 text-[11px] text-slate-400 py-1.5 px-4 sm:px-6 lg:px-8 relative z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span>
                    <span class="font-medium text-slate-300">Un site officiel géré par la Région Haute Matsiatra</span>
                </div>
                <div class="hidden sm:flex items-center space-x-4 text-slate-400">
                    <span>Sécurité SSL Active</span>
                    <span>•</span>
                    <span>Intranet v4.2</span>
                </div>
            </div>
        </div>

        <!-- Effets lumineux de fond subtils (Mesh/Glow SaaS) -->
        <div class="absolute top-20 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>

        <!-- En-tête / Header Institutionnel Principal -->
        <header class="bg-[#070b14]/80 backdrop-blur-xl border-b border-slate-800/80 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Sceau / Logo Officiel -->
                    <div class="w-12 h-12 bg-slate-800/80 border border-slate-700/80 rounded-xl flex items-center justify-center p-2 shadow-inner backdrop-blur-md">
                        <ApplicationLogo class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">République de Madagascar</span>
                        </div>
                        <h1 class="text-base sm:text-lg font-extrabold text-white tracking-tight leading-tight">
                            Région Haute Matsiatra
                        </h1>
                        <p class="text-xs text-blue-400 font-semibold tracking-wide">
                            Cabinet du Gouverneur • Direction des Ressources Humaines
                        </p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex items-center space-x-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-600/20 flex items-center space-x-2 border border-blue-400/30"
                    >
                        <span>Tableau de Bord</span>
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-300 bg-slate-800/80 border border-slate-700/80 rounded-xl hover:bg-slate-800 hover:text-white transition shadow-sm"
                        >
                            Espace Agent
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="hidden sm:inline-flex px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-xl hover:bg-blue-500 transition shadow-lg shadow-blue-600/20 border border-blue-400/30"
                        >
                            Enregistrement
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Contenu Principal / Hero Section Ultra Pro Max -->
        <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="max-w-4xl w-full text-center space-y-8">

                <!-- Badge Institutionnel Dynamique -->
                <div class="inline-flex items-center space-x-2 bg-slate-800/50 border border-slate-700/60 px-4 py-1.5 rounded-full text-xs font-medium text-slate-300 shadow-sm backdrop-blur-md">
                    <span class="text-blue-400 font-bold">Fianarantsoa</span>
                    <span class="text-slate-600">•</span>
                    <span class="text-slate-300">Portail Administratif Numérique Officiel</span>
                </div>

                <!-- Titre Majeur Inspirant -->
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight leading-[1.15]">
                    Gestion Simplifiée & Fiable <br class="hidden sm:inline" />
                    <span class="bg-gradient-to-r from-blue-400 via-indigo-300 to-indigo-500 bg-clip-text text-transparent">des Congés et du Personnel</span>
                </h2>

                <!-- Description Profonde et Élégante -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
                    Plateforme officielle dédiée à la gestion humaine de proximité, au suivi rigoureux des congés et à l'accompagnement quotidien des agents du service public de la Région Haute Matsiatra.
                </p>

                <!-- Bouton d'action principal Ultra Travaillé -->
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="w-full sm:w-auto px-8 py-4 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-xl hover:bg-blue-500 transition shadow-xl shadow-blue-600/30 border border-blue-400/30 text-center transform hover:-translate-y-0.5 duration-200"
                    >
                        Accéder à l'authentification sécurisée
                    </Link>
                    <Link
                        v-else
                        :href="route('dashboard')"
                        class="w-full sm:w-auto px-8 py-4 text-xs font-bold uppercase tracking-wider text-white bg-blue-600 rounded-xl hover:bg-blue-500 transition shadow-xl shadow-blue-600/30 border border-blue-400/30 text-center transform hover:-translate-y-0.5 duration-200"
                    >
                        Accéder à mon espace de travail
                    </Link>
                </div>

                <!-- Grille d'engagements / Fonctionnalités Niveau Pro Max -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-16 text-left">
                    <div class="bg-slate-800/30 backdrop-blur-md p-6 rounded-2xl border border-slate-800 hover:border-slate-700 transition group shadow-lg">
                        <div class="w-10 h-10 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400 flex items-center justify-center font-bold mb-4 text-xs group-hover:scale-105 transition">
                            01
                        </div>
                        <h3 class="font-bold text-white mb-2 text-sm">Transparence & Suivi</h3>
                        <p class="text-xs text-slate-400 leading-relaxed font-normal">Traitement fluide, équitable et traçabilité absolue de l'ensemble des requêtes de congés du personnel.</p>
                    </div>

                    <div class="bg-slate-800/30 backdrop-blur-md p-6 rounded-2xl border border-slate-800 hover:border-slate-700 transition group shadow-lg">
                        <div class="w-10 h-10 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400 flex items-center justify-center font-bold mb-4 text-xs group-hover:scale-105 transition">
                            02
                        </div>
                        <h3 class="font-bold text-white mb-2 text-sm">Efficacité Opérationnelle</h3>
                        <p class="text-xs text-slate-400 leading-relaxed font-normal">Centralisation rigoureuse des dossiers administratifs pour fluidifier les validations hiérarchiques.</p>
                    </div>

                    <div class="bg-slate-800/30 backdrop-blur-md p-6 rounded-2xl border border-slate-800 hover:border-slate-700 transition group shadow-lg">
                        <div class="w-10 h-10 rounded-xl bg-blue-600/10 border border-blue-500/20 text-blue-400 flex items-center justify-center font-bold mb-4 text-xs group-hover:scale-105 transition">
                            03
                        </div>
                        <h3 class="font-bold text-white mb-2 text-sm">Sécurité de Pointe</h3>
                        <p class="text-xs text-slate-400 leading-relaxed font-normal">Protection renforcée des données internes, conformité normative et accès strictement contrôlé.</p>
                    </div>
                </div>

            </div>
        </main>

        <!-- Pied de page / Footer Institutionnel Pro Max -->
        <footer class="bg-[#050810] border-t border-slate-800/80 py-8 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-2">
                    <p>&copy; 2026 Région Haute Matsiatra • Fianarantsoa, Madagascar. Tous droits réservés.</p>
                </div>
                <div class="flex items-center space-x-6 text-slate-400">
                    <span class="hover:text-slate-200 transition cursor-pointer">Direction des Ressources Humaines</span>
                    <span class="text-slate-700">•</span>
                    <span class="hover:text-slate-200 transition cursor-pointer">Système Intranet Gouvernemental</span>
                </div>
            </div>
        </footer>
    </div>
</template>
