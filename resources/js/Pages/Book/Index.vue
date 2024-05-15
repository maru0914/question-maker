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

        <div v-if="$page.props.auth.user" class="flex justify-end mb-2">
            <CreateIcon :href="route('books.create')"/>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <Panel v-for="book in books.data" :key="book.id" class="relative">
                <Link :href="route('books.show', book.id)" class="absolute inset-0"></Link>
                <div class="flex flex-col w-full h-full">
                    <div class="flex items-center my-auto">
                        <img class="max-h-40 mx-auto " :src="'/storage/' + book.image_path" alt="">
                    </div>
                    <h2 class="font-medium mt-auto text-lg text-center">{{ book.title }}</h2>
                    <div class="text-black/30 text-xs text-end -mr-2">
                        by {{ book.user.username }}
                    </div>
                </div>
            </Panel>
        </div>
        <Pagination v-if="hasMultiplePages" :meta="books.meta"/>
    </AppLayout>
</template>
