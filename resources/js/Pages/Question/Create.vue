<script setup>
import {Head, Link, useForm} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    books: {
        type: Array
    },
    selected_book_id: {
        type: Number,
        default: 0
    }
});


const form = useForm({
    book_id: props.selected_book_id,
    body: '',
    answer: '',
});

</script>

<template>
    <Head title="問題作成"/>
    <AppLayout>
        <template #header>問題作成</template>
        <form @submit.prevent="form.post(route('questions.store'))">
            <div>
                <InputLabel for="book" value="問題集"/>
                <div class="mt-2">
                    <select id="book"
                            name="book_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.book_id"
                    >
                        <option v-for="book in books" :value="book.id" :selected="book.id === form.book_id">
                            {{ book.title }}
                        </option>
                    </select>
                </div>
                <InputError class="mt-2" :message="form.errors.book_id"/>
            </div>

            <div class="mt-4">
                <InputLabel for="body" value="問題文"/>

                <TextArea
                    id="body"
                    type="text"
                    class="block mt-1 w-full"
                    rows="4"
                    v-model="form.body"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.body"/>
            </div>

            <div class="mt-4">
                <InputLabel for="answer" value="答え"/>

                <TextArea
                    id="answer"
                    type="text"
                    class="block mt-1 w-full"
                    rows="4"
                    v-model="form.answer"
                    required
                />

                <InputError class="mt-2" :message="form.errors.answer"/>
            </div>

            <div class="flex items-center justify-between mt-4">
                <Link class="text-blue-600" :href="route('questions.index')">
                    問題一覧に戻る
                </Link>
                <PrimaryButton class="ms-4">
                    作成
                </PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>
