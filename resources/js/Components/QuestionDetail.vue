<script setup>

import Panel from "@/Components/Panel.vue";
import {computed, ref} from "vue";
import BigButton from "@/Components/LargeButton.vue";
import PaginationSpan from "@/Components/PaginationSpan.vue";
import PaginationLink from "@/Components/PaginationLink.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    questions_count: {
        type: Number
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
    },
    errors: {
        type: Object
    }
});
const currentResults = ref(JSON.parse(localStorage.getItem(`books.${props.question.book.id}.results`)))

const isSuccess = ref(currentResults.value ? currentResults.value.find((result) => result.question_id === props.question.id)?.is_success : null)

const showAnswer = ref(isSuccess.value !== null && isSuccess.value !== undefined)

const showSaveButton = computed(() => {
    const isLast = props.question.default_order === props.questions_count
    const isFinished = currentResults.value && currentResults.value.length === props.questions_count

    return isLast && isFinished
})

const setResult = (item) => {
    if (currentResults.value) {
        currentResults.value = currentResults.value.filter((result) => result.question_id !== item.question_id)
        currentResults.value.push(item)
        localStorage.setItem(`books.${props.question.book.id}.results`, JSON.stringify(currentResults.value))
    } else {
        currentResults.value = item
        localStorage.setItem(`books.${props.question.book.id}.results`, JSON.stringify([currentResults.value ]))
    }
}

const updateStatus = (e) => {
    setResult(
        {
            question_id: props.question.id,
            is_success: e.target.value === 'true'
        }
    )
}

const saveResult = () => {
    router.post(
        route('books.challenges.store', props.question.book.id),
        {challenges: currentResults.value}
    )
}


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
            <div class="text-center">
                <BigButton v-if="!showAnswer" @click="showAnswer = !showAnswer">答えを見る</BigButton>
            </div>

            <Transition>
                <div v-if="showAnswer">
                    <h2 class="font-bold text-xl mr-5">答え</h2>

                    <Panel class="mt-3 whitespace-pre-line" v-text="question.answer"></Panel>
                </div>
            </Transition>
        </div>
    </section>

    <section v-if="showAnswer" class="container mt-4">
        <form>
            <label>
                <input type="radio" name="is_success" value="true" :checked="isSuccess === true"
                       @change="updateStatus">
                <span>正解した</span>
            </label>
            <label>
                <input type="radio" name="is_success" value="false" :checked="isSuccess === false"
                       @change="updateStatus">
                <span>間違った</span>
            </label>
        </form>
    </section>

    <section v-if="showAnswer && !showSaveButton" class="mt-4 flex justify-between">
        <PaginationLink v-if="previous_link" type="previous" :href="previous_link"/>
        <PaginationSpan v-else type="previous"/>
        <PaginationLink v-if="next_link" type="next" :href="next_link"/>
        <PaginationSpan v-else type="next"/>
    </section>

    <section v-if="showAnswer && showSaveButton && $page.props.auth.user" class="mt-4 relative flex justify-center items-center">
        <PaginationLink v-if="previous_link" class="absolute left-0" type="previous" :href="previous_link"/>
        <PaginationSpan v-else class="absolute left-0" type="previous"/>
        <BigButton class="text-xl" @click="saveResult">結果を保存する</BigButton>
    </section>

    <section v-if="showAnswer && showSaveButton && !$page.props.auth.user" class="mt-4 relative flex justify-center items-center">
        <PaginationLink v-if="previous_link" class="absolute left-0" type="previous" :href="previous_link"/>
        <PaginationSpan v-else class="absolute left-0" type="previous"/>
        <BigButton class="text-xl" @click="router.get(route('books.show', question.book.id))">問題集を終了する</BigButton>
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

.container form {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
}

.container label {
    display: flex;
    cursor: pointer;
    font-weight: 500;
    position: relative;
    overflow: hidden;
    margin-bottom: 0.375em;
}

.container label input {
    position: absolute;
    left: -9999px;
}

.container label input:checked + span {
    background-color: #414181;
    color: white;
}

.container label input:checked + span:before {
    box-shadow: inset 0 0 0 0.4375em #00005c;
}

.container label span {
    display: flex;
    align-items: center;
    padding: 0.375em 0.75em 0.375em 0.375em;
    border-radius: 99em;
    transition: 0.25s ease;
    color: #414181;
}

.container label span:hover {
    background-color: #d6d6e5;
}

.container label span:before {
    display: flex;
    flex-shrink: 0;
    content: "";
    background-color: #fff;
    width: 1.5em;
    height: 1.5em;
    border-radius: 50%;
    margin-right: 0.375em;
    transition: 0.25s ease;
    box-shadow: inset 0 0 0 0.125em #00005c;
}


</style>
