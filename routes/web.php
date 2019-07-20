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
    Route::resource('record', 'RecordController');
    Route::get('user', 'UserController@index');
});
