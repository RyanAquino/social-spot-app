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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function() {
    Route::post('signup', 'RegisterController');
    Route::post('signin', 'SignInController');
    Route::post('signout', 'SignOutController');
    Route::get('me', 'MeController@user');
});


// List posts
Route::get('posts', 'PostController@index');
// Create a post
Route::post('posts', 'PostController@store');
// Like a post
Route::put('posts/{id}/like', 'PostController@like');
// Comment on post
Route::post('posts/{id}/comment', 'PostController@comment');


//get comment of a post
Route::get('posts/{id}/comments', 'CommentController@getPostComments');


//user
Route::get('user/profile', 'Auth\MeController@index');
Route::post('user/profile/update', 'Auth\MeController@update');
Route::get('user/posts', 'Auth\MeController@get_posts');
Route::get('user/friends', 'Auth\MeController@myFriends');


