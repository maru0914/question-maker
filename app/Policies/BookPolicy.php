<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Book $question): bool
    {
        return $user->id === $question->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $question): bool
    {
        return $user->id === $question->user_id;
    }
}
