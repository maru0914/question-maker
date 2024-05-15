<template>
    <div class="flex items-center justify-between border-t border-gray-200 py-3">
        <div class="flex flex-1 justify-between sm:hidden">
            <Link v-if="previousPageUrl" :href="previousPageUrl"
                  class="relative inline-flex items-center rounded-md border border-gray-300 disabled:cursor-none bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                前へ
            </Link>
            <span v-else
                  class="relative inline-flex items-center rounded-md border border-gray-300 disabled:cursor-none bg-white/20 px-4 py-2 text-sm font-medium text-gray-400">
                前へ
            </span>
            <Link v-if="nextPageUrl"
                  :href="nextPageUrl"
                  class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                次へ
            </Link>
            <span v-else
                  class="relative inline-flex items-center rounded-md border border-gray-300 disabled:cursor-none bg-white/20 px-4 py-2 text-sm font-medium text-gray-400">
                次へ
            </span>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    <span class="font-medium">{{ meta.total }}</span>
                    件中
                    <span class="font-medium">{{ meta.from }}</span>
                    件目から
                    <span class="font-medium">{{ meta.to }}</span>
                    件目を表示
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px shadow-sm" aria-label="Pagination">
                    <template v-for="link in meta.links">
                        <Link v-if="link.url"
                              :href="link.url"
                              class="relative inline-flex items-center px-3 py-2 first:rounded-l-md last:rounded-r-md"
                              :class="{
                                    'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.active,
                                    'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0': !link.active
                          }"
                              v-html="link.label"
                        >
                        </Link>
                        <span
                            v-else
                            v-html="link.label"
                            class="relative inline-flex bg-gray-200 items-center px-3 py-2 text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0 first:rounded-l-md last:rounded-r-md"
                            :class="{
                            'rounded-l-md': link.label === '&laquo; 前',
                            'rounded-r-md': link.label === '&laquo; 次'
                        }"
                        >
                    </span>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    meta: {
        type: Object,
        required: true
    }
});

const previousPageUrl = computed(() => props.meta.links[0].url ?? '')
const nextPageUrl = computed(() => [...props.meta.links].reverse()[0].url ?? '')

</script>
