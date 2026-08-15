<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Soumettre une demande de congé</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Employé -->
                        <div>
                            <InputLabel for="employee_id" value="Employé concerné" />
                            <select id="employee_id" v-model="form.employee_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled>Sélectionnez un employé</option>
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id">
                                    {{ emp.first_name }} {{ emp.last_name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.employee_id" />
                        </div>

                        <!-- Type de congé -->
                        <div>
                            <InputLabel for="leave_type_id" value="Type de congé" />
                            <select id="leave_type_id" v-model="form.leave_type_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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
                                <InputLabel for="start_date" value="Date de début" />
                                <TextInput id="start_date" type="date" class="mt-1 block w-full" v-model="form.start_date" required />
                                <InputError class="mt-2" :message="form.errors.start_date" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="Date de fin" />
                                <TextInput id="end_date" type="date" class="mt-1 block w-full" v-model="form.end_date" required />
                                <InputError class="mt-2" :message="form.errors.end_date" />
                            </div>
                        </div>

                        <!-- Motif -->
                        <div>
                            <InputLabel for="reason" value="Motif (optionnel)" />
                            <textarea id="reason" v-model="form.reason" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3"></textarea>
                            <InputError class="mt-2" :message="form.errors.reason" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Soumettre la demande
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
