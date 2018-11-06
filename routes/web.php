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
    //return view('welcome');
    return view('client.index');
    //echo "盗用IP者，死全家，请三思!!!";
});
Route::get('/novel/{novel_id}','Common\IndexController@novelDetail');

Route::get('/chapters/{novel_id}','Common\IndexController@novelChapters');
Route::get('/content/{chapter_id}','Common\IndexController@novelContent');