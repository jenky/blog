<?php

namespace App\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
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
        'user'
    ];

    /**
     * A Fractal transformer.
     *
     * @param  \App\Models\Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        $post->published = $post->isPublished();
        $post->scheduled = $post->isScheduled();

        return $post->toArray();
    }

    /**
     * Include user.
     *
     * @param  \App\Models\Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }
}
