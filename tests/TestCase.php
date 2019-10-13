<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        // create a user if $user = null
        $user = $user ?: factory(User::class)->create();
        // or
        // $user = $user ? $user : factory(User::class)->create();

        $this->be($user); // sign in user

        return $user; // User model

    }
}
