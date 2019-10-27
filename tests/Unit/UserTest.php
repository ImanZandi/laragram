<?php

namespace Tests\Unit;

use App\Laragram\Following\FollowingStatusManager;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_may_has_many_posts()
    {
        $this->withoutExceptionHandling();

        $user = $this->signIn();

        $post = factory(Post::class)->create(); // make post/record in Post model

        $this->assertInstanceOf(Collection::class, $user->posts);
        // check: in User model in posts() method have some records of this user?
        // one user have many records , Collection

    }

    /** @test **/
    public function it_can_follow_another_user()
    {
        $john = $this->signIn(); // $john == User model

        $jane = factory(User::class)->create(); // make user

        $john->follow($jane); // follow() method in User model

        $this->assertTrue($john->followers->contains($jane));
        // check: in followers() method in User model exist $jane ?
    }

    /** @test **/
    public function it_may_have_many_followers()
    {
        $john = $this->signIn(); // $john == User model

        $jane = factory(User::class)->create(); // make user

        $john->follow($jane); // follow() method in User model

        $this->assertInstanceOf(Collection::class, $john->followers);
        // $john->followers == followers() method in User model
        // check: is john followers a collection ?
    }

    /** @test **/
    public function it_may_have_many_followings()
    {
        $john = $this->signIn(); // $john == User model

        $jane = factory(User::class)->create(); // make user

        $john->follow($jane); // follow() method in User model

        $this->assertInstanceOf(Collection::class, $jane->followings);
    }

    /** @test **/
    public function it_can_check_if_is_following_someone_else()
    {
        $john = $this->signIn(); // $john == User model

        $jane = factory(User::class)->create(); // make user

        $john->follow($jane); // follow() method in User model

        $this->assertTrue($john->hasRequestedFollowing($jane));
        // isFollowing() method in User model
    }

    /** @test **/
    public function it_can_decline_a_following_request()
    {
        $iman = $this->signIn();

        $sina = factory(User::class)->create();

        $sina->follow($iman);

        $iman->decline($sina);

        $this->assertDatabaseHas('followings', [
            'follower' => $sina->id,
            'following' => $iman->id,
            'status' => FollowingStatusManager::STATUS_DECLINED
        ]);

    }

    /** @test **/
    public function it_can_check_if_a_user_has_declined()
    {
        $iman = $this->signIn();

        $sina = factory(User::class)->create();

        $sina->follow($iman);

        $iman->decline($sina);

        $this->assertTrue($iman->hasDeclined($sina));
    }
}
