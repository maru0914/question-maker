<script setup>
import CreateIcon from '@/Components/CreateIcon.vue';
import Pagination from '@/Components/Pagination.vue';
import Panel from '@/Components/Panel.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    books: {
        type: Object,
        required: true,
    },
});

const hasMultiplePages = computed(
    () => props.books.meta.total > props.books.meta.per_page,
);
</script>

<template>
    <Head title="問題集一覧" />
    <AppLayout>
        <template #header>問題集一覧</template>
        <template #subtitle
            >好きな問題集を選んで、知識を身につけましょう！
            <p v-if="!$page.props.auth.user" class="mt-2 text-sm">
                ※<Link class="text-indigo-500" :href="route('login')"
                    >ログイン</Link
                >すると問題集の作成や解いた問題の正誤を記録できます!
            </p>
        </template>

        <div v-if="$page.props.auth.user" class="mb-2 flex justify-end">
            <Link :href="route('books.create')">
                <CreateIcon />
            </Link>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <Panel
                v-for="book in books.data"
                :key="book.id"
                class="relative duration-300 hover:scale-[1.01] hover:shadow-lg"
            >
                <Link
                    :href="route('books.show', book.id)"
                    class="absolute inset-0"
                ></Link>
                <div class="flex h-full w-full flex-col">
                    <div class="my-auto flex items-center">
                        <img
                            class="mx-auto max-h-40"
                            :src="'/storage/' + book.image_path"
                            alt=""
                        />
                    </div>
                    <h2 class="mt-auto text-center text-lg">
                        {{ book.title }}
                    </h2>
                    <div class="-mr-2 text-end text-xs text-black/30">
                        by {{ book.user.username }}
                    </div>
                </div>
            </Panel>
        </div>
        <Pagination v-if="hasMultiplePages" :meta="books.meta" />
    </AppLayout>
</template>
