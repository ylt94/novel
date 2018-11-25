<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

Route::post('/member/register','Member\LoginController@register');
Route::post('/member/login','Member\LoginController@login');
//Route::middleware('auth:api')->get('auth/logout','Auth\LoginController@logout');

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth:api'],function(){
    Route::group(['namespace'=>'Novel','prefix'=>'novel'],function(){
        Route::get('/categories','NovelCategoryController@getCategory');
        Route::post('/categories-addorupdate','NovelCategoryController@categoryAddOrUpdate');
        Route::post('/categories-del','NovelCategoryController@categoryDel');
        Route::post('/categories-sort','NovelCategoryController@categorySort');

        Route::get('/novels','NovelController@getNovles');
        Route::post('/novels-update','NovelController@updateNovle');
        Route::post('/novels-del','NovelController@delNovel');
        Route::post('/novels-chapters','NovelController@novelChapters');
        Route::post('/novels-content','NovelController@chapterContent');
        Route::post('/novels-content-update','NovelController@updateNovelContent');

    });

    Route::group(['namespace'=>'Set','prefix'=>'site'],function(){
        Route::get('/sites','NovelSiteCotroller@siteSelect');
        Route::post('/sites-del','NovelSiteCotroller@siteDel');
        Route::post('/sites-update','NovelSiteCotroller@siteUpdate');
        Route::post('/sites-add','NovelSiteCotroller@siteAdd');
    });

    Route::group(['namespace'=>'Set','prefix'=>'process'],function(){
        Route::get('/processes','ProcessController@processList');
        Route::post('/process-add','ProcessController@addProcess');
        Route::post('/process-update','ProcessController@updateProcess');
        Route::get('/process-del','ProcessController@delProcess');
        Route::get('/process-start','ProcessController@startProcess');
        Route::get('/process-stop','ProcessController@stopProcess');
    });

    Route::group(['namespace'=>'Member','prefix'=>'member'],function(){
        Route::get('/members','MemberController@members');
        Route::get('/disabled','MemberController@disabled');
    });

});

Route::group(['namespace'=>'Member','prefix'=>'member','middleware'=>'auth:member'],function(){
    Route::get('/books','BooksController@memberBooks');
    Route::post('/add-book','NovelCategoryController@addBook');
    Route::post('/del-book','NovelCategoryController@delBook');
    Route::post('/loginout','LoginController@loginOut');
});

Route::get('/search','Common\IndexController@search');
Route::get('/search/chapters/{novel_id}','Common\IndexController@searchChapters');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::get('/test','Admin\Reptilian\BiQuController@test');
Route::get('/phpinfo',function(Request $request){
    // $ch = curl_init();
    // //$url = 'http://120.78.183.163/api/test';
    // $url = 'http://117.191.11.80:8080';
    // $header = array(
    //     'CLIENT-IP:58.68.44.61',
    //     'X-FORWARDED-FOR:58.68.44.61',
    //     'CLIENT-IP:58.68.44.61'
    // );
    // // curl_setopt($ch, CURLOPT_PROXY, '117.191.11.80'); //代理服务器地址   
    // // curl_setopt($ch, CURLOPT_PROXYPORT,'8080'); //代理服务器端口
    // curl_setopt($ch, CURLOPT_REFERER, 'http://www.baidu.com/');//模拟来路
    // curl_setopt($ch, CURLOPT_URL, $url); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER,false); 
    // $page_content = curl_exec($ch); 
    // $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
    // $error = curl_error($ch);
    // curl_close($ch); dd($error);
    // echo $page_content;
    phpinfo();
});
// Route::get('/test',function(){
//     return ['status'=>1,'password'=>bcrypt(123456)];
// });
