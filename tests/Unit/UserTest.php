<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_may_has_many_posts()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory(Post::class)->create(); // make post/record in Post model

        $this->assertInstanceOf(Collection::class, $user->posts);
        // check: in User model in posts() method have some records of this user?
        // one user have many records , Collection

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    /*
    public function testExample()
    {
        $this->assertTrue(true);
    } */
}
