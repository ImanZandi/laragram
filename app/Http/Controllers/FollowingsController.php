<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowingsController extends Controller
{
    public function store(User $user)
    {
        // auth()->user() == follower , iman , User model
        // $user == following , john
        auth()->user()->follow($user); // follow() method created in User model

        return back();
    }

    public function destroy(User $user)
    {
        // dd(auth()->user()->name); // sina

        auth()->user()->followings()->detach($user->id);
        // in sina's followings detach $user/iman
        // you can create a method in User model to do this
        // CancelRequest() method for example
        // auth()->user()->CancelRequest($user)

        return back();
    }
}
