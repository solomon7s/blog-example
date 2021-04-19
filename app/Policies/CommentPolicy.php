<?php

namespace App\Policies;

use App\Models\Account\User;
use App\Models\Blog\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response as AccessResponse;


class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User     $user
     * @param  Comment  $comment
     * @return bool
     */
    public function view(User $user, Comment $comment): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User     $user
     * @param  Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User     $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User     $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function restore(User $user, Comment $comment): bool
    {
        return $user->id === $comment->created_by;

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User     $user
     * @param  Comment  $comment
     * @return mixed
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->created_by;
    }
}
