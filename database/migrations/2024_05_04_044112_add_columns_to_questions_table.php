<?php

use App\Models\Book;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tmpBookId = 1;

        // 既存レコード対応のため、デフォルト値を設定
        Schema::table('questions', function (Blueprint $table) use ($tmpBookId) {
            $table->foreignIdFor(Book::class)->after('user_id')->default($tmpBookId)->constrained();
            $table->unsignedInteger('default_order')->after('book_id')->default(0);
        });

        // デフォルト値設定を解除
        Schema::table('questions', function (Blueprint $table) {
            $table->foreignIdFor(Book::class)->default(null)->change();
            $table->unsignedInteger('default_order')->default(null)->change();
        });

        // 既存レコードについてdefault_orderを連番に変更してからユニーク制約を追加
        Schema::table('questions', function (Blueprint $table) use ($tmpBookId) {
            $questions = Question::where('book_id', $tmpBookId)->get();
            foreach ($questions as $idx => $question) {
                $question->default_order = $idx + 1;
                $question->save();
            }

            $table->unique(['book_id', 'default_order']);
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropUnique(['book_id', 'default_order']);
            $table->dropColumn(['book_id', 'default_order']);
        });
    }
};
