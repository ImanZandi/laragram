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

        // $user = factory(User::class)->raw();
        // raw() method give an array , not object
        // or
        // $user = raw(User::class); // tests/helpers/functions.php

        // $user['password_confirmation'] = $user['password'];
        // 'password_confirmation' == name attr in /register view
        // should fill all of name attrs before save to db

        $password = bcrypt('password'); // make hashed password

        $user = [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => $password,
            'password_confirmation' => $password
        ]; // like factory() , make user

        $this->post('/register', $user);
        // register new user , $user save to db
        // username column fill auto in User.php with hashed value
        // boot() method run auto in User.php for generate username hash value

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);

        $user = User::first(); // select first user/record in users table in db

        $this->assertNotNull($user->username);
        // username column fill auto in User.php in boot() method when $user registering
    }

    /** @test **/
    public function users_can_update_their_username()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);
        // dd($user->toArray());
        /* result : username column generated auto in User.php
        [
           "name" => "Hunter Upton"
           "email" => "greenfelder.casimir@example.com"
           "email_verified_at" => "2019-10-30 13:25:52"
           "username" => "$2y$04$RmUb6H6JUB2SfFlueuia6OBApy4TgWHSabcdcJNSx6tniTIgrmlabcdrKSu1572441952"
           "updated_at" => "2019-10-30 13:25:52"
           "created_at" => "2019-10-30 13:25:52"
           "id" => 1
        ]
        */

        // update/change username
        // $user->path() == '/users/id'
        // path() method in User model
        $this->patch($user->path() . '/username', [
            // 'name attr' => 'value'
            // 'column' => 'value'
            'username' => 'foobar'
        ]); // like form , send data and user id to controller with patch method

        $this->assertEquals('foobar', $user->fresh()->username);
        // fresh() use for apply changes like username column change to foobar
        // laravel cache the hashed username , must use fresh() method
    }

    /** @test **/
    public function username_is_required_for_update()
    {
        $user = create(User::class); // hashed username generated auto in User.php

        // update/change username
        $this->patch($user->path() . '/username', [
            // 'name attr' => 'value'
            // 'column' => 'value'
            'username' => null
        ])->assertSessionHasErrors(['username']);
        // when data not valid in controller session set for error
        // error name == username column/name attr
    }

    /** @test **/
    public function username_should_be_unique()
    {
        $john = create(User::class);
        $matt = create(User::class);

        // john want to change his username
        $this->patch($john->path() . '/username', [
            'username' => $matt->username
        ])->assertSessionHasErrors(['username']);
        // john can not set other users username for his username
        // username must be unique on users table in username column , validation
    }

    /** @test **/
    public function username_can_get_updated_to_current_username_for_a_user()
    {
        $john = create(User::class);

        // john want to change his username to current username
        $this->patch($john->path() . '/username', [
            'username' => $john->username
        ])->assertSessionDoesntHaveErrors(['username']);
        // validation: unique:users,username,' . $user->id
        // ignore $user->id record in controller when check for validation
    }

}
