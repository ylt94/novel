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

Route::get('/', 'Common\IndexController@index');
Route::get('/novel/{novel_id}','Common\IndexController@novelDetail');
Route::get('/chapters/{novel_id}','Common\IndexController@novelChapters');
Route::get('/content/{chapter_id}','Common\IndexController@novelContent');
Route::get('/content/next/{chapter_id}','Common\IndexController@nextContent');

Route::get('test',function(){
    $a = 1;
    $b = $a+$a+$a++;
    echo $b;

    $a = 1;
    $b = $a + $a++ + $a;
    echo $b;

    $a = 1;
    $b = $a++ + $a+$a;
    echo $b;

    $a = 1;
    $b = $a+$a++;
    echo $b;
});

