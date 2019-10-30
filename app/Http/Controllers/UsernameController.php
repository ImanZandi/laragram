<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function update(User $user)
    {
        $attributes = request()->validate([
            // 'name attr' => 'must be'
            'username' => 'required|string|min:3|max:255|unique:users,username,' . $user->id
        ]);
        // 'unique:table,column'
        // 'unique:table,column,' . ignore this record

        $user->update($attributes);
        // 'username' column must be fillable in User.php before update

        return back();
    }
}
