<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @isset($book)
                <a href="{{ route('books.show', ['book' => $book->id]) }}">{{ $book->title }}</a>
            @else
                一問一答
            @endisset
        </h2>
    </x-slot>

    <div class="space-y-5 mb-5">
        <section>
            <div class="relative">
                @isset($book)
                    <div class="font-light text-base text-gray-500">{{ $question->default_order }}問目
                        (全{{ $book->questions->count() }}問)
                    </div>
                @endisset
                <h2 class="font-bold text-xl ">問題文</h2>
                @auth
                    <div class="absolute right-0 top-0">
                        <div class="flex">
                            @can('update', $question)
                                <x-edit-icon :url="route('questions.edit', ['question' => $question->id])"/>
                            @endcan
                            @can('delete', $question)
                                <x-trash-icon :url="route('questions.destroy', ['question' => $question->id])"
                                              :name="$question->body"/>
                            @endcan
                        </div>
                    </div>
                @endauth
            </div>

            <div class="bg-white shadow rounded-lg mt-2 p-6">
                <div class="flex min-w-0 gap-x-4">
                    <div class="min-w-0 flex-auto ">
                        {{ $question->body }}
                    </div>
                </div>
            </div>
        </section>

        <section
            class="relative"
            x-data="{ open: false }"
            @click.outside="open = false"
            @close.stop="open = false"
            @keyup.space.window="open = !open"
        >
            <div class="flex items-center">
                <h2 class="font-bold text-xl mr-5">答え</h2>
                <button @click="open = !open" class="bg-white p-1 rounded-xl">表示切替</button>
                <p class="text-xs ml-2 text-black/60 hidden sm:block">※スペースキーで切替ができます。</p>
            </div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="mt-2 bg-white shadow rounded-lg p-6"
                 style="display: none;">
                {!! nl2br(e($question->answer)) !!}
            </div>
        </section>

        <section class="flex items-center justify-between">
            @empty($book)
                <div>
                    <a class="text-blue-600" href="{{route('questions.index')}}">問題一覧に戻る</a>
                </div>
            @endempty
            <div class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($previous_link)
                    <a href="{{$previous_link}}" rel="prev"
                       class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                       aria-label="{{ __('pagination.previous') }}">
                        前へ
                    </a>
                @else
                    <span id="previous" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                                aria-hidden="true">
                                前へ
                            </span>
                        </span>
                @endif

                {{-- Next Page Link --}}
                @if ($next_link)
                    <a href="{{ $next_link }}" rel="next"
                       class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800"
                       aria-label="{{ __('pagination.next') }}">
                        次へ
                    </a>
                @else
                    <span id="next" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600"
                                aria-hidden="true">
                                次へ
                            </span>
                        </span>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
