<?php


namespace App\Laragram\Following;


use App\User;

trait Follower
{

    public function hasRequestedFollower(User $user)
    {
        // has sent follow request to us ?
        return $this->followers()
            ->where('status', FollowingStatusManager::STATUS_SUSPENDED)
            ->where('follower', $user->id)
            ->exists();
    }

    public function followers()
    {
        // followers() == who follow us ?
        return $this->belongsToMany(
            User::class,
            'followings',
            'following',
            'follower'
        );
        // 'follower' and 'following' are foreign keys in followings table
        // foreign keys related to id column in users table
    }
}
