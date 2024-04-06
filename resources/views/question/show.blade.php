<x-app-layout>
    <x-slot name="header">
        一問一答
    </x-slot>
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
    <div class="space-y-5 mb-5">
        <div>
            <h2 class="font-bold text-xl mb-2">問題文</h2>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto ">
                        {{ $question->body }}
                    </div>
                </div>
            </div>
        </div>

        {{-- TODO jsで表示/非表示切り替え　--}}
        <div>
            <h2 class="font-bold text-xl mb-2">答え</h2>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto ">
                        {!! nl2br(e($question->answer)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a class="text-blue-600" href="{{route('questions.index')}}">問題一覧に戻る</a>
    </div>
</x-app-layout>
