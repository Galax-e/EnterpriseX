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

Route::group(['middleware' => ['auth.basic']], function () {
    // auth route  ['as' => 'agile_board',        'uses' => 'AgileBoardController@index']
    Route::get('agile_board', ['as' => 'agile_board','uses' => 'AgileBoardController@index']);
    Route::get('create_todo',  'AgileBoardController@createTodo');
    Route::get('delete_todo',  'AgileBoardController@deleteTodo');
    Route::get('move_todo',  'AgileBoardController@moveTodo');
    
});