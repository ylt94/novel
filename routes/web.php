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

Route::get('test',function(){
    $input = file_get_contents('php://stdin');
    $cfg = json_decode($input, true);dd($cfg);
});

Route::get('websocket',function(){
    return view('websocket');
});

