<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    href: {
        type: String,
        required: true
    },
    type: {
        type: String,
        required: true
    }
})

const text = computed(() => props.type === 'previous' ? '前へ' : '次へ')

</script>

<template>
    <Link :href="href"
          class="items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
    >
        {{ text }}
    </Link>
</template>
