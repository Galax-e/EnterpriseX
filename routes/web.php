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
    Route::get('project/{p_id}/team/{t_id}/agile_board', 'AgileBoardController@index');
    Route::post('project/{p_id}/team/{t_id}/create_todo', 'AgileBoardController@createTodo');
    Route::get('project/{p_id}/team/{t_id}/delete_todo',  'AgileBoardController@deleteTodo');
    Route::get('project/{p_id}/team/{t_id}/update_todo_status',  'AgileBoardController@updateTodoStatus');
    // Issue tracker
    Route::get('raise_ticket',  'AgileBoardController@issueTracker');
    Route::get('create_ticket',  'AgileBoardController@createTicket');
    Route::get('delete_ticket',  'AgileBoardController@deleteTicket');
    // Module or Team
    Route::get('projects',  ['as' => 'projects', 'uses' => 'AgileBoardController@projects']);
    Route::get('project/{id}/teams',  'AgileBoardController@project_teams');
    Route::post('create_project',  'AgileBoardController@create_project');
    Route::get('teams',  'AgileBoardController@teams');
    Route::get('project/{p_id}/team/{t_id}/team_detail',  'AgileBoardController@team_detail');
    Route::post('project/{id}/create_team',  'AgileBoardController@create_team');
    Route::get('new_member',  'AgileBoardController@new_member');
    Route::post('add_file',  'AgileBoardController@add_file');
    Route::get('teams_board',  'AgileBoardController@teams_board');
});

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
    // Backpack\MenuCRUD
    CRUD::resource('menu-item', 'MenuItemCrudController');
    CRUD::resource('client', 'ClientCrudController');
    CRUD::resource('project', 'ProjectCrudController');
    CRUD::resource('team', 'TeamCrudController');
});

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);