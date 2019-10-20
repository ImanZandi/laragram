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
    }
}
