<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Connexion" />

        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Connexion à votre espace</h2>
            <p class="text-xs text-gray-500 mt-1">Entrez vos identifiants pour accéder à votre plateforme.</p>
        </div>

        <div v-if="status" class="mb-4 text-xs font-medium text-emerald-600 bg-emerald-50 border border-emerald-200/60 p-3 rounded-xl">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-4">
            <div>
                <InputLabel for="email" value="Adresse E-mail" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-1.5 text-xs text-rose-600" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="password" value="Mot de passe" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-1.5 text-xs text-rose-600" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                    <span class="ms-2 text-xs text-gray-600 font-medium">Se souvenir de moi</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800 focus:outline-none"
                >
                    Mot de passe oublié ?
                </Link>
            </div>

            <div class="pt-2">
                <PrimaryButton
                    class="w-full justify-center py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl font-medium text-sm shadow-sm transition-all"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Se connecter
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
