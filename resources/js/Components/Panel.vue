<script setup>
defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <div class="space-y-2 rounded-lg bg-white p-4 shadow">
        <h2 v-if="title" class="text-lg font-medium">{{ title }}</h2>
        <slot />
    </div>
</template>
