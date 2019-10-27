<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function after_registering_a_new_user_it_should_get_a_unique_hashed_username()
    {
        $this->withoutExceptionHandling();

        // $user = factory(User::class)->make();
        // make() method will make a user but not store it in db
        // dd($user->toArray());
        /* Result : dont have 'id' column when use make() method
            [
              "name" => "Joyce Batz PhD",
              "email" => "schmidt.jerrold@example.org",
              "email_verified_at" => "2019-10-27 16:16:47"
            ]
        */

        // $user = factory(User::class)->raw();
        // dd($user); // dont need ->toArray() method when use raw() method
        /* Result : dont have 'id' column when use raw() method
                    hidden columns in User.php will show
            [
              "name" => "Joyce Batz PhD",
              "email" => "schmidt.jerrold@example.org",
              "email_verified_at" => "2019-10-27 16:16:47",
              "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
              "remember_token" => "oIvlbqHHds"
            ]
        */

        // $user = factory(User::class)->create();
        // dd($user->toArray());
        /*
            [
              "name" => "Darrion Douglas III",
              "email" => "kaylah.anderson@example.net",
              "email_verified_at" => "2019-10-27 16:29:12",
              "updated_at" => "2019-10-27 16:29:12",
              "created_at" => "2019-10-27 16:29:12",
              "id" => 1
            ]
        */

        $user = factory(User::class)->raw();
        // raw() method give an array , not object

        $user['password_confirmation'] = $user['password'];
        // 'password_confirmation' == name attr in /register view
        // should fill all of name attrs before save to db

        $this->post('/register', $user); // register new user , $user

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);

    }
}
