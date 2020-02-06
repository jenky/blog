<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the user who owned this post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to published/unpublished posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  bool $published
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query, $published = true)
    {
        $method = $published ? 'whereNotNull' : 'whereNull';

        return $query->{$method}('published_at');
    }

    /**
     * Determine whether post is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return ! is_null($this->published_at);
    }
}
