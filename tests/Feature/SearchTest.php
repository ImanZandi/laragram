<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_user_can_search_for_other_users_by_their_name_username_or_email()
    {
        $this->withoutExceptionHandling();

        config(['scout.driver' => 'algolia']); // enable algolia sync for this test
        // in config/scout.php set 'driver' key to 'algolia'
        // we disabled SCOUT_DRIVER in phpunit.xml , SCOUT_DRIVER = null for all test , for run all tests quickly

        $search = 'foobar';

        // create(User::class, [], 2); // [] == use factory defaults columns values
        create(User::class, ['name' => 'john', 'email' => 'john@doe.com', 'username' => 'john-foobar']);
        create(User::class, ['name' => 'Mr.foobar']);
        create(User::class, ['email' => 'myfoobar@gmail.com']);
        // factory(User::class)->create(['username' => 'parisfoobar']);
        // or
        // create(User::class, ['username' => 'parisfoobar']);
        // or , you can use state()
        $user = factory(User::class)->state('username')->create(['username' => 'foobar-24']);
        // ->state('state name')
        // User model can't generate hashed username when we set it manually before in factory
        // dd($user->username); // "parisfoobar"

        // $any = factory(User::class)->state('username')->create();
        // dd($any->username); // "white.jada" , random username create

        do {
            sleep(0.25);
            $result = $this->getJson("/users/search?q=$search")->json()['data'];
            // ->json(['data']) our result is in 'data' key
            // 'data' key create when we use ->paginate() in SearchController in show method
            // dd(($result));
        } while (count($result) !== 3);
        // use do-while because for receive all response/users from algolia site

        // dd($result);
        // dump(User::all()->toArray());
        $this->assertCount(3, $result);

        User::latest()->take(4)->unsearchable();
        // delete this random users form algolia site , remove index

        // $this->artisan('scout:import', ['import' => 'App\User']);
        // Artisan::call('scout:import');

    }
}
