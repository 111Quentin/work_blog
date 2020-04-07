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

Route::get('/', "Admin\LoginController@index");

//后台路由部分
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function (){
    //后台注册
    Route::get('register','RegisterController@index');
    Route::post('register','RegisterController@register');
    //后台登录
    Route::get('login','LoginController@index');
    Route::post('login','LoginController@login');
    Route::get('logout','LoginController@logout');
});

//需要登录才能进入的路由
Route::group(['middleware' => 'auth:web','namespace' => 'Admin'],function (){
    Route::get('posts', 'PostController@index');
});







