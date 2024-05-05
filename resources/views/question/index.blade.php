<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Questions') }}
        </h2>
    </x-slot>
    @auth
        <div class="flex justify-end mb-2">
            <x-create-icon :url="route('questions.create')"/>
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
                                    <x-edit-icon :url="route('questions.edit', ['question' => $question->id])"/>
                                @endcan
                                @can('delete', $question)
                                    <x-trash-icon :url="route('questions.destroy', ['question' => $question->id])"
                                                  :name="$question->body"/>
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
