<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'posts',
    ];

    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\User $user
     * @return array
     */
    public function transform(User $user)
    {
        $user->is_admin = $user->isAdmin();
        $user->avatar_url = $user->getAvatarUrl();

        return $user->toArray();
    }

    /**
     * Include posts.
     *
     * @param  \App\Models\User $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includePosts(User $user)
    {
        return $this->collection($user->posts, new PostTransformer);
    }
}
