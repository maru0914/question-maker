<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
    <Head title='問題集作成'/>
    <AppLayout>
        <template #header>問題集作成</template>
        <form @submit.prevent="submit">
            <div class="flex flex-col justify-center">
                <InputLabel for="title" value="タイトル"/>

                <TextInput
                    id="title"
                    type="text"
                    class="block mt-1 w-full"
                    v-model="form.title"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="説明文"/>

                <TextArea
                    id="description"
                    type="text"
                    class="block mt-1 w-full"
                    rows="4"
                    v-model="form.description"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <div class="mt-4">
                <input
                    ref="imageInput"
                    type="file"
                    class="hidden"
                    @change="updateImagePreview"
                >

                <InputLabel for="image" value="画像"/>

                <div v-show="! imagePreview" class="mt-1">
                    <div
                        class="border rounded border-gray-200 bg-gray-100"
                        style="width: 200px; height: 200px;"
                    ></div>
                </div>

                <div v-show="imagePreview" class="mt-2">
                    <img :src="imagePreview"
                         class="object-cover rounded border border-gray-200 max-h-48 max-w-96"
                         alt='book-logo'
                    >
                </div>

                <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewImage">
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

                <InputError :message="form.errors.image" class="mt-2"/>
            </div>
            <div class="flex items-center justify-between mt-4">
                <Link
                    class="text-blue-600"
                    :href="route('books.index')">
                    問題集一覧に戻る
                </Link>
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    作成
                </PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>

