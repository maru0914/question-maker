<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import CreateIcon from "@/Components/CreateIcon.vue";
import EditIcon from "@/Components/EditIcon.vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    questions: {
        type: Object,
        required: true
    },
});

const deleteQuestion = (question) => {
    if (!confirm(`「${question.body}」を削除しますか？`)) {
        return;
    }

    router.delete(route('questions.destroy', question));
}

</script>

<template>
    <AppLayout>
        <Head title="問題一覧"/>
        <template #header>問題一覧</template>

        <div v-if="$page.props.auth.user" class="flex justify-end mb-2">
            <CreateIcon :href="route('questions.create')"/>
        </div>

        <div class="bg-white shadow rounded-lg px-5 sm:px-6">
            <ul role="list" class="divide-y divide-gray-100">
                <li v-for="question in questions.data" :key="question.id">
                    <div class="flex justify-between items-center">
                        <div class="text-blue-600 pt-4">
                            <Link :href="route('questions.show', question)">
                                {{ question.body }}
                            </Link>
                        </div>
                        <div v-if="$page.props.auth.user" class="flex justify-end self-start py-2 text-sm leading-6 gap-1">
                            <EditIcon v-if="question.can.update" :href="route('questions.edit', question)"/>
                            <button v-if="question.can.delete" @click="deleteQuestion(question)">
                                <TrashIcon/>
                            </button>
                        </div>
                    </div>
                    <div class="text-black/30 text-xs text-end">
                        by {{ question.user.username }}
                    </div>
                </li>
            </ul>
        </div>
        <Pagination :meta="questions.meta"/>
    </AppLayout>

</template>


