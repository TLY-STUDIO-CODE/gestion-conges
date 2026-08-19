<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-4">
        <header class="border-b border-gray-100 pb-4 mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-900 tracking-tight">
                        Supprimer le Compte
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">
                        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                    </p>
                </div>
            </div>
        </header>

        <DangerButton @click="confirmUserDeletion" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 active:bg-rose-800 rounded-xl font-medium text-xs shadow-xs transition-all">Supprimer le compte</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-bold text-gray-900 tracking-tight"
                >
                    Êtes-vous sûr de vouloir supprimer votre compte ?
                </h2>

                <p class="mt-2 text-xs text-gray-500 leading-relaxed">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement perdues. Veuillez entrer votre mot de passe pour confirmer la suppression définitive de votre compte.
                </p>

                <div class="mt-5">
                    <InputLabel
                        for="password"
                        value="Mot de passe"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full rounded-xl border-gray-200 shadow-xs focus:border-rose-500 focus:ring-rose-500 text-sm py-2.5"
                        placeholder="Entrez votre mot de passe"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-1.5 text-xs text-rose-600" />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="closeModal" class="px-4 py-2.5 rounded-xl border-gray-200 text-xs font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </SecondaryButton>

                    <DangerButton
                        class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 rounded-xl text-xs font-medium shadow-xs"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Supprimer définitivement
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
