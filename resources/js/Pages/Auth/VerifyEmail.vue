<script setup>
import {computed} from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="メールアドレスの確認"/>

        <div class="mb-4 text-sm text-gray-600">
            ご登録頂きありがとうございます。メールアドレス確認のリンクを送付しましたので、メールに記載のリンクをクリックしてください。メールが届いていない場合には、再送も可能です
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            ユーザ登録時に入力頂いたメールアドレス宛にメールアドレス確認リンクを再送しました
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    メールアドレス確認リンクの再送
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >ログアウト
                </Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
