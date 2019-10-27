<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->accept($user); // define accept() method in User model

        return back();
    }

    public function destroy(User $user)
    {
        auth()->user()->decline($user); // define decline() method in User model

        return back();
    }
}
