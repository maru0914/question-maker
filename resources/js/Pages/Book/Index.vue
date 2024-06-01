<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import CreateIcon from "@/Components/CreateIcon.vue";
import Panel from "@/Components/Panel.vue";
import Pagination from "@/Components/Pagination.vue";
import {computed} from "vue";


const props = defineProps({
    books: {
        type: Object,
        required: true
    },
});

const hasMultiplePages = computed(() => props.books.meta.total > props.books.meta.per_page);

</script>

<template>
    <Head title="問題集一覧"/>
    <AppLayout>
        <template #header>問題集一覧</template>
        <template #subtitle>好きな問題集を選んで、知識を身につけましょう！
            <p v-if="!$page.props.auth.user" class="mt-2 text-sm">
                ※<Link class="text-indigo-500" :href="route('login')">ログイン</Link>すると問題集の作成や解いた問題の正誤を記録できます!
            </p>
        </template>

        <div v-if="$page.props.auth.user" class="flex justify-end mb-2">
            <Link :href="route('books.create')">
                <CreateIcon />
            </Link>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <Panel v-for="book in books.data" :key="book.id" class="relative border border-gray-200 rounded-lg hover:scale-105 hover:shadow-lg transition-transform duration-300 ease-in-out">
                <Link :href="route('books.show', book.id)" class="absolute inset-0"></Link>
                <div class="flex flex-col w-full h-full p-4">
                    <div class="flex items-center justify-center mb-4">
                        <img class="max-h-40" :src="'/storage/' + book.image_path" alt="">
                    </div>
                    <h2 class="text-lg text-center mb-2">{{ book.title }}</h2>
                    <div class="text-gray-500 text-xs text-right">
                        by {{ book.user.username }}
                    </div>
                </div>
            </Panel>
        </div>
        <Pagination v-if="hasMultiplePages" :meta="books.meta"/>
    </AppLayout>
</template>
