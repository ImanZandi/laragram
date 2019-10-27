<?php


namespace App\Laragram\Following;


use App\User;

trait Following
{

    public function hasRequestedFollowing(User $user)
    {
        // has sent follow request ?
        return $this->followings()
            ->where('status', FollowingStatusManager::STATUS_SUSPENDED)
            ->where('following', $user->id)
            ->exists();
        // followings() method in User model
        // exist $user in followings ?
    }

    public function followings()
    {
        // followings() == we follow who ?
        return $this->belongsToMany(
            User::class,
            'followings',
            'follower',
            'following'
        );
    }

    public function follow(User $user)
    {
        // $user == following
        $this->followings()->attach($user, [
            // 'status column' => 1
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
        // add $user to followings list and add status column value
        // 'follower' and 'following' columns fill automatic
        // $user id add to 'following' column
        // auth() id add to 'follower' column
    }

    public function decline(User $user)
    {
        $this->followers()->sync([
            $user->id => [
                'status' => FollowingStatusManager::STATUS_DECLINED
            ]
        ]);
    }

    public function hasDeclined(User $user)
    {
        return $this->followers()
            ->where('follower', $user->id)
            ->where('status', FollowingStatusManager::STATUS_DECLINED)
            ->exists();
    }

    public function accept(User $user)
    {
        return $this->followers()->sync([
            $user->id => [
                'status' => FollowingStatusManager::STATUS_ACCEPTED
            ]
        ]);
    }

    public function isFollowing(User $user)
    {
        return $this->followings()
            ->where('following', $user->id)
            ->where('status', FollowingStatusManager::STATUS_ACCEPTED)
            ->exists();
    }
}
