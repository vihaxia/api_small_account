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

//接管路由··
$api = app('Dingo\Api\Routing\Router');

// 配置api版本和路由
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1\Controller'], function ($api) {
    Route::post('/user/login', 'UserController@weappLogin');
    Route::any('/wechat', 'WeChatController@serve');  // 微信相关交互路由
});
