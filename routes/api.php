<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Login and Registration
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
    Route::post('signup', 'RegisterController');
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
});

// Post Actions
Route::get('posts', 'PostController@index');
Route::post('posts', 'PostController@store');
Route::put('posts/{id}/like', 'PostController@like');
Route::post('posts/{id}/comment', 'PostController@comment');

// Comment / Reply
Route::get('posts/{id}/comments', 'CommentController@getPostComments');
Route::post('posts/comments/{id}/reply', 'ReplyController@store');
Route::get('posts/comments/{id}/reply', 'ReplyController@show');

//User
Route::group(['prefix' => 'user', 'namespace' => 'Auth'], function() {
    Route::get('profile', 'MeController@user');
    Route::post('profile/update', 'MeController@update');
    Route::get('posts', 'MeController@getUserPosts');
    Route::get('friends', 'MeController@userFriends');
});
