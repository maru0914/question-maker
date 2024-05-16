<script setup>
import {computed, ref} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link, router} from "@inertiajs/vue3";
import EditIcon from "@/Components/EditIcon.vue";
import TrashIcon from "@/Components/TrashIcon.vue";
import PaginationLink from "@/Components/PaginationLink.vue";
import PaginationSpan from "@/Components/PaginationSpan.vue";

const props = defineProps({
  questions_count: {
    type: Number
  },
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

const open = ref(false)

const book = computed(() => props.question.book)

const deleteQuestion = (question) => {
  if (!confirm(`「${question.body}」を削除しますか？`)) {
    return;
  }

  router.delete(route('questions.destroy', question));
}

</script>

<template>
  <Head :title="`${book.title} - 一問一答`"/>
  <AppLayout>
    <template #header>
      <Link :href="route('books.show', book)">{{ book.title }}</Link>
    </template>
    <div class="space-y-5 mb-5">
      <section>
        <div class="relative">
          <div class="text-base text-gray-500">{{ question.default_order }}問目
            (全{{ questions_count }}問)
          </div>
          <h2 class="font-bold text-xl ">問題文</h2>
          <div v-if="$page.props.auth.user" class="absolute right-0 top-0">
            <div class="flex">
              <EditIcon v-if="question.can.update" :href="route('questions.edit', question)"/>
              <button v-if="question.can.delete" @click="deleteQuestion(question)">
                <TrashIcon route="questions.destroy" :id="question.id"/>
              </button>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-lg mt-2 p-6">
          <div class="flex min-w-0 gap-x-4">
            <div class="min-w-0 flex-auto ">
              {{ question.body }}
            </div>
          </div>
        </div>
      </section>

      <section
          class="relative"
          @close.stop="open = false"
      >
        <div class="flex items-center">
          <h2 class="font-bold text-xl mr-5">答え</h2>
          <button @click="open = !open" class="bg-white p-1 rounded-xl">表示切替</button>
        </div>

        <Transition class="mt-2 bg-white shadow rounded-lg p-6">
          <p v-if="open" v-html="question.answer"></p>
        </Transition>
      </section>
        
      <section class="flex justify-between">
        <PaginationLink v-if="previous_link" type="previous" :href="previous_link"/>
        <PaginationSpan v-else type="previous"/>
        <PaginationLink v-if="next_link" type="next" :href="next_link"/>
        <PaginationSpan v-else type="next"/>
      </section>
    </div>
  </AppLayout>
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
