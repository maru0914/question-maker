<script setup>
defineProps({
    title: {
        type: String,
    },
});
</script>

<template>
    <div class='bg-white rounded-lg shadow p-4 space-y-2'>
        <h2 v-if="title" class="font-medium text-lg">{{ title }}</h2>
        <slot/>
    </div>
</template>

