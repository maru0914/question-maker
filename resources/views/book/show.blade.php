<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>
    <div class="grid sm:grid-cols-3 gap-10 py-12 items-center">
        <div class="space-y-4">
            <div class="bg-white p-5 rounded-lg shadow">
                <img class="max-h-48 mx-auto" src="{{ asset('storage/' . $book->image_path) }}" alt="">
            </div>
        </div>
        <div class="sm:col-span-2">
            <h1 class="text-lg font-medium">{!! nl2br(e($book->description)) !!}</h1>
        </div>
    </div>

    <div class="flex justify-between mb-6">
        <x-secondary-link>問題集を始める(実装中)</x-secondary-link>
        @auth
            <div class="flex">
                @can('update', $book)
                    <a class="text-gray-600" href="{{ route('books.edit', ['book' => $book->id]) }}">
                        編集
                    </a>
                @endcan
                @can('delete', $book)
                    /
                    <form class="text-red-500"
                          method="POST"
                          action="{{ route('books.destroy', ['book' => $book->id]) }}"
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
    <x-section-heading>問題一覧 <span class="text-black/50 font-light text-sm">(全{{ $book->questions->count() }}問)</span></x-section-heading>

    <div class="mt-3 py-3">
        @if($book->questions->isNotEmpty())
            <div class="bg-white shadow rounded-lg px-5 pt-1 sm:px-6">
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($book->questions as $question)
                        <li>
                            <a class="block text-blue-600 py-2"
                               href="{{ route('questions.show', ['question' => $question->id]) }}">
                                {{ $question->body }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            @can('update', $book)
                <x-secondary-link class="mt-2" href="{{ route('questions.create', ['book_id' => $book->id]) }}">
                    問題登録へ
                </x-secondary-link>
            @else
                <p>
                    この問題集にはまだ問題が登録されていません！<br>
                    問題が登録されるのを待ちましょう！
                </p>
            @endcan
        @endif

    </div>

</x-app-layout>
