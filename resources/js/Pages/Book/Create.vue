<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    title: '',
    description: '',
    image: null,
});

const imagePreview = ref(null);
const imageInput = ref(null);

const updateImagePreview = () => {
    const image = imageInput.value.files[0];

    if (!image) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        imagePreview.value = e.target.result;
    };

    reader.readAsDataURL(image);
};

const resetImage = () => {
    imagePreview.value = null;
    if (imageInput.value?.value) {
        imageInput.value.value = null;
    }
};

const selectNewImage = () => {
    imageInput.value.click();
};

const submit = () => {
    if (imageInput.value) {
        form.image = imageInput.value.files[0];
    }

    form.post(route('books.store'));
};
</script>

<template>
    <Head title="問題集作成" />
    <AppLayout>
        <template #header>問題集作成</template>
        <form @submit.prevent="submit">
            <div class="flex flex-col justify-center">
                <InputLabel for="title" value="タイトル" />

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="説明文" />

                <TextArea
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    rows="4"
                    v-model="form.description"
                    required
                />

                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-4">
                <input
                    ref="imageInput"
                    type="file"
                    class="hidden"
                    accept="image/*"
                    @change="updateImagePreview"
                />

                <InputLabel for="image" value="画像" />

                <div v-show="!imagePreview" class="mt-1">
                    <div
                        class="rounded border border-gray-200 bg-gray-100"
                        style="width: 200px; height: 200px"
                    ></div>
                </div>

                <div v-show="imagePreview" class="mt-2">
                    <img
                        :src="imagePreview"
                        class="max-h-48 max-w-96 rounded border border-gray-200 object-cover"
                        alt="book-logo"
                    />
                </div>

                <SecondaryButton
                    class="mr-2 mt-2"
                    type="button"
                    @click.prevent="selectNewImage"
                >
                    画像を選択
                </SecondaryButton>

                <SecondaryButton
                    v-show="imagePreview"
                    type="button"
                    class="mt-2"
                    @click.prevent="resetImage"
                >
                    リセット
                </SecondaryButton>

                <InputError :message="form.errors.image" class="mt-2" />
            </div>
            <div class="flex justify-end">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    作成
                </PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>
