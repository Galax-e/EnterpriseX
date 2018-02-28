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
    Route::post('create_todo',  'AgileBoardController@createTodo');
    Route::get('delete_todo',  'AgileBoardController@deleteTodo');
    Route::get('move_todo',  'AgileBoardController@moveTodo');
    // Issue tracker
    Route::get('raise_ticket',  'AgileBoardController@issueTracker');
    Route::get('create_ticket',  'AgileBoardController@createTicket');
    Route::get('delete_ticket',  'AgileBoardController@deleteTicket');

    // Module or Team
    Route::get('team',  'AgileBoardController@team');
    Route::get('team_detail',  'AgileBoardController@team_detail');
    Route::get('create_team',  'AgileBoardController@create_team');
    Route::get('new_member',  'AgileBoardController@new_member');
    Route::post('add_file',  'AgileBoardController@add_file');
    Route::get('teams_board',  'AgileBoardController@teams_board');
    
});