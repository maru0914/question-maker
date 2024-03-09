<x-question-layout>
    <div class="flex justify-between">
        <h1 class="font-bold text-2xl mb-2">問題一覧</h1>
        <a class="text-right text-blue-600" href="{{ route('questions.create') }}">
            問題を作成する
        </a>
    </div>

    <ul>
        @foreach($questions as $question)
            <div class="flex justify-between mb-1">
                <li class="text-blue-600">
                    <a href="{{ route('questions.show', ['question' => $question->id]) }}">
                        {{ $question->body }}
                    </a>
                </li>
                <span>
                    <span class="text-gray-500">
                        <a href="{{route('questions.edit', ['question' => $question->id])}}">
                        編集
                        </a>
                    </span>
                    <span class="text-red-500">
                        <form method="POST" action="{{ route('questions.destroy', ['question' => $question->id]) }}">
                            @csrf
                            @method('delete')

                            <button>
                            削除
                            </button>
                        </form>
                    </span>
                </span>

            </div>

        @endforeach
    </ul>
</x-question-layout>
