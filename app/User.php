<?php

namespace App;

use App\Laragram\Following\FollowingStatusManager;
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

    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'followings',
            'following',
            'follower'
        );
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
        $this->followers()->attach($user, [
            // 'status column' => 1
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
        // add $user to followers list and add status column value
        // 'follower' and 'following' columns fill automatic
        // $user id add to 'following' column
        // auth() id add to 'follower' column
    }

    public function hasRequestedFollowing(User $user)
    {
        return $this->followers()
            ->where('status', FollowingStatusManager::STATUS_SUSPENDED)
            ->where('following', $user->id)
            ->exists();
        // followers() method in User model
        // exist $user in followers ?
    }

    public function decline(User $user)
    {
        $this->followings()->sync([
            $user->id => [
                'status' => FollowingStatusManager::STATUS_DECLINED
            ]
        ]);
    }

    public function hasDeclined(User $user)
    {
        return $this->followings()
            ->where('follower', $user->id)
            ->where('status', FollowingStatusManager::STATUS_DECLINED)
            ->exists();
    }
}
