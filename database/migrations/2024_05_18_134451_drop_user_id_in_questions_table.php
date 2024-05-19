<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SQLiteでは外部制約のついたカラム削除がサポートされていないので、既存テーブル削除・新規テーブル作成で変更する
     */
    public function up(): void
    {
        // 新規テーブルの作成
        Schema::create('temp_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)->constrained();
            $table->unsignedInteger('default_order');
            $table->text('body');
            $table->text('answer');
            $table->timestamps();
        });

        // 既存テーブルのデータを新規テーブルに移行
        DB::table('temp_questions')->insertUsing([
            'id', 'book_id', 'default_order', 'body', 'answer',
        ], DB::table('questions')->select(
            'id', 'book_id', 'default_order', 'body', 'answer'
        ));

        // 既存テーブルの削除
        Schema::drop('questions');

        // 新規テーブルの名前変更
        Schema::rename('temp_questions', 'questions');

        // ユニーク制約の追加
        Schema::table('questions', function (Blueprint $table) {
            $table->unique(['book_id', 'default_order']);
        });
    }

    public function down(): void
    {
        Schema::create('temp_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Book::class)->constrained();
            $table->unsignedInteger('default_order');
            $table->text('body');
            $table->text('answer');
            $table->timestamps();
        });

        DB::table('temp_questions')
            ->insertUsing(
                ['id', 'user_id', 'book_id', 'default_order', 'body', 'answer'],
                DB::table('questions')
                    ->select(
                        DB::raw('id, 1 as user_id, book_id, default_order, body, answer')
                    )
            );

        $books = Book::all();

        foreach ($books as $book) {
            DB::table('temp_questions')
                ->where('book_id', $book->id)
                ->update(['user_id' => $book->user_id]);
        }

        Schema::drop('questions');
        Schema::rename('temp_questions', 'questions');

        Schema::table('questions', function (Blueprint $table) {
            $table->unique(['book_id', 'default_order']);
        });
    }
};
