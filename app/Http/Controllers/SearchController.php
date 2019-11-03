<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show()
    {
        // dd(request()->all());
        /* result:
            [
                "q" => "foobar"
            ]
        */

        // dd(request('q')); // "foobar"

        $search = request('q'); // users/search?q=foobar

        // $users = User::search($search)->get();
        // ->get() method give all users , million users !!!

        // search with algolia to find users with $search name/email/username
        $users = User::search($search)->paginate(25);
        // ->paginate(25) method give 25 users

        if (request()->expectsJson()) {
            // ->expectsJson() == ->wantsJson()
            // request() need json in SearchTest.php
            return $users; // algolia users found
        }
        // else
        return view('users.index', compact('users'));
    }
}
