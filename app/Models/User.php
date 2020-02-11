<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Parental\HasChildren;

class User extends Authenticatable
{
    use HasChildren, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * All available child types.
     *
     * @var array
     */
    protected $childTypes = [
        UserType::ADMIN => Admin::class,
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Determine whether user is admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this instanceof Admin;
    }

    /**
     * Get the avatar url.
     *
     * @return string
     */
    public function getAvatarUrl(array $options = [])
    {
        $options = http_build_query(
            array_merge([
                'color' => '467fcf',
                'background' => 'c8d9f1',
                'rounded' => 'true',
                'bold' => 'true',
                'name' => $this->name,
                'size' => 128,
            ], $options)
        );

        return 'https://ui-avatars.com/api/?'.$options;
    }
}
