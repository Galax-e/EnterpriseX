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

Route::get('/', 'GuestController@welcome')->name('welcome');

// Route::get('/', function () {
//     # method 1
//     // $server = explode('.', Request::server('HTTP_HOST'));
//     // $subdomain = $server[0];
//     // $name = DB::table('users')->where('username', $subdomain)->get(); 
//     // dd($name) or die('User not in system'); 

//     # method 2
//     $url = parse_url(URL::current()); 
//     $domain = explode('.', $url['host']); 
//     $subdomain = $domain[0]; 
//     $name = DB::table('users')->where('username', $subdomain)->get(); 
//     dd($name) or die('User not in system'); 
//     // write the rest of your code.
// });

Route::get('/activate-account/{token}', 'GuestController@verify')->name('activate-account');

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::group(['middleware' => ['auth.basic']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    // auth route  ['as' => 'agile_board',        'uses' => 'AgileBoardController@index']
    
    // Tasks and Issues
    Route::get('project/{p_id}/team/{t_id}/team_board', 'TeamController@team_board');
    Route::get('project/{p_id}/team/{t_id}/issue_board', 'TeamController@issue_board');
    Route::post('project/{p_id}/team/{t_id}/create_task', 'TaskController@createTask');
    Route::get('project/{p_id}/team/{t_id}/delete_task',  'TaskController@deleteTask');
    Route::get('project/{p_id}/team/{t_id}/update_task_status',  'TaskController@updateTaskStatus');
    
    Route::get('raise_ticket',  'TaskController@issueTracker');
    Route::get('create_ticket',  'TaskController@createIssue');
    Route::get('delete_ticket',  'TaskController@deleteIssue');
    //Organization
    Route::post('create_organization', 'OrganizationController@create_organization');
    // Project 
    Route::get('projects',  ['as' => 'projects', 'uses' => 'ProjectController@projects']);
    Route::post('create_project',  'ProjectController@create_project');
    
    // Team
    Route::get('teams',  'TeamController@teams');
    Route::get('project/{id}/teams',  'TeamController@project_teams');
    Route::get('project/{p_id}/team/{t_id}/team_detail',  'TeamController@team_detail');
    Route::post('project/{id}/create_team',  'TeamController@create_team');
    Route::get('teams_board',  'TeamController@teams_board');
    // user
    Route::get('new_member',  'UserController@new_member');
    // file
    Route::post('add_file',  'FileController@add_file');
});

// to be used in the future, so that each organization can access their page using
// a subdomain with the organization name e.g. org_name.enterprisex.com.
Route::domain('{account}.localhost')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
    Route::get('/', function($account) {
        
        if (Auth::check() && Auth::user()->username === $account) {
            dd('user authenticated');
        }
        dd($account);
    });
});

Route::group(['prefix' => config('backpack.base.route_prefix', 'admin'), 'middleware' => ['web', 'admin', 'auth', 'admin.basic:admin'], 'namespace' => 'Admin'], function () {
    // Backpack\MenuCRUD

    // Route::redirect('/dashboard', '/', 301);
    // $server = request()->path(); // Request::segment(1); //explode('.', Request::server('HTTP_HOST'));
    // if(strpos($server, 'admin') !== false){
    //     Route::get('/', function() {
    //         return  redirect()->route('admin');
    //     });
    // }  
    
    // Route::get('/', function() {
    //     // return  redirect()->route('/dashboard');
    // });
   

    // if not otherwise configured, setup the dashboard routes
    if (config('backpack.base.setup_dashboard_routes')) {
        Route::get('dashboard', 'AdminController@dashboard')->name('backpack.dashboard');
        Route::get('/', 'AdminController@redirect')->name('backpack');
    }

    // if not otherwise configured, setup the "my account" routes
    if (config('backpack.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'Auth\MyAccountController@getAccountInfoForm')->name('backpack.account.info');
        Route::post('edit-account-info', 'Auth\MyAccountController@postAccountInfoForm');
        Route::get('change-password', 'Auth\MyAccountController@getChangePasswordForm')->name('backpack.account.password');
        Route::post('change-password', 'Auth\MyAccountController@postChangePasswordForm');
    }
    
    CRUD::resource('menu-item', 'MenuItemCrudController');
    CRUD::resource('client', 'ClientCrudController');
    CRUD::resource('project', 'ProjectCrudController');
    CRUD::resource('team', 'TeamCrudController');
    CRUD::resource('organization', 'OrganizationCrudController');
    CRUD::resource('setting', 'SettingCrudController');
});

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);



