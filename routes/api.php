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
Route::get('/phpinfo',function(){
    return json_encode($silver = [
        'type' => '现金收款',
        'total_num'=>0,
        'total_money'=>'0.00',
        'refund_money'=>'0.00',
        'refund_num'=>0
    ]);
    //print_r(phpinfo());exit;
    // try {
    //     $con = new PDO('mysql:host=mysql;dbname=novel', 'root', 'root');
    //     $con->query('SET NAMES UTF8');
    //     $res =  $con->query('select * from novel_category');
    //     while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    //         echo "id:{$row['id']} name:{$row['name']}";
    //     }
    // } catch (PDOException $e) {
    //      echo '错误原因：'  . $e->getMessage();
    // }
    //extension = pdo_mysql.so
    //docker-php-ext-pdo_mysql.ini
});
// Route::get('/test',function(){
//     return ['status'=>1,'password'=>bcrypt(123456)];
// });
