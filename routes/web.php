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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// TEAM WORKS ---------------------------------------------------------------------------------------------------------------------------
Route::get('/team', ['as'=>'team','uses' => 'TeamController@index']);
Route::get('/team/works/{date}', ['as'=>'works','uses' => 'TeamController@works']);
Route::get('/team/works', ['as'=>'works','uses' => 'TeamController@works']);
Route::get('/team/{bl}/add', ['as'=>'works','uses' => 'TeamController@dayAdd']);
Route::get('/team/{bl}/sub', ['as'=>'works','uses' => 'TeamController@daySub']);
Route::get('/usercheck', ['as'=>'apicheck','uses' => 'TeamController@api']);
Route::get('/apireceiv', ['as'=>'apireceiv','uses' => 'TeamController@apireceiv']);