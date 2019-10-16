<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteUploadedImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function guests_can_not_delete_a_post()
    {
        $post = factory(Post::class)->create();

        $this->delete('/posts/' . $post->id)->assertRedirect('login');

    }

    /** @test **/
    public function a_user_can_delete_his_own_post()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $post = factory(Post::class)->create(['owner_id' => auth()->id()]); // make post

        $this->assertDatabaseHas('posts', ['path' => $post->path]); // Optional
        // check: $post->path exist in 'path' column in posts table ?

        $this->delete('/posts/' . $post->id)->assertRedirect('/posts');
        // go to controller with delete method , send record id , /posts/id
        // check: redirected to /posts ?

        $this->assertDatabaseMissing('posts', ['path' => $post->path]);
        // check: $post->path deleted form 'path' column in posts table ?
    }

    /** @test **/
    public function a_user_can_not_delete_other_users_post()
    {
        $david = $this->signIn();

        $john = factory(User::class)->create(['name' => 'john']);

        $post = factory(Post::class)->create(['owner_id' => $john->id]);

        $this->delete('/posts/' . $post->id)->assertStatus(403);
        // check : abort(403) ?
    }
}
