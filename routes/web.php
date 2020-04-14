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

Route::get('/', "Auth\LoginController@showLoginForm");

//后台路由部分
Route::group(['prefix' => 'admin', 'namespace' => 'Auth'],function (){
    //后台注册
    Route::get('register','RegisterController@showRegistrationForm');
    Route::post('register','RegisterController@register')->middleware('terminate');
    //后台登录
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('login','LoginController@login')->middleware('terminate');
    Route::get('logout','LoginController@logout');
});

//需要登录才能进入的路由
Route::group(['middleware' => 'auth:web','namespace' => 'Admin'],function (){
    Route::get('posts', 'PostController@index');
    Route::get('/posts/create', 'PostController@create');
    Route::post('/posts', 'PostController@store')->middleware('post');
    Route::get('/posts/search', 'PostController@search');
    Route::get('/posts/{post}', 'PostController@show');
    Route::get('/posts/{post}/edit', 'PostController@edit');
    Route::get('/posts/{post}/delete', 'PostController@destroy')->middleware('post');
    Route::put('/posts/{post}', 'PostController@update')->middleware('post');
});







