<script setup>
import {ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import EditIcon from "@/Components/EditIcon.vue";
import TrashIcon from "@/Components/TrashIcon.vue";

defineProps({
    book: {
        type: Object
    },
    question_count: {
        type: Number
    },
    question: {
        type: Object,
        required: true
    },
    previous_link: {
        type: String,
        required: true
    },
    next_link: {
        type: String,
        required: true
    }
});

const open = ref(false)

const deleteQuestion = (question) => {
    if (!confirm(`「${question.body}」を削除しますか？`)) {
        return;
    }

    router.delete(route('questions.destroy', question));
}

</script>

<template>
    <Head :title="book ? `${book.title} - 一問一答` : '一問一答'"/>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <Link v-if="book" :href="route('books.show', book)">{{ book.title }}</Link>
                <span v-else>一問一答</span>
            </h2>
        </template>
        <div class="space-y-5 mb-5">
            <section>
                <div class="relative">
                    <div v-if="book" class="font-light text-base text-gray-500">{{ question.default_order }}問目
                        (全{{ question_count }}問)
                    </div>
                    <h2 class="font-bold text-xl ">問題文</h2>
                    <div v-if="$page.props.auth.user" class="absolute right-0 top-0">
                        <div class="flex">
                            <EditIcon v-if="question.can.update" :href="route('questions.edit', question)"/>
                            <button v-if="question.can.delete" @click="deleteQuestion(question)">
                                <TrashIcon route="questions.destroy" :id="question.id"/>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg mt-2 p-6">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto ">
                            {{ question.body }}
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="relative"
                @close.stop="open = false"
            >
                <div class="flex items-center">
                    <h2 class="font-bold text-xl mr-5">答え</h2>
                    <button @click="open = !open" class="bg-white p-1 rounded-xl">表示切替</button>
                </div>

                <Transition class="mt-2 bg-white shadow rounded-lg p-6">
                    <p v-if="open" v-html="question.answer"></p>
                </Transition>
            </section>

            <section class="flex items-center justify-between">
                <div v-if="!book">
                    <Link class="text-blue-600" :href="route('questions.index')">問題一覧に戻る</Link>
                </div>
                <div class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    <Link v-if="previous_link" :href="previous_link" rel="prev"
                          class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                          aria-label="前へ">
                        前へ
                    </Link>
                    <span v-else id="previous" aria-disabled="true" aria-label="前へ">
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                                aria-hidden="true">
                                前へ
                            </span>
                        </span>

                    <Link v-if="next_link" :href="next_link" rel="next"
                          class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                          aria-label="次へ">
                        次へ
                    </Link>
                    <span v-else id="next" aria-disabled="true" aria-label="次へ">
                            <span
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                                aria-hidden="true">
                                次へ
                            </span>
                        </span>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
