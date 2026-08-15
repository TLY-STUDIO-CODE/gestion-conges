<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    employee: Object,
    departments: Array,
});

const form = useForm({
    first_name: props.employee.first_name,
    last_name: props.employee.last_name,
    email: props.employee.email,
    department_id: props.employee.department_id,
    hire_date: props.employee.hire_date,
    leave_balance: props.employee.leave_balance,
});

const submit = () => {
    form.put(route('employees.update', props.employee.id));
};
</script>

<template>
    <Head title="Modifier un Employé" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifier l'employé : {{ employee.first_name }} {{ employee.last_name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="first_name" value="Prénom" />
                                <TextInput id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" required autofocus />
                                <InputError class="mt-2" :message="form.errors.first_name" />
                            </div>

                            <div>
                                <InputLabel for="last_name" value="Nom" />
                                <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" required />
                                <InputError class="mt-2" :message="form.errors.last_name" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email professionnel" />
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                            <InputLabel for="department_id" value="Département" />
                            <select id="department_id" v-model="form.department_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option v-for="department in departments" :key="department.id" :value="department.id">
                                    {{ department.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.department_id" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="hire_date" value="Date d'embauche" />
                                <TextInput id="hire_date" type="date" class="mt-1 block w-full" v-model="form.hire_date" required />
                                <InputError class="mt-2" :message="form.errors.hire_date" />
                            </div>

                            <div>
                                <InputLabel for="leave_balance" value="Solde de congés (jours)" />
                                <TextInput id="leave_balance" type="number" class="mt-1 block w-full" v-model="form.leave_balance" required />
                                <InputError class="mt-2" :message="form.errors.leave_balance" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Mettre à jour
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
