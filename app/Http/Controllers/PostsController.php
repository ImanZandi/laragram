<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function store()
    {
        // for test
        request()->validate([
            // 'name attr' => must be
            'image' => 'required|file|image|mimes:jpeg,png,gif'
        ]);
        // image key is null in test file
        // image key has incorrect format in test file
        // so data is not valid then session set for error alert automatic
        // 'image' key above set for name of error !!!!!

        // dd(request()->all()); // an array with 'image' key has $image in it
        // dd(request()->all('image')); // 'image' is array key
        // dd(request()->file('image')->hashName());
        // result: "IWsiAoRVtASXAQfkeKFhnRIzOFEJPQLSypJM5bPr.jpeg"
        $filePath = request()->file('image')
            ->storeAs('/images', request()->file('image')->hashName(), 'public');
        // storeAs(path, name of file, storage disk)
        // store in public/images/ folder
        // storage/framework/testing/disks/public/images/test.jpg , send from test file
        // storage/app/public/images/test.jpg , send from browser , send from form

        // dd($filePath); // "images/7PwUD3XmizxZqXaF0JXNWHY8uwQSpnxF40cfphED.jpeg"
        /*
        $post = Post::create([
            // 'column' => value
            'path' => $filePath,
            'owner_id' => auth()->id()
        ]); // save to db
        */
        // or
        $post = auth()->user()->posts()->create([
            'path' => $filePath
        ]); // owner_id column fill automatic

        // request need response in FileUploader.vue
        if (request()->wantsJson()) {
            return $post;
            // Object { path: "images/CcQILzWJThbKQYYuzuKhZ7bFAKeTxSksAsvMHePE.jpeg", updated_at: "2019-10-06 16:08:20", created_at: "2019-10-06 16:08:20", id: 5 }
        }

        return back();
    }
}
