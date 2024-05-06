<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>
    <div class="space-y-6">
        <section class="relative border border-gray-200 shadow rounded-md bg-white/30">
            @auth
                <div class="absolute right-0 top-0">
                    <div class="flex">
                        @can('update', $book)
                            <x-edit-icon :url="route('books.edit', ['book' => $book->id])"/>
                        @endcan
                        @can('delete', $book)
                            <x-trash-icon :url="route('books.destroy', ['book' => $book->id])" :name="$book->title"/>
                        @endcan
                    </div>
                </div>

            @endauth
            <div class="grid sm:grid-cols-3 sm:gap-10 items-center">
                <div class="bg-white p-5 rounded-md h-full flex items-center">
                    <img class="max-h-48 mx-auto" src="{{ asset('storage/' . $book->image_path) }}" alt="">
                </div>
                <div class="sm:col-span-2 p-4">
                    <h1 class="text-lg font-medium">{!! nl2br(e($book->description)) !!}</h1>
                </div>
            </div>
        </section>

        <section>
            @if($book->questions->isNotEmpty())
                <x-secondary-link href="{{ route('books.questions.show',[$book->id, $first_question->id]) }}">
                    問題集を始める
                </x-secondary-link>
            @endif
        </section>

        <section class="space-y-2">
            <x-section-heading>
                問題一覧 <span class="text-black/50 font-light text-sm">(全{{ $book->questions->count() }}問)</span>
            </x-section-heading>

            @if($book->questions->isNotEmpty())
                <div class="bg-white shadow rounded-lg pl-5 sm:pl-6">
                    <ul role="list" class="divide-y divide-gray-100">
                        @foreach($book->questions as $question)
                            <li class="relative">
                                @can('delete', $question)
                                    <div class="absolute right-0 text-red-600">
                                        <x-trash-icon
                                                :url="route('questions.destroy', ['question' => $question->id])"
                                                :name="$question->body"/>
                                    </div>
                                @endcan

                                <a class="inline-block text-blue-600 py-2"
                                   href="{{ route('books.questions.show', [$book->id, $question->id]) }}">
                                    {{ $question->body }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                @cannot('update', $book)
                    <p>
                        この問題集にはまだ問題が登録されていません！<br>
                        問題が登録されるのを待ちましょう！
                    </p>
                @endcannot
            @endif

            @can('update', $book)
                <div class="ml-5">
                    <x-create-icon :url="route('questions.create', ['book_id' => $book->id])"/>
                </div>
            @endcan

        </section>

    </div>


</x-app-layout>
