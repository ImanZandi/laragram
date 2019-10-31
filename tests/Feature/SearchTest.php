<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_search_for_other_users_by_their_name_username_or_email()
    {
        $this->withoutExceptionHandling();

        $search = 'foobar';

        create(User::class, [], 2); // [] == use factory defaults columns values
        create(User::class, ['name' => 'Mr.foobar']);
        create(User::class, ['email' => 'myfoobar@gmail.com']);
        // factory(User::class)->create(['username' => 'parisfoobar']);
        // or
        // create(User::class, ['username' => 'parisfoobar']);
        // or , you can use state()
        $user = factory(User::class)->state('username')->create(['username' => 'parisfoobar']);
        // ->state('state name')
        // User model can't generate hashed username when we set it manually before in factory
        // dd($user->username); // "parisfoobar"

        // $any = factory(User::class)->state('username')->create();
        // dd($any->username); // "white.jada" , random username create

        $result = $this->getJson("/users/search?q=$search")->json();
        // dd($result);
        // dump(User::all()->toArray());
        $this->assertCount(3, $result);

    }
}
