<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    employees: Array,
    departments: Array,
});

const deleteForm = useForm({});

const deleteEmployee = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet employé ?')) {
        deleteForm.delete(route('employees.destroy', id));
    }
};
</script>

<template>
    <Head title="Gestion des Collaborateurs" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                        Gestion des collaborateurs
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Pilotage, suivi des performances et organisation des équipes en temps réel</p>
                </div>
                <Link :href="route('employees.create')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Ajouter un collaborateur</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-6">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 tracking-tight">Annuaire des salariés</h3>
                            <p class="text-xs text-gray-500 mt-0.5 font-medium">{{ employees.length }} collaborateur(s)</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead>
                                <tr class="bg-gray-50/50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    <th class="py-3.5 px-6">Collaborateur</th>
                                    <th class="py-3.5 px-6">Email professionnel</th>
                                    <th class="py-3.5 px-6">Département</th>
                                    <th class="py-3.5 px-6">Solde Congés</th>
                                    <th class="py-3.5 px-6">Date d'embauche</th>
                                    <th class="py-3.5 px-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                <tr v-for="emp in employees" :key="emp.id" class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Nom avec avatar initial -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                                {{ emp.first_name ? emp.first_name.charAt(0) : '' }}{{ emp.last_name ? emp.last_name.charAt(0) : '' }}
                                            </div>
                                            <span class="font-semibold text-gray-900">{{ emp.last_name }} {{ emp.first_name }}</span>
                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-600">
                                        {{ emp.email }}
                                    </td>

                                    <!-- Département -->
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <span class="px-2.5 py-1 inline-flex items-center space-x-1.5 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>{{ emp.department ? emp.department.name : 'N/A' }}</span>
                                        </span>
                                    </td>

                                    <!-- Solde Congés -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-900 font-bold">
                                        {{ emp.leave_balance }} <span class="text-xs font-normal text-gray-500">jours</span>
                                    </td>

                                    <!-- Embauche -->
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-500 text-xs font-medium">
                                        {{ emp.hire_date }}
                                    </td>

                                    <!-- Actions unifiées et pro -->
                                    <td class="py-4 px-6 whitespace-nowrap text-right font-medium">
                                        <div class="inline-flex items-center justify-end space-x-2">
                                            <Link :href="route('employees.edit', emp.id)" class="px-3 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-semibold transition border border-indigo-200/60">Modifier</Link>
                                            <button @click="deleteEmployee(emp.id)" class="px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition border border-rose-200/60">Supprimer</button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="employees.length === 0">
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="max-w-sm mx-auto flex flex-col items-center justify-center">
                                            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 mb-3">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-700">Aucun collaborateur enregistré</p>
                                            <p class="text-xs text-gray-400 mt-1">Commencez par ajouter votre premier salarié pour alimenter l'annuaire.</p>
                                        </div>
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
