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
    return redirect('/calendar');
});
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('loginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Auth::routes();


Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/articles', 'CategorieController@index')->name('as400');

// TEAM WORKS ---------------------------------------------------------------------------------------------------------------------------
Route::get('/team', ['as'=>'team','uses' => 'TeamController@index']);
Route::get('/team/{id}/{date}', ['as'=>'updatedElementDate','uses' => 'TeamController@updateDate']);
Route::get('/team/get/work/{semaine}', ['as'=>'searchwork','uses' => 'TeamController@searchWork']);
Route::get('/team/{semaine}/{id}/{order}/{dayNumber}', ['as'=>'updatedElement','uses' => 'TeamController@updateColumn']);
Route::get('/team/works/{date}', ['as'=>'works','uses' => 'TeamController@works']);
Route::get('/calendar', ['as'=>'works','uses' => 'TeamController@works']);
Route::get('/team/{bl}/add', ['as'=>'works','uses' => 'TeamController@dayAdd']);
Route::get('/team/{bl}/sub', ['as'=>'works','uses' => 'TeamController@daySub']);
Route::get('/usercheck', ['as'=>'apicheck','uses' => 'TeamController@api']);
Route::get('/apireceiv', ['as'=>'apireceiv','uses' => 'TeamController@apireceiv']);

Route::get('/fiches', ['as'=>'ficheall','uses' => 'FicheController@all']);
Route::get('/delais/add/{bl}/{dt}', ['as'=>'ficheall','uses' => 'DelaisController@add']);