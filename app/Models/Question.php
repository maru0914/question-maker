<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'body',
        'answer',
        'default_order',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function latestChallenge(): HasOne
    {
        return $this->hasOne(Challenge::class)->latestOfMany();
    }

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    /**
     * 問題に挑戦したユーザー
     */
    public function challengers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'challenges')
            ->using(Challenge::class)
            ->distinct();
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
