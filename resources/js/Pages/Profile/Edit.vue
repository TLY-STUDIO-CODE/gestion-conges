<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Paramètres du Profil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Paramètres globaux</span>
                    <h2 class="font-bold text-2xl text-gray-900 tracking-tight mt-0.5">
                        Mon Profil
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Gérez vos informations personnelles et paramètres de sécurité.</p>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    class="bg-white p-6 sm:p-8 border border-gray-100 shadow-xs rounded-2xl transition-all"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="bg-white p-6 sm:p-8 border border-gray-100 shadow-xs rounded-2xl transition-all"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="bg-white p-6 sm:p-8 border border-gray-100 shadow-xs rounded-2xl transition-all border-rose-100/60"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
