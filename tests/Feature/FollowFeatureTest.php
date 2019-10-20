<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FollowFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_member_can_follow_another_member()
    {
        $this->withoutExceptionHandling();

        $iman = $this->signIn();

        $john = factory(User::class)->create();

        // iman want follow john , iman click on this link
        $this->post('/members/' . $john->id);

        $this->assertDatabaseHas('followings', [
            'follower' => $iman->id,
            'following' => $john->id
        ]);
        // check: in followings table in this columns is iman follow john ?

        $this->assertTrue($iman->isFollowing($john));
        // isFollowing() method in User model
    }
}
