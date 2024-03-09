<x-question-layout>
    <h2 class="font-bold text-xl">問題文</h2>
    <p>{{ $question->body }}</p>

    {{-- TODO jsで表示/非表示切り替え　--}}
    <h2 class="font-bold text-xl">答え</h2>
    <p>{!! nl2br(e($question->answer)) !!}</p>

    <div class="mt-3">
    <a class="text-blue-600" href="{{route('questions.index')}}">問題一覧に戻る</a>
    </div>
</x-question-layout>
