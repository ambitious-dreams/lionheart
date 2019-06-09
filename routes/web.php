<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Home page
Route::get('api/index', ['uses' => 'HomeController@index', 'as' => 'home.index']);

// Login through providers
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider')->name('login.provider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('login.provider-callback');

// Logout
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Comments
Route::resource('api/comments', 'CommentsController', [
    'only' => ['index', 'store']
]);
Route::get('api/get-more-comments', ['uses' => 'CommentsController@getMore', 'as' => 'comments.getMore']);