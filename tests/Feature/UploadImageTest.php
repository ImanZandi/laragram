<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadImageTest extends TestCase
{
    use RefreshDatabase; // any time you run tests records in db replace to new record

    /** @test **/
    public function a_user_can_upload_an_image_and_make_a_new_post()
    {
        $this->withoutExceptionHandling(); // dont handle exceptions/conditions , show errors

        // for store/upload
        // Given we have a storage for saving images , and we have an image
        Storage::fake('public'); // fake storage
        // storage/framework/testing/disks/public/
        $image = UploadedFile::fake()->image('test.jpeg'); // fake uploaded image

        // When
        $this->post('/posts', [
            // 'name attr' => value
            'image' => $image
        ]);
        // a user upload an image with post method and send it to '/posts'
        // send image to '/posts' for upload/store

        // Then
        $this->assertCount(1, Storage::disk('public')->files('images'));
        // check condition
        // in 'public' storage we have one image
        // files in storage is one item
        // check condition in public folder then images folder
        // storage/framework/testing/disks/public/images/test.jpg
        // check: if an image exist in this directory , test result

        $this->assertDatabaseHas('posts', [
            // 'column in db' => value
           'path' => 'images/' . $image->hashName()
        ]);
        // check: in posts table in path column image exist with this value?
        // UUyKHEAS95Bk8LFt98Y6Ct5PZo7LKZDYWrePcMbR.jpeg
    }

    /** @test **/
    public function an_image_is_required_for_creating_a_new_post()
    {
        // Storage::disk('public'); // content of public disk

        // for validation
        $this->post('/posts', [
           'image' => null
        ])->assertSessionHasErrors(['image']);
        // check: session has error with 'image' name? , test result
        // session set when image key is null in PostsController store() method, data not valid
        // 'image' is error name , 'image' key in errors array
    }

    /** @test **/
    public function an_image_should_have_a_proper_format()
    {
        // for validation
        $this->post('/posts', [
           'image' => UploadedFile::fake()->create('test.pdf') // fake uploaded file
        ])->assertSessionHasErrors(['image']);
        // check: session has error with 'image' name? , test result
        // session set when image format is not valid in PostsController store() method
        // 'image' key set for error name in PostsController store() method
    }

    /** @test **/
    public function a_user_can_see_an_uploaded_image()
    {
        $this->withoutExceptionHandling(); // show errors

        Storage::fake('public'); // fake storage
        // storage/framework/testing/disks/public/
        $image = UploadedFile::fake()->image('test.jpeg'); // fake uploaded image

        $this->post('/posts', [
            // 'name attr' => value
            'image' => $image
        ]);

        // go to index() method in PostsController then go to view
        $this->get('/posts')->assertSee($image->hashName());
        // check: image exist with this name in that view?
        // image name: UUyKHEAS95Bk8LFt98Y6Ct5PZo7LKZDYWrePcMbR.jpeg

    }

}
