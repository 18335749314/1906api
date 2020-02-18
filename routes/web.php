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
    return view('welcome');
});
Route::get('/phpinfo',function(){
	phpinfo();
});
//测试
Route::get('test/redis','TestController@testRedis');

Route::prefix('api')->group(function (){
    Route::get('/user/info','Api\UserController@info');
    Route::post('/user/reg','Api\UserController@reg');
    Route::any('/user/curl1','Api\UserController@curl1');
    Route::any('/user/guzzle1','Api\UserController@guzzle1');
    Route::any('/user/curl2','Api\UserController@curl2');
    Route::any('/user/guzzle2','Api\UserController@guzzle2');

    Route::any('/test/getUrl','Api\TestController@getUrl');
    Route::any('/test/redisStrr1','Api\TestController@redisStrr1');
});

Route::prefix('goods')->group(function (){
    Route::any('/shop','Goods\GoodsController@shop');
    Route::any('/count1','Goods\GoodsController@count1');
    Route::any('/api3','Goods\GoodsController@api3')->middleware('api.filter');
    Route::any('/api2','Goods\GoodsController@api2')->middleware('api.filter');
});
