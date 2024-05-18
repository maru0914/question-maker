<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});

</script>

<template>
    <Link :href="href" class="inline-block relative px-8 py-2 rounded-md bg-white isolation-auto z-10 border-2 border-lime-400
        before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-right-full before:hover:right-0 before:rounded-full  before:bg-lime-400 before:-z-10  before:aspect-square before:hover:scale-150 overflow-hidden before:hover:duration-700">
        <slot/>
    </Link>
</template>
