<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books') }}
        </h2>
    </x-slot>
    @auth
        <div class="flex justify-end mb-2">
            <x-create-icon :url="route('books.create')"/>
        </div>
    @endauth

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($books as $book)
            <x-panel class="relative">
                <a href="{{ route('books.show', ['book' => $book->id]) }}" class="absolute inset-0"></a>
                <div class="flex flex-col w-full h-full">
                    <div class="flex items-center my-auto">
                        <img class="max-h-40 mx-auto " src="{{ asset('storage/' . $book->image_path) }}" alt="">
                    </div>
                    <h2 class="font-medium mt-auto text-lg text-center">{{ $book->title }}</h2>
                    <div class="text-black/30 text-xs text-end -mr-2">
                        by {{ $book->user->username }}
                    </div>
                </div>
            </x-panel>
        @endforeach
    </div>

    <div>
        {{$books->links()}}
    </div>

</x-app-layout>
