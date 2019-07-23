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

Route::get('/weapp/login',"LoginController@login");


Route::middleware('check.wxskey')->group(function () {
    Route::get('/weapp/user',"LoginController@user");
    Route::resource('record', 'RecordController'); // 记录
    Route::get('user', 'UserController@index'); // 我的
    Route::get('relation', 'RelationController@index'); // 关系管理
});
