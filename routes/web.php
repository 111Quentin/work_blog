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

//后台路由部分
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'],function (){
    //后台注册页面
    Route::get('register','RegisterController@index');
    Route::post('register','RegisterController@register');
    //后台登录页面
    Route::get('login','LoginController@index');
    Route::post('login','LoginController@login');
});




//匿名函数路由
Route::get('/', function () {
    return view('welcome');
});
