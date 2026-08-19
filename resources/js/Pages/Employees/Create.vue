<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// On récupère les départements envoyés par le contrôleur
defineProps({
    departments: Array,
});

// Initialisation du formulaire Inertia
const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    department_id: '',
    hire_date: '',
});

const submit = () => {
    form.post(route('employees.store'));
};
</script>

<template>
    <Head title="Ajouter un Collaborateur" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                        Ajouter un collaborateur
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Enregistrez un nouveau profil salarié dans l'annuaire de l'entreprise.</p>
                </div>
                <Link :href="route('employees.index')" class="inline-flex items-center space-x-2 px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 font-medium text-sm rounded-xl border border-gray-200 shadow-sm transition-all duration-150">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Retour à l'annuaire</span>
                </Link>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden p-8">

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prénom -->
                            <div>
                                <InputLabel for="first_name" value="Prénom" class="text-gray-700 font-semibold" />
                                <TextInput id="first_name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" v-model="form.first_name" required autofocus placeholder="ex: Jean" />
                                <InputError class="mt-2" :message="form.errors.first_name" />
                            </div>

                            <!-- Nom -->
                            <div>
                                <InputLabel for="last_name" value="Nom" class="text-gray-700 font-semibold" />
                                <TextInput id="last_name" type="text" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" v-model="form.last_name" required placeholder="ex: Dupont" />
                                <InputError class="mt-2" :message="form.errors.last_name" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <InputLabel for="email" value="Email professionnel" class="text-gray-700 font-semibold" />
                            <TextInput id="email" type="email" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" v-model="form.email" required placeholder="jean.dupont@entreprise.com" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Département -->
                        <div>
                            <InputLabel for="department_id" value="Département" class="text-gray-700 font-semibold" />
                            <select id="department_id" v-model="form.department_id" class="mt-1 block w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm text-sm" required>
                                <option value="" disabled>Sélectionnez un département</option>
                                <option v-for="department in departments" :key="department.id" :value="department.id">
                                    {{ department.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>

                        <!-- Date d'embauche -->
                        <div>
                            <InputLabel for="hire_date" value="Date d'embauche" class="text-gray-700 font-semibold" />
                            <TextInput id="hire_date" type="date" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" v-model="form.hire_date" required />
                            <InputError class="mt-2" :message="form.errors.hire_date" />
                        </div>

                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                            <Link :href="route('employees.index')" class="px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-semibold transition border border-gray-200 shadow-sm">
                                Annuler
                            </Link>
                            <PrimaryButton class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold shadow-sm hover:shadow transition-all duration-150" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Enregistrer le collaborateur
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
