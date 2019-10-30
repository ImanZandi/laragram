<?php

Route::get('/posts', 'PostsController@index')->middleware('auth');
Route::post('/posts', 'PostsController@store')->middleware('auth');
Route::delete('/posts/{post}', 'PostsController@destroy')->middleware('auth');
Route::post('/members/{user}', 'FollowingsController@store');
Route::post('/followers/{user}/decline', 'FollowersController@destroy');
Route::post('/followers/{user}/accept', 'FollowersController@store');
Route::patch('/users/{user}/username', 'UsernameController@update');
Route::get('/users/search', 'SearchController@show');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
