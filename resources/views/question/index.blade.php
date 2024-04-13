<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題一覧
        </h2>
    </x-slot>
    @auth
        <div class="flex justify-end mb-6">
            <a class="text-right text-blue-600" href="{{ route('questions.create') }}">
                問題を作成する
            </a>
        </div>
    @endauth

    <div class="bg-white shadow rounded-lg px-6">
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($questions as $question)
                <li class="flex justify-between items-center gap-x-6 py-5">
                    <div class="flex min-w-0 gap-x-4">
                        <div class="min-w-0 flex-auto text-blue-600">
                            <a href="{{ route('questions.show', ['question' => $question->id]) }}">
                                {{ $question->body }}
                            </a>
                        </div>
                    </div>
                    @auth
                        <div class="shrink-0 flex flex-col items-end">
                            <p class="text-sm leading-6 text-gray-600">
                                <a href="{{route('questions.edit', ['question' => $question->id])}}">
                                    編集
                                </a>
                            </p>
                            <form class="text-sm leading-6 text-red-500"
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
                </li>
            @endforeach
        </ul>
    </div>

    <div>
        {{$questions->links()}}
    </div>

</x-app-layout>
