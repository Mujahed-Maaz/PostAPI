<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Comment $comment): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->user->is($user) && $user->tokenCan('update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment, Post $post): bool
    {
        return ($comment->user->is($user) || $post->user->is($user)) && $user->tokenCan('soft-delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->tokenCan('restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->tokenCan('delete');
    }
}
