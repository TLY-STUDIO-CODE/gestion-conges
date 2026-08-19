<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    employees: Array,
    leaveTypes: Array,
});

const form = useForm({
    employee_id: '',
    leave_type_id: '',
    start_date: '',
    end_date: '',
    reason: '',
});

const submit = () => {
    form.post(route('leave-requests.store'));
};
</script>

<template>
    <Head title="Nouvelle Demande de Congé" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">Soumettre une demande de congé</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Remplissez le formulaire ci-dessous pour enregistrer une nouvelle requête.</p>
                </div>
                <Link :href="route('leave-requests.index')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Retour à la liste</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">

                    <div class="mb-6 pb-4 border-b border-gray-100">
                        <h3 class="font-bold text-lg text-gray-900 tracking-tight">Informations de la requête</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Tous les champs obligatoires doivent être renseignés.</p>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Collaborateur -->
                        <div>
                            <InputLabel for="employee_id" value="Collaborateur concerné" class="text-gray-700 font-medium text-xs uppercase tracking-wider mb-1.5" />
                            <select id="employee_id" v-model="form.employee_id" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" required>
                                <option value="" disabled>Sélectionnez un collaborateur</option>
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.first_name }} {{ emp.last_name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.employee_id" />
                        </div>

                        <!-- Type de congé -->
                        <div>
                            <InputLabel for="leave_type_id" value="Type de congé" class="text-gray-700 font-medium text-xs uppercase tracking-wider mb-1.5" />
                            <select id="leave_type_id" v-model="form.leave_type_id" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" required>
                                <option value="" disabled>Sélectionnez un type de congé</option>
                                <option v-for="type in leaveTypes" :key="type.id" :value="type.id">
                                    {{ type.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.leave_type_id" />
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="start_date" value="Date de début" class="text-gray-700 font-medium text-xs uppercase tracking-wider mb-1.5" />
                                <TextInput id="start_date" type="date" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" v-model="form.start_date" required />
                                <InputError class="mt-2" :message="form.errors.start_date" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="Date de fin" class="text-gray-700 font-medium text-xs uppercase tracking-wider mb-1.5" />
                                <TextInput id="end_date" type="date" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white rounded-xl shadow-sm text-sm py-2.5 px-3.5 transition-all" v-model="form.end_date" required />
                                <InputError class="mt-2" :message="form.errors.end_date" />
                            </div>
                        </div>

                        <!-- Motif -->
                        <div>
                            <InputLabel for="reason" value="Motif (optionnel)" class="text-gray-700 font-medium text-xs uppercase tracking-wider mb-1.5" />
                            <textarea id="reason" v-model="form.reason" class="mt-1 block w-full border-gray-200 bg-gray-50/50 focus:bg-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm p-3.5 transition-all" rows="3" placeholder="Précisez le motif de votre absence si nécessaire..."></textarea>
                            <InputError class="mt-2" :message="form.errors.reason" />
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <Link :href="route('leave-requests.index')" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                                Annuler
                            </Link>
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-sm hover:shadow transition-all duration-150">
                                Soumettre la demande
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
