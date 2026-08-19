<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header class="border-b border-gray-100 pb-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 tracking-tight">
                        Mettre à jour le mot de passe
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Assurez-vous d'utiliser un mot de passe long et aléatoire pour sécuriser votre compte.
                    </p>
                </div>
            </div>
        </header>

        <form @submit.prevent="updatePassword" class="space-y-5">
            <div>
                <InputLabel for="current_password" value="Mot de passe actuel" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    autocomplete="current-password"
                />

                <InputError
                    :message="form.errors.current_password"
                    class="mt-1.5 text-xs text-rose-600"
                />
            </div>

            <div>
                <InputLabel for="password" value="Nouveau mot de passe" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    autocomplete="new-password"
                />

                <InputError :message="form.errors.password" class="mt-1.5 text-xs text-rose-600" />
            </div>

            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirmer le mot de passe"
                    class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1"
                />

                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    autocomplete="new-password"
                />

                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-1.5 text-xs text-rose-600"
                />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <PrimaryButton class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl font-medium text-sm shadow-sm transition-all" :disabled="form.processing">Enregistrer</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-xs font-medium text-emerald-600"
                    >
                        Enregistré.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
