<?php

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
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->post('/user/login', 'UserController@weappLogin');
    $api->group(['middleware' => 'CheckWxSkey'], function ($api) {
        $api->resource('record', 'RecordController'); // 记录
        $api->get('user', 'UserController@index'); // 我的
        $api->get('relation', 'RelationController@index'); // 关系管理
    });
});
