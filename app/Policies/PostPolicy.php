<?php

namespace App\Policies;

use App\Models\Account\User;
use App\Models\Blog\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->created_by;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post): bool
    {
        return $user->id === $post->created_by;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $user->id === $post->created_by;
    }

}
