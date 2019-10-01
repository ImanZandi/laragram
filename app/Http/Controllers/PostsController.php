<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('posts.index');
    }

    public function store()
    {
        // for test
        request()->validate([
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
        // storage/framework/testing/disks/public/images/test.jpg

        // dd($filePath); // "images/7PwUD3XmizxZqXaF0JXNWHY8uwQSpnxF40cfphED.jpeg"
        Post::create([
            // 'column' => value
            'path' => $filePath
        ]); // save to db
    }
}
