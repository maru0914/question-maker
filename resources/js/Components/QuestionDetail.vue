<script setup>

import Panel from "@/Components/Panel.vue";
import {ref} from "vue";

const props = defineProps({
    question: {
        type: Object,
        required: true
    }
});

const showAnswer = ref(false)

</script>

<template>
    <section>
        <div>
            <h2 class="font-bold text-xl">問題文</h2>
            <Panel class="mt-3">
                {{ question.body }}
            </Panel>
        </div>

        <div class="mt-4">
            <div class="flex items-center">
                <h2 class="font-bold text-xl mr-5">答え</h2>
                <button @click="showAnswer = !showAnswer" class="bg-white p-1 rounded-xl">表示切替</button>
            </div>

            <Transition>
                <Panel class="mt-3 whitespace-pre-line" v-if="showAnswer" v-text="question.answer"></Panel>
            </Transition>
        </div>
    </section>
</template>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.3s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
