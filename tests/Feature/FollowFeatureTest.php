<?php

namespace Tests\Feature;

use App\Laragram\Following\FollowingStatusManager;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
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

        $this->assertTrue($iman->hasRequestedFollowing($john));
        // hasRequestedFollowing() method in User model
    }

    /** @test **/
    public function after_sending_a_follow_request_the_request_should_get_accepted_to_establish()
    {
        $this->withoutExceptionHandling();

        $sina = $this->signIn();

        $iman = factory(User::class)->create();

        $this->post('/members/' . $iman->id);

        $this->assertDatabaseHas('followings', [
            'follower' => $sina->id,
            'following' => $iman->id,
            'status' => FollowingStatusManager::STATUS_SUSPENDED
        ]);
        // when sina follow iman the request of sina set to suspended status
    }

    /** @test **/
    public function after_sending_a_request_the_follower_may_decline_the_request()
    {
        $this->withoutExceptionHandling();

        $iman = $this->signIn(); // auth user

        $sina = factory(User::class)->create(); // sina signed in before

        $sina->follow($iman);
        // iman move to sina's followings and request status set to suspended

        $this->assertTrue($sina->hasRequestedFollowing($iman));
        // is sina sent follow request to iman ? : YES

        $this->post('/followers/' . $sina->id . '/decline'); // auth users can click
        // iman click on this link to decline sina's request

        // dd(DB::table('followings')->get()->toArray());

        $this->assertTrue($iman->hasDeclined($sina));
        // is iman declined sina's request ?

        $this->assertFalse($sina->hasRequestedFollowing($iman));
        // is sina sent follow request to iman ? : NO
        // request declined by iman
    }

    /** @test **/
    public function a_user_can_accept_another_user_following_request()
    {
        $this->withoutExceptionHandling();

        $iman = $this->signIn();

        $sina = factory(User::class)->create();

        $sina->follow($iman);

        $this->post('/followers/' . $sina->id . '/accept');
        // iman accept sina's request

        $this->assertTrue($sina->isFollowing($iman));

        $this->assertDatabaseHas('followings', [
            'follower' => $sina->id,
            'following' => $iman->id,
            'status' => FollowingStatusManager::STATUS_ACCEPTED
        ]);
    }
}
