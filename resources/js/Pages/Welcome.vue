<script setup>
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
    <Head title="Portail Officiel des Ressources Humaines - Région Haute Matsiatra" />

    <div class="min-h-screen bg-slate-50 flex flex-col justify-between text-slate-900 selection:bg-blue-900 selection:text-white">
        <!-- En-tête / Header Institutionnel -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <!-- Sceau / Logo Officiel -->
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-slate-900 rounded-lg flex items-center justify-center text-white font-serif font-bold text-xl shadow-inner border border-blue-800">
                        HM
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            <span class="text-xs font-bold tracking-widest text-slate-500 uppercase">République de Madagascar</span>
                        </div>
                        <h1 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">
                            Région Haute Matsiatra
                        </h1>
                        <p class="text-xs text-blue-900 font-semibold tracking-wide">
                            Cabinet du Gouvernorat • Fianarantsoa
                        </p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex items-center space-x-3">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md hover:bg-blue-800 transition shadow-sm flex items-center space-x-2"
                    >
                        <span>Tableau de Bord</span>
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 transition shadow-sm"
                        >
                            Espace Agent
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="hidden sm:inline-flex px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md hover:bg-blue-800 transition shadow-sm"
                        >
                            Enregistrement
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Contenu Principal / Hero Section -->
        <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-4xl w-full text-center space-y-8">

                <!-- Badge Institutionnel -->
                <div class="inline-flex items-center space-x-2 bg-slate-100 border border-slate-200 px-4 py-1.5 rounded-full text-xs font-medium text-slate-700">
                    <span class="text-blue-900 font-bold">Fianarantsoa III</span>
                    <span class="text-slate-300">•</span>
                    <span>Plateforme Administrative Sécurisée</span>
                </div>

                <!-- Titre Majeur -->
                <h2 class="text-3xl sm:text-5xl font-serif font-bold text-slate-900 tracking-tight leading-tight">
                    Gestion Intégrée des Ressources Humaines & du Personnel
                </h2>

                <!-- Description sobre et professionnelle -->
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Outil numérique officiel dédié à l'accompagnement des agents publics, à l'optimisation du service administratif et au suivi rigoureux des congés au sein de la Région Haute Matsiatra.
                </p>

                <!-- Bouton d'action principal -->
                <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="w-full sm:w-auto px-8 py-3.5 text-sm font-semibold text-white bg-blue-900 rounded-lg hover:bg-blue-800 transition shadow-md hover:shadow-lg text-center"
                    >
                        Accéder à l'authentification
                    </Link>
                    <Link
                        v-else
                        :href="route('dashboard')"
                        class="w-full sm:w-auto px-8 py-3.5 text-sm font-semibold text-white bg-blue-900 rounded-lg hover:bg-blue-800 transition shadow-md hover:shadow-lg text-center"
                    >
                        Accéder à mon espace de travail
                    </Link>
                </div>

                <!-- Grille d'engagements / Fonctionnalités clés -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-16 text-left">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center font-bold mb-4 text-base">
                            01
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Transparence & Suivi</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Traitement équitable et traçabilité de l'ensemble des requêtes administratives du personnel.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center font-bold mb-4 text-base">
                            02
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Efficacité Opérationnelle</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Centralisation des dossiers pour alléger les processus de validation au niveau de la hiérarchie.</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-xs hover:shadow-md transition">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center font-bold mb-4 text-base">
                            03
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">Sécurité des Données</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">Conformité aux normes de protection des informations internes et accès strictement restreint.</p>
                    </div>
                </div>

            </div>
        </main>

        <!-- Pied de page / Footer Institutionnel -->
        <footer class="bg-white border-t border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-2">
                    <p>&copy; 2026 Région Haute Matsiatra • Fianarantsoa, Madagascar. Tous droits réservés.</p>
                </div>
                <div class="flex items-center space-x-6">
                    <span class="hover:text-slate-800 transition">Direction des Ressources Humaines</span>
                    <span>•</span>
                    <span class="hover:text-slate-800 transition">Système Intranet Gouvernemental</span>
                </div>
            </div>
        </footer>
    </div>
</template>
