<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            問題作成
        </h2>
    </x-slot>
    <form method="POST" action="{{ route('questions.store') }}">
        @csrf
        <div>
            <x-input-label for="book" value="問題集"/>
            <div class="mt-2">
                <select id="book"
                        name="book_id"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >

                    @foreach($books as $book)
                        @php
                            if(old('book_id')) {
                                $selected = $book->id === old('book_id')  ? 'selected' : '';
                            } elseif ($selected_book_id) {
                                $selected = $book->id === $selected_book_id ? 'selected' : '';
                            } else {
                                $selected = '';
                            }
                        @endphp
                        <option value="{{ $book->id }}" {{ $selected }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <x-input-error :messages="$errors->get('book_id')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="body" value="問題文"/>
            <x-text-area id="body" class="block mt-1 w-full" name="body" required autofocus>
                {{ old('body') }}
            </x-text-area>
            <x-input-error :messages="$errors->get('body')" class="mt-2"/>
        </div>

        <div class="mt-4">
            <x-input-label for="answer" value="答え"/>
            <x-text-area id="answer" class="block mt-1 w-full" name="answer" rows="5" required autofocus>
                {{ old('answer') }}
            </x-text-area>
            <x-input-error :messages="$errors->get('answer')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-blue-600" href="{{ route('questions.index') }}">
                問題一覧に戻る
            </a>
            <x-primary-button class="ms-4">
                作成
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
