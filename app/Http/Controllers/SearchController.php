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

        $search = request('q');

        return User::search($search)->get();

    }
}
