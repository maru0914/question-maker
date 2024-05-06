<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'body',
        'answer',
        'default_order',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     *  Scope 指定された問題より前に作成
     */
    public function scopeBefore(Builder $query, self $currentQuestion, string $key = 'id'): void
    {
        $query->where($key, '<', $currentQuestion->{$key});
    }

    /**
     *  Scope 指定された問題より後に作成
     */
    public function scopeAfter(Builder $query, self $currentQuestion, string $key = 'id'): void
    {
        $query->where($key, '>', $currentQuestion->{$key});
    }

    /**
     * 指定の問題集における次のorderを算出する
     */
    public static function getNextOrder(int $bookId): int
    {
        return self::where('book_id', $bookId)->count() + 1;
    }
}
