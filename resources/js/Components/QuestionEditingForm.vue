<script setup>

import CancelButton from "@/Components/CancelButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";

const emit = defineEmits(['cancel', 'updated'])

const props = defineProps({
    question: {
        type: Object,
        required: true
    }
});

const form = useForm({
    body: props.question.body,
    answer: props.question.answer,
});

const updateQuestion = () => {
    form.patch(route('questions.update', props.question.id), {
        onSuccess: () => {
            emit('updated')
        }
    })
}

</script>

<template>
    <form @submit.prevent="updateQuestion">
        <section>
            <div>
                <InputLabel class="font-bold text-xl" for="body" value="問題文"/>
                <TextInput
                    id="body"
                    type="text"
                    class="block mt-3 w-full"
                    v-model="form.body"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.body"/>
            </div>

            <div class="mt-4">
                <InputLabel class="font-bold text-xl" for="answer" value="答え"/>
                <TextArea
                    id="answer"
                    type="text"
                    class="block mt-3 w-full"
                    rows="4"
                    v-model="form.answer"
                    required
                />
                <InputError class="mt-2" :message="form.errors.answer"/>
            </div>
        </section>

        <div class="mt-4 flex justify-end gap-2">
            <CancelButton @click="$emit('cancel')">キャンセル</CancelButton>
            <PrimaryButton>更新</PrimaryButton>
        </div>
    </form>

</template>

