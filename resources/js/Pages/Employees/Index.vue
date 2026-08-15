<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    employees: Array,
    departments: Array,
});
</script>

<template>
    <Head title="Gestion des Employés" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gestion des Employés & Congés
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Liste des Salariés</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">Nom & Prénom</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Département</th>
                                    <th class="px-6 py-3">Solde Congés</th>
                                    <th class="px-6 py-3">Embauche</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="emp in employees" :key="emp.id">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ emp.last_name }} {{ emp.first_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ emp.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ emp.department ? emp.department.name : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-bold">{{ emp.leave_balance }} jours</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ emp.hire_date }}</td>
                                </tr>
                                <tr v-if="employees.length === 0">
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun employé trouvé.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
