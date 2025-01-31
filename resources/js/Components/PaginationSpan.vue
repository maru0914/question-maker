<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
});

const text = computed(() => (props.type === 'previous' ? '前へ' : '次へ'));
</script>

<template>
    <span
        class="relative inline-flex items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium text-gray-400 disabled:cursor-none"
    >
        {{ text }}
    </span>
</template>
