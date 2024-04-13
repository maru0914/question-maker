<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            一問一答
        </h2>
    </x-slot>
    @auth
        <div class="flex justify-end mb-6">
            <a class="text-blue-600" href="{{ route('questions.create') }}">
                新規作成
            </a>
            /
            <a class="text-gray-600" href="{{route('questions.edit', ['question' => $question->id])}}">
                編集
            </a>
            /
            <form class="text-red-500"
                  method="POST"
                  action="{{ route('questions.destroy', ['question' => $question->id]) }}"
            >
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('本当に削除しますか？')">
                    削除
                </button>
            </form>
        </div>
    @endauth
    <div class="space-y-5 mb-5">
        <div>
            <h2 class="font-bold text-xl ">問題文</h2>
            <div class="bg-white shadow rounded-lg mt-2 p-6">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto ">
                        {{ $question->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
            <div class="flex items-center">
                <h2 class="font-bold text-xl mr-5">答え</h2>
                <button @click="open = ! open" class="bg-white p-1 rounded-xl">表示切替</button>
            </div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="mt-2 bg-white shadow rounded-lg p-6"
                 style="display: none;">
                {!! nl2br(e($question->answer)) !!}
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a class="text-blue-600" href="{{route('questions.index')}}">問題一覧に戻る</a>
    </div>
</x-app-layout>
