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
        $user = create(User::class, ['username' => 'parisfoobar']);
        // dd($user->fresh()->toArray());
        // username not set to 'parisfoobar' , show hashed value

        $result = $this->getJson("/users/search?q=$search")->json();

        $this->assertCount(3, $result);

    }
}
