<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'answer',
    ];

    /**
     *  Scope 指定された問題以前に作成
     */
    public function scopeBefore(Builder $query, self $currentQuestion): void
    {
        $query->where('id', '<', $currentQuestion->id);
    }

    /**
     *  Scope 指定された問題以降に作成
     */
    public function scopeAfter(Builder $query, self $currentQuestion): void
    {
        $query->where('id', '>', $currentQuestion->id);
    }
}
