<?php

Route::get('/posts', 'PostsController@index')->middleware('auth');
Route::post('/posts', 'PostsController@store')->middleware('auth');
Route::delete('/posts/{post}', 'PostsController@destroy')->middleware('auth');
Route::post('/members/{user}', 'FollowingsController@store');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
