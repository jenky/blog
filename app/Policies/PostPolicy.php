<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can do everything.
     *
     * @param  \App\Models\User $user
     * @param  string $ability
     * @return mixed
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            inertia()->share('auth.can.post', [
                'read' => true,
                'write' => true,
                'destroy' => true,
            ]);

            return true;
        }
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\User|null  $user
     * @param  \App\Post  $post
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return mixed
     */
    public function view(?User $user, Post $post)
    {
        if ($post->isScheduled() || ! $post->isPublished()) {
            if (! $user) {
                abort(404);
            }

            if ($post->user_id != $user->id) {
                abort(404);
            }
        }

        return true;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return tap($user->id == $post->user_id, function ($allowed) {
            inertia()->share('auth.can.post.write', $allowed);
        });
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return tap($user->id == $post->user_id, function ($allowed) {
            inertia()->share('auth.can.post.destroy', $allowed);
        });
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
