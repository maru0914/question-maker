<script setup>
import {computed, ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import EditIcon from "@/Components/EditIcon.vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import QuestionDetail from "@/Components/QuestionDetail.vue";
import QuestionEditingForm from "@/Components/QuestionEditingForm.vue";


const props = defineProps({
    questions_count: {
        type: Number
    },
    question: {
        type: Object,
        required: true
    },
    previous_link: {
        type: String,
        required: false,
        default: null
    },
    next_link: {
        type: String,
        required: false,
        default: null
    }
});

const editing = ref(false)

const book = computed(() => props.question.book)

const deleteQuestion = (question) => {
    if (!confirm(`「${question.body}」を削除しますか？`)) {
        return;
    }

    router.delete(route('questions.destroy', question));
}

</script>

<template>
    <Head :title="`${book.title} - 一問一答`"/>
    <AppLayout>
        <template #header>
            <Link :href="route('books.show', book)">{{ book.title }}</Link>
        </template>
        <div class="mb-5">
            <section>
                <div class="relative">
                    <div class="text-base text-gray-500">
                        {{ question.default_order }}問目 (全{{ questions_count }}問)
                    </div>
                    <div v-if="$page.props.auth.user" class="absolute right-0 top-0">
                        <div class="flex">
                            <button
                                v-if="question.can.update && !editing"
                                @click="editing = true"
                                type="button"
                            >
                                <EditIcon/>
                            </button>
                            <button v-if="question.can.delete" @click="deleteQuestion(question)">
                                <TrashIcon/>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <QuestionDetail v-if="!editing"
                            class="mt-4"
                            :question="question"
                            :questions_count="questions_count"
                            :previous_link="previous_link"
                            :next_link="next_link"
            />
            <QuestionEditingForm v-else
                                 class="mt-4"
                                 :question="question"
                                 @cancel="editing = false"
                                 @updated="editing = false"
            />
        </div>
    </AppLayout>
</template>
