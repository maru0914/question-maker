<script setup>

import Panel from "@/Components/Panel.vue";
import {ref} from "vue";
import StartLinkButton from "@/Components/StartButton.vue";
import PaginationSpan from "@/Components/PaginationSpan.vue";
import PaginationLink from "@/Components/PaginationLink.vue";

const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    previous_link: {
        type: String,
        required: false,
        default: null
    },
    next_link: {
        type: String,
        required: false,
        default: null
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

        <div class="mt-4" >
            <div class="text-center">
                <StartLinkButton v-if="!showAnswer" @click="showAnswer = !showAnswer">答えを見る</StartLinkButton>
            </div>

            <Transition>
                <div v-if="showAnswer">
                    <h2 class="font-bold text-xl mr-5">答え</h2>

                    <Panel class="mt-3 whitespace-pre-line"  v-text="question.answer"></Panel>
                </div>
            </Transition>
        </div>
    </section>

    <section v-if="showAnswer" class="mt-4 flex justify-between">
        <PaginationLink v-if="previous_link" type="previous" :href="previous_link"/>
        <PaginationSpan v-else type="previous"/>
        <PaginationLink v-if="next_link" type="next" :href="next_link"/>
        <PaginationSpan v-else type="next"/>
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
