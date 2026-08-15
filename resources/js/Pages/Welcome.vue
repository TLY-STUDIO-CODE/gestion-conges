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
    <Head title="Portail RH - Région Haute Matsiatra" />

    <div class="min-h-screen bg-slate-50 flex flex-col justify-between text-slate-800">
        <!-- En-tête / Header Institutionnel -->
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <!-- Icône / Logo Institutionnel provisoire -->
                    <div class="w-10 h-10 bg-blue-900 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow">
                        RM
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900 leading-tight">
                            Région Haute Matsiatra
                        </h1>
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">
                            Cabinet du Gouvernorat • Fianarantsoa
                        </p>
                    </div>
                </div>

                <nav v-if="canLogin" class="flex items-center space-x-4">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md hover:bg-blue-800 transition shadow"
                    >
                        Mon Tableau de Bord
                    </Link>

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="px-4 py-2 text-sm font-medium text-blue-900 bg-blue-50 border border-blue-200 rounded-md hover:bg-blue-100 transition"
                        >
                            Connexion Agent
                        </Link>

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-md hover:bg-blue-800 transition shadow"
                        >
                            Créer un compte
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <!-- Contenu Principal / Hero Section -->
        <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
            <div class="max-w-4xl w-full text-center space-y-8">
                <div class="inline-flex items-center space-x-2 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold text-blue-900 uppercase tracking-wide">
                    <span>Madagascar • Fianarantsoa</span>
                </div>

                <h2 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight">
                    Portail Numérique de Gestion des Congés & Ressources Humaines
                </h2>

                <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                    Plateforme officielle sécurisée dédiée au personnel, aux employés et aux services administratifs du Cabinet de la Région Haute Matsiatra.
                </p>

                <div class="flex flex-col sm:flex-row justify-center items-center space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="w-full sm:w-auto px-8 py-3 text-base font-medium text-white bg-blue-900 rounded-lg hover:bg-blue-800 transition shadow-lg text-center"
                    >
                        Accéder à mon espace
                    </Link>
                    <Link
                        v-else
                        :href="route('dashboard')"
                        class="w-full sm:w-auto px-8 py-3 text-base font-medium text-white bg-blue-900 rounded-lg hover:bg-blue-800 transition shadow-lg text-center"
                    >
                        Retourner au Tableau de Bord
                    </Link>
                </div>

                <!-- Grille d'informations / Fonctionnalités clés -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-12 text-left">
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-blue-900 font-bold text-lg mb-2">📄 Suivi Simplifié</div>
                        <p class="text-sm text-slate-600">Soumettez vos demandes de congés en quelques clics et suivez leur validation en temps réel.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-blue-900 font-bold text-lg mb-2">⚡ Espace RH Efficace</div>
                        <p class="text-sm text-slate-600">Centralisation de la gestion des dossiers du personnel pour les administrateurs du cabinet.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                        <div class="text-blue-900 font-bold text-lg mb-2">🔒 Sécurité & Fiabilité</div>
                        <p class="text-sm text-slate-600">Accès restreint, authentification sécurisée et traçabilité de toutes les opérations administratives.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Pied de page / Footer -->
        <footer class="bg-white border-t border-slate-200 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 Région Haute Matsiatra - Fianarantsoa. Tous droits réservés.</p>
                <p class="mt-2 sm:mt-0">Système Intranet de Gestion Administrative</p>
            </div>
        </footer>
    </div>
</template>
