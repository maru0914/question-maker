<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {nextTick, ref} from 'vue';

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

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">アカウントを削除</h2>

            <p class="mt-1 text-sm text-gray-600">
                アカウントを削除すると、全てのデータとファイルも完全に削除されます。アカウントを削除する前に必要なデータがあれば事前にダウンロードの実施をお願いします。
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">アカウントを削除</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    アカウントを削除して本当に大丈夫ですか？
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    アカウントを削除して本当に大丈夫ですか？アカウントを削除すると、全てのデータとファイルも完全に削除されます。完全にアカウントを削除するためには、確認のために再度パスワードを入力してください。
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only"/>

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2"/>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> キャンセル</SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        アカウントを削除
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
