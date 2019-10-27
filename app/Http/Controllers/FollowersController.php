<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class FollowersController extends Controller
{
    public function destroy(User $user)
    {
        auth()->user()->decline($user);

        return back();
    }
}
