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
Route::get('/novel',function(){
    return view('client.novel');
});

Route::get('/detail',function(){
    return view('client.detail');
});
Route::get('/content',function(){
    return view('client.content');
});

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