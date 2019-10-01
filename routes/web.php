<?php

Route::get('/posts', 'PostsController@index');
Route::post('/posts', 'PostsController@store');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
