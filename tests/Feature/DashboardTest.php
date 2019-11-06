<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function an_authenticated_user_can_have_a_panel()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class);

        $this->get($user->path())->assertSee($user->name);

    }
}
