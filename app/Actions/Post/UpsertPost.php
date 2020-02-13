<?php

namespace App\Actions\Post;

use App\Actions\Executable;
use App\Models\Post;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Action;

class UpsertPost extends Action
{
    use Executable;

    /**
     * Determine if the user is authorized to make this action.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the action.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        $primaryRule = $request->isMethod('POST') ? 'required' : 'sometimes';

        return [
            'title' => $primaryRule.'|min:3',
            'content' => $primaryRule.'|min:10',
            'schedule' => 'sometimes|date|after:today',
        ];
    }

    /**
     * Execute the action and return a result.
     *
     * @param  \App\Models\Post $post
     * @return \App\Models\Post
     */
    public function handle(Post $post)
    {
        if (! $post->user_id) {
            $post->user()->associate(auth()->user());
        }

        if (! $post->isPublished()) {
            if ($this->publish) {
                $post->published_at = now();
            }

            if ($this->schedule) {
                $post->published_at = datetime($this->schedule);
            }
        } else {
            if ($this->unpublish) {
                $post->published_at = null;
            }
        }

        $post->fill($this->all())->save();

        return $post;
    }
}
