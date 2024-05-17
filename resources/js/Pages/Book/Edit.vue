<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    book: {
        type: Object,
        required: true
    }
});

const form = useForm({
    _method: 'PATCH',
    title: props.book.title,
    description: props.book.description,
    image: null,
});

const currentImagePath = ref(`/storage/${props.book.image_path}`)

const imagePreview = ref(currentImagePath.value);
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
    imagePreview.value = currentImagePath.value;
    if (imageInput.value?.value) {
        imageInput.value.value = null;
    }
};

const selectNewImage = () => {
    imageInput.value.click();
};

const submit = () => {
    if (imageInput.value) {
        form.image = imageInput.value.files[0]
    }

    // multipartで送る必要があるためpostでリクエスト
    form.post(route('books.update', props.book.id));
};

</script>
<template>
    <Head :title="`${book.title} - 編集`"/>
    <AppLayout>
        <template #header>{{ book.title }} - 編集</template>
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

                <div v-show="imagePreview" class="mt-1">
                    <img :src="imagePreview"
                         class="object-cover rounded border border-gray-200 max-h-48 max-w-96"
                         alt='book-logo'
                    >
                </div>

                <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewImage">
                    画像を選択
                </SecondaryButton>

                <SecondaryButton
                    v-show="imagePreview !== currentImagePath"
                    type="button"
                    class="mt-2"
                    @click.prevent="resetImage"
                >
                    リセット
                </SecondaryButton>

                <InputError :message="form.errors.image" class="mt-2"/>
            </div>
            <div class="flex justify-end">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    更新
                </PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>

