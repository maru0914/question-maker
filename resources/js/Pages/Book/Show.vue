<script setup>
import CancelButton from '@/Components/CancelButton.vue';
import CreateIcon from '@/Components/CreateIcon.vue';
import EditIcon from '@/Components/EditIcon.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import LargeButton from '@/Components/LargeButton.vue';
import Panel from '@/Components/Panel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SectionHeading from '@/Components/SectionHeading.vue';
import TextArea from '@/Components/TextArea.vue';
import TrashIcon from '@/Components/TrashIcon.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { formatDatetime } from '@/Utilities/date.js';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    book: {
        type: Object,
        required: true,
    },
    questions: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    book_id: props.book.id,
    body: '',
    answer: '',
});

const deleteBook = (book) => {
    if (!confirm(`「${book.title}」を削除しますか？`)) {
        return;
    }

    router.delete(route('books.destroy', book));
};

const showResult = (challenge) => {
    if (challenge === null) {
        return '-';
    }
    if (challenge.is_success) {
        return '✅';
    }
    return '❌';
};

const showDatetime = (challenge) => {
    if (challenge === null) {
        return '-';
    }
    return formatDatetime(challenge.created_at);
};

const startBook = () => {
    localStorage.removeItem(`books.${props.book.id}.results`);
    router.get(route('questions.show', [props.questions[0]]));
};

const createQuestion = () => {
    form.post(route('questions.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // ページ最下部へスクロール
            let elm = document.documentElement;
            let bottom = elm.scrollHeight - elm.clientHeight;
            window.scroll(0, bottom);

            form.reset();
        },
    });
};

const deleteQuestion = (question) => {
    if (!confirm(`「${question.body}」を削除しますか？`)) {
        return;
    }

    router.delete(route('questions.destroy', question));
};

const showForm = ref(false);
</script>
<template>
    <Head :title="book.title" />
    <AppLayout>
        <template #header>{{ book.title }}</template>
        <div class="space-y-6">
            <section
                class="relative rounded-md border border-gray-200 bg-white/30 shadow"
            >
                <div
                    v-if="$page.props.auth.user"
                    class="absolute right-0 top-0"
                >
                    <div class="flex">
                        <Link
                            v-if="book.can.update"
                            :href="route('books.edit', book)"
                        >
                            <EditIcon />
                        </Link>
                        <button
                            v-if="book.can.delete"
                            @click="deleteBook(book)"
                        >
                            <TrashIcon route="books.destroy" :id="book.id" />
                        </button>
                    </div>
                </div>

                <div class="grid items-center sm:grid-cols-3 sm:gap-10">
                    <div
                        class="flex h-full items-center rounded-md bg-white p-5"
                    >
                        <img
                            class="mx-auto max-h-48"
                            :src="'/storage/' + book.image_path"
                            alt=""
                        />
                    </div>
                    <div class="p-4 sm:col-span-2">
                        <p
                            v-text="book.description"
                            class="text-md whitespace-pre-line"
                        ></p>
                    </div>
                </div>
            </section>

            <section v-if="questions.length !== 0" class="text-center">
                <span
                    @click="startBook"
                    :href="route('questions.show', [questions[0]])"
                >
                    <LargeButton class="text-xl"> 問題集を始める </LargeButton>
                </span>
                <p v-if="!$page.props.auth.user" class="mt-2 text-sm">
                    ※
                    <Link class="text-indigo-500" :href="route('login')"
                        >ログイン</Link
                    >
                    すると問題の正誤を記録できます。
                </p>
            </section>

            <section class="space-y-2">
                <SectionHeading>
                    問題一覧
                    <span class="text-sm">(全{{ questions.length }}問)</span>
                </SectionHeading>

                <div
                    v-if="questions.length !== 0"
                    class="relative shadow-md sm:rounded-lg"
                >
                    <table
                        class="w-full border border-gray-100 text-left text-sm text-gray-500 rtl:text-right"
                    >
                        <thead
                            class="bg-gray-50 text-xs uppercase text-gray-700"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">問題文</th>
                                <th
                                    v-if="$page.props.auth.user"
                                    scope="col"
                                    class="px-6 py-3"
                                >
                                    前回結果
                                </th>
                                <th
                                    v-if="$page.props.auth.user"
                                    scope="col"
                                    class="px-6 py-3"
                                >
                                    前回日時
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="question in questions"
                                :key="question.id"
                                class="border-b bg-white hover:bg-gray-50"
                            >
                                <td class="px-6 py-4">
                                    <Link
                                        class="inline-block py-2 text-blue-600"
                                        :href="
                                            route('questions.show', question.id)
                                        "
                                    >
                                        {{ question.body }}
                                    </Link>
                                </td>
                                <td
                                    v-if="$page.props.auth.user"
                                    class="px-6 py-4"
                                >
                                    {{ showResult(question.latest_challenge) }}
                                </td>
                                <td
                                    v-if="$page.props.auth.user"
                                    class="relative px-6 py-4"
                                >
                                    {{
                                        showDatetime(question.latest_challenge)
                                    }}
                                    <button
                                        v-if="question.can.delete"
                                        class="absolute right-1 top-0"
                                        @click="deleteQuestion(question)"
                                    >
                                        <TrashIcon />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p v-if="questions.length === 0 && !book.can.update">
                    この問題集にはまだ問題が登録されていません！<br />
                    問題が登録されるのを待ちましょう！
                </p>

                <div
                    v-if="book.can.update"
                    class="ml-5 inline-block cursor-pointer"
                >
                    <CreateIcon @click="showForm = true" v-if="!showForm" />
                </div>

                <div v-if="showForm">
                    <Panel>
                        <form @submit.prevent="createQuestion">
                            <div>
                                <InputLabel for="body" value="問題文" />
                                <TextArea
                                    id="body"
                                    type="text"
                                    class="mt-1 block w-full"
                                    rows="1"
                                    v-model="form.body"
                                    required
                                    autofocus
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.body"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="answer" value="答え" />
                                <TextArea
                                    id="answer"
                                    type="text"
                                    class="mt-1 block w-full"
                                    rows="4"
                                    v-model="form.answer"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.answer"
                                />
                            </div>
                            <div class="mt-4 flex justify-end gap-2">
                                <CancelButton @click="showForm = false">
                                    キャンセル
                                </CancelButton>
                                <PrimaryButton>
                                    新しい問題を追加
                                </PrimaryButton>
                            </div>
                        </form>
                    </Panel>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
