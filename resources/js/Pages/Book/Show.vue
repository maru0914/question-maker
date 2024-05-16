<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import EditIcon from "@/Components/EditIcon.vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import SecondaryLInk from "@/Components/SecondaryLInk.vue";
import SectionHeading from "@/Components/SectionHeading.vue";
import CreateIcon from "@/Components/CreateIcon.vue";

defineProps({
    book: {
        type: Object,
        required: true
    },
    questions: {
        type: Array,
        required: true
    }
});

const deleteBook = (book) => {
    if (!confirm(`「${book.title}」を削除しますか？`)) {
        return;
    }

    router.delete(route('books.destroy', book));
}

const deleteQuestion = (question) => {
    if (!confirm(`「${question.body}」を削除しますか？`)) {
        return;
    }

    router.delete(route('questions.destroy', question));
}


</script>
<template>
    <Head :title="book.title"/>
    <AppLayout>
        <div class="space-y-6">
            <section class="relative border border-gray-200 shadow rounded-md bg-white/30">
                <div v-if="$page.props.auth.user" class="absolute right-0 top-0">
                    <div class="flex">
                        <EditIcon v-if="book.can.update" :href="route('books.edit', book)"/>
                        <button v-if="book.can.delete" @click="deleteBook(book)">
                            <TrashIcon route="books.destroy" :id="book.id"/>
                        </button>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 sm:gap-10 items-center">
                    <div class="bg-white p-5 rounded-md h-full flex items-center">
                        <img class="max-h-48 mx-auto" :src="'/storage/' + book.image_path" alt="">
                    </div>
                    <div class="sm:col-span-2 p-4">
                        <p v-html="book.description" class="text-md"></p>
                    </div>
                </div>
            </section>

            <section>
                <SecondaryLInk v-if="questions.length !==0"
                               :href="route('questions.show', [questions[0]])"
                >
                    問題集を始める
                </SecondaryLInk>
            </section>


            <section class="space-y-2">
                <SectionHeading>
                    問題一覧 <span class="text-sm">(全{{ questions.length }}問)</span>
                </SectionHeading>

                <div v-if="questions.length !==0"
                     class="bg-white shadow rounded-lg pl-5 sm:pl-6">
                    <ul role="list" class="divide-y divide-gray-100">
                        <li v-for="question in questions" :key="question.id" class="relative">
                            <button v-if="question.can.delete"
                                    class="absolute right-0"
                                    @click="deleteQuestion(question)">
                                <TrashIcon/>
                            </button>

                            <Link
                                class="inline-block text-blue-600 py-2"
                                :href="route('questions.show', question.id)">
                                {{ question.body }}
                            </Link>
                        </li>
                    </ul>
                </div>
                <p v-if="questions.length === 0 && !book.can.update">
                    この問題集にはまだ問題が登録されていません！<br>
                    問題が登録されるのを待ちましょう！
                </p>

                <div v-if="book.can.update" class="ml-5">
                    <CreateIcon :href="route('questions.create', { book_id: book.id })"/>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
