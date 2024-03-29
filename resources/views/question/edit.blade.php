<x-question-layout>

            <form method="POST" action="{{ route('questions.update', ['question' => $question->id]) }}">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="body" value="問題文"/>
                    <x-text-area id="body" class="block mt-1 w-full" name="body" :value="old('body')"
                                 required autofocus>
                        {{ old('body') ?? $question->body }}
                    </x-text-area>
                    <x-input-error :messages="$errors->get('body')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label for="answer" value="回答"/>
                    <x-text-area id="answer" class="block mt-1 w-full" name="answer" rows="5" :value="old('answer')"
                                 required autofocus>
                        {{ old('answer') ?? $question->answer }}
                    </x-text-area>
                    <x-input-error :messages="$errors->get('answer')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="text-blue-600" href="{{ route('questions.index') }}">
                        問題一覧に戻る
                    </a>
                    <x-primary-button class="ms-4">
                        更新
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-question-layout>
