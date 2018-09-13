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

Route::post('/member/register','Member/LoginController@register');
Route::post('/member/login','Member/LoginController@login');

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth:api'],function(){
    Route::group(['namespace'=>'Novel','prefix'=>'novel'],function(){
        Route::get('/categories','NovelCategoryController@getCategory');
        Route::post('/categories-addorupdate','NovelCategoryController@categoryAddOrUpdate');
        Route::post('/categories-del','NovelCategoryController@categoryDel');
        Route::post('/categories-sort','NovelCategoryController@categorySort');
    });
    Route::group(['namespace'=>'Site','prefix'=>'site'],function(){
        Route::get('/sites','NovelCategoryController@siteSelect');
        Route::post('/sites-del','NovelCategoryController@siteDel');
        Route::post('/sites-update','NovelCategoryController@siteUpdate');
        Route::post('/sites-add','NovelCategoryController@siteAdd');
    });
});

Route::group(['namespace'=>'Member','prefix'=>'member','middleware'=>'auth:member'],function(){
    Route::get('/books','BooksController@memberBooks');
    Route::post('/add-book','NovelCategoryController@addBook');
    Route::post('/del-book','NovelCategoryController@delBook');
    Route::post('/loginout','LoginController@loginOut');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::get('/test','Admin\Reptilian\QiDianController@getNovelBase');

// Route::get('/test',function(){
//     return ['status'=>1,'password'=>bcrypt(123456)];
// });
