<script setup>
import CancelButton from '@/Components/CancelButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

const emit = defineEmits(['cancel', 'updated']);

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    body: props.question.body,
    answer: props.question.answer,
});

const updateQuestion = () => {
    form.patch(route('questions.update', props.question.id), {
        onSuccess: () => {
            emit('updated');
        },
    });
};
</script>

<template>
    <form @submit.prevent="updateQuestion">
        <section>
            <div>
                <InputLabel
                    class="text-xl font-bold"
                    for="body"
                    value="問題文"
                />
                <TextInput
                    id="body"
                    type="text"
                    class="mt-3 block w-full"
                    v-model="form.body"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.body" />
            </div>

            <div class="mt-4">
                <InputLabel
                    class="text-xl font-bold"
                    for="answer"
                    value="答え"
                />
                <TextArea
                    id="answer"
                    type="text"
                    class="mt-3 block w-full"
                    rows="4"
                    v-model="form.answer"
                    required
                />
                <InputError class="mt-2" :message="form.errors.answer" />
            </div>
        </section>

        <div class="mt-4 flex justify-end gap-2">
            <CancelButton @click="$emit('cancel')">キャンセル</CancelButton>
            <PrimaryButton>更新</PrimaryButton>
        </div>
    </form>
</template>
