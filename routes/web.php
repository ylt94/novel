<?php
use Illuminate\Http\Request;

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

Route::get('/', 'Client\ClientController@index');
Route::get('/novel/{novel_id}','Client\ClientController@novelDetail');
Route::get('/chapters/{novel_id}','Client\ClientController@novelChapters');
Route::get('/content/{chapter_id}','Client\ClientController@novelContent');
Route::get('/content/next/{chapter_id}','Client\ClientController@nextContent');
Route::get('/content/last/{chapter_id}','Client\ClientController@lastContent');

Route::post('/login','Member\LoginController@login');
Route::post('/register','Member\LoginController@register');
Route::get('/loginout','Member\LoginController@loginOut');

Route::get('/bookshelf','Member\BooksController@memberBooks');
Route::get('/addbook/{novel_id}','Member\BooksController@addBook');


Route::get('/login',function(){
    return view('client.login');
});
Route::get('/register',function(){
    return view('client.register');
});

Route::get('/register',function(){
    return view('client.register');
});

Route::get('/resume',function(){
    return view('resume');
});

Route::get('test',function(Request $request){
    ob_end_clean();//清空（擦除）缓冲区并关闭输出缓冲
    ob_implicit_flush(1);//将打开或关闭绝对（隐式）刷送。绝对（隐式）刷送将导致在每次输出调用后有一次刷送操作，以便不再需要对 flush() 的显式调用
    $i = 100;
    for($a = 0;$a<9;$a++){
        ++$i;
        //部分浏览器需要内容达到一定长度了才输出
        if ($i === 103) {
            echo 'a';
        } else {
            echo 'b';
        }
        sleep(1);
    }

});

Route::get('websocket',function(){
    return view('websocket');
});

