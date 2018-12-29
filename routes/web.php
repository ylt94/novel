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
Route::get('/error',function(){
    return view('client.error');
});

Route::get('test',function(){
    // $a = 1;
    // $b = $a+$a+$a++;
    // echo $b;

    // $a = 1;
    // $b = $a + $a++ + $a;
    // echo $b;

    // $a = 1;
    // $b = $a++ + $a+$a;
    // echo $b;

    // $a = 1;
    // $b = $a+$a++;
    // echo $b;
    //return view('resume');
});

