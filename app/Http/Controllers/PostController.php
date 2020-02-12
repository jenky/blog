<?php

namespace App\Http\Controllers;

use App\Actions\Post\UpsertPost;
use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['home', 'show'],
        ]);

        inertia()->share('auth.can', [
            'post' => [
                'read' => true,
                'write' => true,
                'destroy' => false,
            ],
        ]);
    }

    /**
     * Display all posts.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function home(Request $request)
    {
        $posts = Post::with('user')
            ->published()
            ->latest()
            ->when($request->search, function ($q, $value) {
                $q->where(function ($query) use ($value) {
                    $query->where('title', 'like', '%'.$value.'%')
                        ->orWhere('content', 'like', '%'.$value.'%');
                });
            })
            ->paginate(
                $request->input('limit', 20)
            );

        return inertia('Index', [
            'posts' => fractal($posts, new PostTransformer)->parseIncludes('user'),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $published = $request->published;
        $sudo = ($user->isAdmin() && $request->cookie('sudo'));
        $query = $sudo
            ? Post::query()
            : $user->posts()->getQuery();

        $posts = QueryBuilder::for($query)
            ->allowedSorts('title', 'created_at', 'published_at')
            ->defaultSort('-created_at')
            ->when($request->has('published'), function ($q) use ($published) {
                if (! is_null($published)) {
                    $q->published((bool) $published);
                }
            })
            ->when($request->search, function ($q, $value) {
                $q->where('title', 'like', '%'.$value.'%');
            })
            ->get();

        $posts = fractal($posts, new PostTransformer);

        if ($sudo) {
            $posts->parseIncludes('user');
        }

        return inertia('Posts/Index', compact('posts', 'published'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        return inertia('Posts/Edit', $this->getViewData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $post = UpsertPost::execute($request->all());

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);

        $post = fractal($post->loadMissing('user'), new PostTransformer)
            ->parseIncludes('user');

        return inertia('Posts/Show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return inertia('Posts/Edit', $this->getViewData($post));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post = UpsertPost::execute(array_merge(
            $request->all(), compact('post')
        ));

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }

    /**
     * Get shared view data.
     *
     * @param  \App\Models\Post|null $post
     * @return array
     */
    protected function getViewData(Post $post = null)
    {
        $post = fractal($post ?: new Post, new PostTransformer);

        return compact('post');
    }
}
