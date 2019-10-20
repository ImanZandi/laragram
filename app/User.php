<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'follower',
            'following'
        );
        // 'follower' and 'following' are foreign keys in followings table
        // foreign keys related to id column in users table
    }

    public function follow(User $user)
    {
        // $user == following
        $this->followers()->attach($user); // add $user to followers list
        // 'follower' and 'following' columns fill automatic
        // $user id add to 'following' column
        // auth() id add to 'follower' column
    }

    public function isFollowing(User $user)
    {
        return $this->followers->contains($user);
        // followers() method in User model
        // exist $user in followers ?
    }
}
