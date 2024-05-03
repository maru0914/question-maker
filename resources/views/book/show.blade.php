<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>
    <div class="grid sm:grid-cols-3 gap-10 py-12">
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
        <div>
            <a href="#">問題集を始める(実装中)</a>
        </div>
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

    </div>
    @endauth
</x-app-layout>
