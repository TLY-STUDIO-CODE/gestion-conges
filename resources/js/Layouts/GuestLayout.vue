<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-slate-100 py-12 px-4 sm:px-6 lg:px-8 selection:bg-blue-900 selection:text-white"
    >
        <div
            class="w-full overflow-hidden bg-white px-8 py-8 shadow-xl sm:max-w-md sm:rounded-xl border border-slate-200"
        >
            <!-- Logo et En-tête Institutionnel intégrés dans la carte -->
            <div class="flex flex-col items-center mb-6 pb-6 border-b border-slate-100 text-center">
                <Link href="/" class="mb-3 focus:outline-none focus:ring-2 focus:ring-blue-900 rounded-lg">
                    <ApplicationLogo class="h-16 w-16 fill-current text-slate-800" />
                </Link>
                <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                    Région Haute Matsiatra
                </h2>
                <p class="text-xs text-slate-500 font-medium">
                    Cabinet du Gouverneur • Fianarantsoa
                </p>
            </div>

            <!-- Contenu du formulaire (Login / Register) -->
            <slot />
        </div>

        <!-- Petit pied de page discret sous le formulaire -->
        <div class="mt-6 text-center text-xs text-slate-400">
            &copy; 2026 Région Haute Matsiatra - Portail Officiel
        </div>
    </div>
</template>
