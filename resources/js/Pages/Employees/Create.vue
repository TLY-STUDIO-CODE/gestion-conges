<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

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
    <Head title="Ajouter un Employé" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ajouter un nouvel employé</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Prénom -->
                            <div>
                                <InputLabel for="first_name" value="Prénom" />
                                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus />
                                <InputError class="mt-2" :message="form.errors.first_name" />
                            </div>

                            <!-- Nom -->
                            <div>
                                <InputLabel for="last_name" value="Nom" />
                                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required />
                                <InputError class="mt-2" :message="form.errors.last_name" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <InputLabel for="email" value="Email professionnel" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <!-- Département -->
                        <div>
                            <InputLabel for="department_id" value="Département" />
                            <select id="department_id" v-model="form.department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled>Sélectionnez un département</option>
                                <option v-for="department in departments" :key="department.id" :value="department.id">
                                    {{ department.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>

                        <!-- Date d'embauche -->
                        <div>
                            <InputLabel for="hire_date" value="Date d'embauche" />
                            <TextInput id="hire_date" type="date" class="mt-1 block w-full" v-model="form.hire_date" required />
                            <InputError class="mt-2" :message="form.errors.hire_date" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Sauvegarder l'employé
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
