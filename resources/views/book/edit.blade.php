<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }} - 編集
        </h2>
    </x-slot>
    <form method="POST" action="{{ route('books.update', ['book' => $book->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="grid sm:grid-cols-2 gap-2">
            <div class="flex flex-col justify-center">
                <x-input-label for="title" value="タイトル"/>
                <x-text-input id="title" class="block mt-1 w-full" name="title" :value="old('title') ?? $book->title"
                              required autofocus/>
                <x-input-error :messages="$errors->get('title')" class="mt-2"/>
            </div>
            <div class="flex flex-col justify-center">
                <x-input-label for="image" value="画像"/>
                <x-input-file name="image" alt="books" :src="asset('storage/' . $book->image_path)" />
                <x-input-error :messages="$errors->get('image')" class="mt-2"/>
            </div>
        </div>
        <div class="mt-4">
            <x-input-label for="description" value="説明文"/>
            <x-text-area id="description" class="block mt-1 w-full" name="description" rows="5" required autofocus>
                {{ old('description') ?? $book->description }}
            </x-text-area>
            <x-input-error :messages="$errors->get('description')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-blue-600" href="{{ route('books.index') }}">
                {{ __('Books') }}に戻る
            </a>
            <x-primary-button>
                更新
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
