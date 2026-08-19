<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header class="border-b border-gray-100 pb-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 tracking-tight">
                        Informations du Profil
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Mettez à jour les informations personnelles et l'adresse e-mail de votre compte.
                    </p>
                </div>
            </div>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="space-y-5"
        >
            <div>
                <InputLabel for="name" value="Nom complet" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-1.5 text-xs text-rose-600" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Adresse E-mail" class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-1" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-1.5 text-xs text-rose-600" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="bg-amber-50 border border-amber-200/60 p-4 rounded-xl">
                <p class="text-xs text-amber-800 leading-relaxed">
                    Votre adresse e-mail n'est pas vérifiée.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="font-semibold text-indigo-600 underline hover:text-indigo-800 focus:outline-none ml-1"
                    >
                        Cliquez ici pour renvoyer l'e-mail de vérification.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-xs font-medium text-emerald-600 flex items-center space-x-1"
                >
                    <span>Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</span>
                </div>
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
                        class="text-xs font-medium text-emerald-600 flex items-center space-x-1"
                    >
                        <span>Modifications enregistrées.</span>
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
