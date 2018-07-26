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

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth:api'],function(){
    Route::group(['namespace'=>'Novel','prefix'=>'novel'],function(){
        Route::get('/categories','NovelCategoryController@getCategory');
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::get('/test',function(){
    return ['status'=>1,'password'=>bcrypt(123456)];
});
