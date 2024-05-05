<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>
    @auth
        <div class="flex justify-end mb-6">
            <a class="text-right text-blue-600" href="{{ route('questions.create') }}">
                問題を作成する
            </a>
        </div>
    @endauth

    <div class="bg-white shadow rounded-lg px-5 sm:px-6">
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($questions as $question)
                <li>
                    <div class="flex justify-between items-center">
                        <div class="text-blue-600 pt-4">
                            <a href="{{ route('questions.show', ['question' => $question->id]) }}">
                                {{ $question->body }}
                            </a>
                        </div>
                        @auth
                            <div class="flex justify-end self-start py-2 text-sm leading-6 gap-1">
                                @can('update', $question)
                                    <p class="text-gray-600">
                                        <a href="{{route('questions.edit', ['question' => $question->id])}}">
                                            編集
                                        </a>
                                    </p>
                                @endcan
                                @can('delete', $question)
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
                                @endcan
                            </div>
                        @endauth
                    </div>
                    <div class="text-black/30 text-xs text-end">
                        by {{ $question->user->username }}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-5">
        {{$questions->links()}}
    </div>

</x-app-layout>
